@extends('layouts.app')

@section('title', 'Documents - Student Portal')

@section('page_title', 'Documents')

@section('content')
<div class="space-y-6">
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
            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center justify-center"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Upload Document
        </button>
    </div>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Transcript Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="transcript">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">Official Transcript - Spring 2023</h3>
                    <p class="text-sm text-gray-500">Transcript</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 05/15/2023</span>
                        <span>•</span>
                        <span>2.3 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- Form Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="form">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">Course Registration Form</h3>
                    <p class="text-sm text-gray-500">Form</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 04/20/2023</span>
                        <span>•</span>
                        <span>1.2 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- Certificate Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="certificate">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">Web Development Certificate</h3>
                    <p class="text-sm text-gray-500">Certificate</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 03/10/2023</span>
                        <span>•</span>
                        <span>3.1 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- Form Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="form">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">Scholarship Application Form</h3>
                    <p class="text-sm text-gray-500">Form</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 02/15/2023</span>
                        <span>•</span>
                        <span>1.8 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- Transcript Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="transcript">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">Official Transcript - Fall 2022</h3>
                    <p class="text-sm text-gray-500">Transcript</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 01/10/2023</span>
                        <span>•</span>
                        <span>2.1 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- Certificate Document -->
        <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow document-card" data-type="certificate">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">JavaScript Programming Certificate</h3>
                    <p class="text-sm text-gray-500">Certificate</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <span>Uploaded: 12/05/2022</span>
                        <span>•</span>
                        <span>2.7 MB</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm flex items-center hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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