<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if the storage link exists and create it if needed
        $this->ensureStorageIsLinked();
        
        // Ensure the documents directory exists
        $this->ensureDocumentsDirectoryExists();
        
        $user = Auth::user();
        $student = $user->student;
        
        // Debug for student relationship
        Log::info('User document page visit', [
            'user_id' => $user->id,
            'has_student' => $student ? 'Yes' : 'No',
            'student_id' => $student ? $student->id : null,
        ]);
        
        // Get documents, force to load them fresh with no caching
        $documents = $student ? $student->documents()->latest()->get()->fresh() : collect();
        
        // Debug document count
        Log::info('Documents loaded', [
            'count' => $documents->count(), 
            'documents' => $documents->pluck('id')->toArray()
        ]);
        
        return view('documents.index', compact('documents'));
    }

    /**
     * Handle document upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Debug - write to a file so we can see request details
        file_put_contents(storage_path('logs/document_upload_debug.txt'), 
            "Upload request received at: " . now() . "\n" . 
            "Request data: " . print_r($request->all(), true) . "\n" . 
            "FILES global: " . print_r($_FILES, true) . "\n", 
            FILE_APPEND
        );

        // Basic validation
        if (!$request->has('title') || !$request->has('type')) {
            return redirect()->back()->with('error', 'Missing required form fields.');
        }
        
        // Check if file was uploaded
        if (!isset($_FILES['document']) || $_FILES['document']['error'] != UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
            ];
            
            $errorCode = isset($_FILES['document']) ? $_FILES['document']['error'] : 'UNKNOWN';
            $errorMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'Unknown upload error';
            
            Log::error('File upload failed', [
                'error_code' => $errorCode,
                'error_message' => $errorMessage
            ]);
            
            return redirect()->back()->with('error', 'File upload failed: ' . $errorMessage);
        }
        
        // Validate file type and size
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $fileType = $_FILES['document']['type'];
        $fileSize = $_FILES['document']['size'];
        
        // Log file info
        Log::info('Raw file details', [
            'name' => $_FILES['document']['name'],
            'type' => $fileType,
            'size' => $fileSize,
            'tmp_name' => $_FILES['document']['tmp_name'],
            'error' => $_FILES['document']['error'],
            'tmp_file_exists' => file_exists($_FILES['document']['tmp_name']) ? 'Yes' : 'No',
            'tmp_file_readable' => is_readable($_FILES['document']['tmp_name']) ? 'Yes' : 'No'
        ]);
        
        if ($fileSize > 10485760) { // 10MB limit
            return redirect()->back()->with('error', 'File size exceeds the 10MB limit.');
        }

        // Get the student record associated with the authenticated user
        $user = Auth::user();
        $student = $user->student;

        // If no student record exists, return error
        if (!$student) {
            Log::warning('User attempted to upload document without student record', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            return redirect()->back()->with('error', 'Your student profile needs to be set up before uploading documents. Please complete your profile first.');
        }

        try {
            // Ensure upload directory exists
            $uploadDir = public_path('storage/documents');
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new \Exception('Failed to create upload directory');
                }
            }

            // Generate safe filename
            $originalName = $_FILES['document']['name'];
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
            $destination = $uploadDir . '/' . $filename;
            
            // Direct file copy using PHP's native function
            if (!copy($_FILES['document']['tmp_name'], $destination)) {
                // If copy fails, try file_put_contents
                $content = file_get_contents($_FILES['document']['tmp_name']);
                if ($content === false || file_put_contents($destination, $content) === false) {
                    throw new \Exception('Failed to save the uploaded file using multiple methods');
                }
            }
            
            // Verify the file was actually created
            if (!file_exists($destination)) {
                throw new \Exception('File was not created at the destination');
            }
            
            $path = 'documents/' . $filename;
            
            // Log the file info
            Log::info('Document upload', [
                'original_name' => $_FILES['document']['name'],
                'saved_as' => $filename,
                'mime_type' => $_FILES['document']['type'],
                'size' => $_FILES['document']['size'],
                'path' => $path
            ]);
            
            // Create document record
            $document = $student->documents()->create([
                'title' => $request->title,
                'type' => $request->type,
                'file_path' => $path,
                'file_size' => $this->formatFileSize($_FILES['document']['size']),
                'uploaded_at' => now(),
            ]);

            // Debug document record
            file_put_contents(storage_path('logs/document_upload_debug.txt'), 
                "Document created: " . print_r($document->toArray(), true) . "\n",
                FILE_APPEND
            );

            Log::info('Document uploaded successfully', [
                'user_id' => $user->id,
                'document_id' => $document->id,
                'file_path' => $path
            ]);

            // Simply redirect back with success message
            return redirect()->back()
                ->with('success', 'Document uploaded successfully.');
        } catch (\Exception $e) {
            // Detailed error logging
            file_put_contents(storage_path('logs/document_upload_debug.txt'), 
                "ERROR: {$e->getMessage()}\n" . 
                "Trace: {$e->getTraceAsString()}\n",
                FILE_APPEND
            );
            
            Log::error('Document upload failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    /**
     * Delete a document.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student || $document->student_id !== $student->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // Delete the file from storage
            Storage::disk('public')->delete($document->file_path);
            
            // Delete the record
            $document->delete();

            return redirect()->back()->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Document deletion failed', [
                'user_id' => $user->id,
                'document_id' => $document->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Failed to delete document: ' . $e->getMessage());
        }
    }

    /**
     * Format file size to be human-readable.
     *
     * @param  int  $bytes
     * @return string
     */
    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    /**
     * Ensure the storage:link has been created
     *
     * @return void
     */
    private function ensureStorageIsLinked()
    {
        // Check if the public storage link exists
        $publicStoragePath = public_path('storage');
        $actualStoragePath = storage_path('app/public');
        
        // If the storage directory doesn't exist in public, create it manually
        if (!file_exists($publicStoragePath)) {
            Log::info('Storage link does not exist, creating directory structure');
            
            // Create the directory
            if (!mkdir($publicStoragePath, 0755, true)) {
                Log::error('Failed to create storage directory in public path');
                return;
            }
            
            Log::info('Created storage directory in public path');
        }
    }
    
    /**
     * Ensure the documents directory exists and is writable
     *
     * @return void
     */
    private function ensureDocumentsDirectoryExists()
    {
        // Check storage/app/public/documents
        $storageDocumentsPath = storage_path('app/public/documents');
        if (!file_exists($storageDocumentsPath)) {
            if (!mkdir($storageDocumentsPath, 0755, true)) {
                Log::error('Failed to create documents directory in storage');
            } else {
                Log::info('Created documents directory in storage');
            }
        }
        
        // Check public/storage/documents
        $publicDocumentsPath = public_path('storage/documents');
        if (!file_exists($publicDocumentsPath)) {
            if (!mkdir($publicDocumentsPath, 0755, true)) {
                Log::error('Failed to create documents directory in public storage');
            } else {
                Log::info('Created documents directory in public storage');
            }
        }
    }
}
