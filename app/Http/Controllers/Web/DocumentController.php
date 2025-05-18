<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the student's documents
     */
    public function index()
    {
        // Get documents - in a real app, this would come from a database
        $documents = $this->getDocuments();
        
        // Group documents by category
        $financialDocuments = collect($documents)->filter(function ($doc) {
            return $doc['category'] === 'Financial';
        })->all();
        
        $academicDocuments = collect($documents)->filter(function ($doc) {
            return $doc['category'] === 'Academic';
        })->all();
        
        $administrativeDocuments = collect($documents)->filter(function ($doc) {
            return $doc['category'] === 'Administrative';
        })->all();
        
        return view('documents.index', compact(
            'documents', 
            'financialDocuments', 
            'academicDocuments', 
            'administrativeDocuments'
        ));
    }
    
    /**
     * Show a specific document
     */
    public function show($id)
    {
        $documents = $this->getDocuments();
        
        // Find the document by ID
        $document = collect($documents)->firstWhere('id', $id);
        
        if (!$document) {
            return redirect()->route('documents.index')
                ->with('error', 'Document not found');
        }
        
        return view('documents.show', compact('document'));
    }
    
    /**
     * Download a document
     */
    public function download($id)
    {
        $documents = $this->getDocuments();
        
        // Find the document by ID
        $document = collect($documents)->firstWhere('id', $id);
        
        if (!$document) {
            return redirect()->route('documents.index')
                ->with('error', 'Document not found');
        }
        
        // In a real application, we would retrieve the file from storage and return it
        // For this demo, we'll just redirect back with a success message
        return redirect()->route('documents.index')
            ->with('success', "Document '{$document['title']}' would be downloaded in a real application");
    }
    
    /**
     * Get mock documents data
     */
    private function getDocuments()
    {
        return [
            [
                'id' => 'doc-1',
                'title' => 'Spring 2023 Tuition Statement',
                'category' => 'Financial',
                'date' => '2023-01-10',
                'file_type' => 'PDF',
                'file_size' => '245 KB',
                'description' => 'Detailed breakdown of Spring 2023 semester tuition and fees',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-2',
                'title' => 'Financial Aid Award Letter',
                'category' => 'Financial',
                'date' => '2023-01-15',
                'file_type' => 'PDF',
                'file_size' => '320 KB',
                'description' => 'Official award letter detailing financial aid for the 2022-2023 academic year',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-3',
                'title' => 'Payment Receipt - Spring 2023',
                'category' => 'Financial',
                'date' => '2023-01-25',
                'file_type' => 'PDF',
                'file_size' => '156 KB',
                'description' => 'Receipt for payment made towards Spring 2023 tuition',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-4',
                'title' => 'Academic Transcript',
                'category' => 'Academic',
                'date' => '2023-05-20',
                'file_type' => 'PDF',
                'file_size' => '415 KB',
                'description' => 'Official academic transcript showing all completed courses and grades',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-5',
                'title' => 'Fall 2022 Grade Report',
                'category' => 'Academic',
                'date' => '2022-12-20',
                'file_type' => 'PDF',
                'file_size' => '210 KB',
                'description' => 'Official grade report for Fall 2022 semester',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-6',
                'title' => 'Course Registration Confirmation',
                'category' => 'Academic',
                'date' => '2023-01-05',
                'file_type' => 'PDF',
                'file_size' => '185 KB',
                'description' => 'Confirmation of registered courses for Spring 2023',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-7',
                'title' => 'Student ID Card Application',
                'category' => 'Administrative',
                'date' => '2022-09-01',
                'file_type' => 'PDF',
                'file_size' => '175 KB',
                'description' => 'Application form for student identification card',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-8',
                'title' => 'Housing Assignment Letter',
                'category' => 'Administrative',
                'date' => '2022-08-15',
                'file_type' => 'PDF',
                'file_size' => '195 KB',
                'description' => 'Official housing assignment for the 2022-2023 academic year',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-9',
                'title' => 'Scholarship Acceptance Form',
                'category' => 'Financial',
                'date' => '2022-07-30',
                'file_type' => 'PDF',
                'file_size' => '230 KB',
                'description' => 'Signed acceptance form for academic scholarship',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-10',
                'title' => 'Student Meal Plan Contract',
                'category' => 'Administrative',
                'date' => '2022-08-20',
                'file_type' => 'PDF',
                'file_size' => '205 KB',
                'description' => 'Contract for campus meal plan services',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-11',
                'title' => 'W-2 Tax Form (2022)',
                'category' => 'Financial',
                'date' => '2023-01-31',
                'file_type' => 'PDF',
                'file_size' => '175 KB',
                'description' => 'Tax form for on-campus employment wages',
                'status' => 'Available'
            ],
            [
                'id' => 'doc-12',
                'title' => '1098-T Tuition Statement (2022)',
                'category' => 'Financial',
                'date' => '2023-01-31',
                'file_type' => 'PDF',
                'file_size' => '190 KB',
                'description' => 'Tax form reporting qualified education expenses',
                'status' => 'Available'
            ],
        ];
    }
} 