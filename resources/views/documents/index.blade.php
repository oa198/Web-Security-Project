@extends('layouts.app')

@section('title', 'Documents - Student Portal')

@section('page_title', 'Documents')

@section('content')
<div class="space-y-6">
    <!-- Flash Messages and Debug Info -->
    @if(session('success') || session('error') || session('info'))
    <div class="mb-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-2" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif
        
        {{-- Debug information removed --}}
    </div>
    @endif
    <!-- Header with upload button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            <button 
                id="all-btn"
                class="px-4 py-2 rounded-lg bg-primary-100 text-primary-800"
                onclick="filterDocuments('all')"
            >
                All
            </button>
            <button 
                id="transcripts-btn"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
                onclick="filterDocuments('transcript')"
            >
                Transcripts
            </button>
            <button 
                id="forms-btn"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
                onclick="filterDocuments('form')"
            >
                Forms
            </button>
            <button 
                id="certificates-btn"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200"
                onclick="filterDocuments('certificate')"
            >
                Certificates
            </button>
        </div>
        <button 
            onclick="openUploadModal()"
            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center justify-center"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Upload Document
        </button>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Upload Document
                            </h3>
                            <div class="mt-4">
                                <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    </div>
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <option value="">Select type</option>
                                            <option value="transcript">Transcript</option>
                                            <option value="form">Form</option>
                                            <option value="certificate">Certificate</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="document" class="block text-sm font-medium text-gray-700">File</label>
                                        <input type="file" name="document" id="document" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    </div>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <button id="upload-btn" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Upload
                                        </button>
                                        <button type="button" onclick="closeUploadModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $document)
            <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="{{ $document->type }}">
                <div class="flex items-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 @if($document->type === 'transcript') text-blue-500 @elseif($document->type === 'form') text-purple-500 @elseif($document->type === 'certificate') text-green-500 @else text-gray-400 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">{{ $document->title }}</h3>
                        <p class="text-sm text-gray-500">{{ ucfirst($document->type) }}</p>
                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                            <span>Uploaded: {{ $document->created_at->format('m/d/Y') }}</span>
                            <span>•</span>
                            <span>{{ $document->file_size }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    <a href="{{ asset('storage/' . $document->file_path) }}" class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50" download>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 py-8">
                No documents found.
            </div>
        @endforelse
    </div>
</div>

<script>
    // When the document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Set up the upload form with validation and submit handler
        const uploadForm = document.querySelector('form[action="{{ route('documents.upload') }}"]');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                // Get form elements
                const titleInput = document.getElementById('title');
                const typeSelect = document.getElementById('type');
                const fileInput = document.getElementById('document');
                
                // Basic validation
                if (!titleInput.value.trim()) {
                    e.preventDefault();
                    alert('Please enter a document title');
                    return false;
                }
                
                if (!typeSelect.value) {
                    e.preventDefault();
                    alert('Please select a document type');
                    return false;
                }
                
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a file to upload');
                    return false;
                }
                
                // Show loading indicator
                document.getElementById('upload-btn').textContent = 'Uploading...';
                document.getElementById('upload-btn').disabled = true;
                
                // Let the form submit normally
                return true;
            });
        }
    });
    
    function openUploadModal() {
        const modal = document.getElementById('uploadModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Reset form if it exists
        const uploadForm = document.querySelector('form[action="{{ route('documents.upload') }}"]');
        if (uploadForm) {
            uploadForm.reset();
        }
        
        // Reset button state
        const uploadBtn = document.getElementById('upload-btn');
        if (uploadBtn) {
            uploadBtn.textContent = 'Upload';
            uploadBtn.disabled = false;
        }
    }

    function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('uploadModal');
        if (event.target === modal) {
            closeUploadModal();
        }
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeUploadModal();
        }
    });

    function filterDocuments(type) {
        // Reset all buttons
        document.getElementById('all-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('all-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('transcripts-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('transcripts-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('forms-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('forms-btn').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('certificates-btn').classList.remove('bg-primary-100', 'text-primary-800');
        document.getElementById('certificates-btn').classList.add('bg-gray-100', 'text-gray-600');
        
        // Set active button
        if (type === 'all') {
            document.getElementById('all-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('all-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (type === 'transcript') {
            document.getElementById('transcripts-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('transcripts-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (type === 'form') {
            document.getElementById('forms-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('forms-btn').classList.remove('bg-gray-100', 'text-gray-600');
        } else if (type === 'certificate') {
            document.getElementById('certificates-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('certificates-btn').classList.remove('bg-gray-100', 'text-gray-600');
        }
        
        // Filter document cards
        const documentCards = document.querySelectorAll('.document-card');
        documentCards.forEach(card => {
            if (type === 'all') {
                card.classList.remove('hidden');
            } else {
                const cardType = card.getAttribute('data-type');
                if (cardType === type) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            }
        });
    }
</script>
@endsection 