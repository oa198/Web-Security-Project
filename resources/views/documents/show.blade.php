@extends('layouts.main')

@section('title', $document['title'] . ' - Student Portal')

@section('page-title', 'Documents')

@section('content')
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('documents.index') }}" class="ml-1 text-gray-500 hover:text-gray-700 md:ml-2">Documents</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 md:ml-2 truncate">{{ $document['title'] }}</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex justify-between items-start">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-gray-100 rounded-lg mr-4">
                        @if($document['file_type'] === 'PDF')
                            <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        @elseif($document['file_type'] === 'DOC' || $document['file_type'] === 'DOCX')
                            <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        @else
                            <svg class="h-8 w-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $document['title'] }}</h2>
                        <p class="text-gray-600 mt-1">{{ $document['file_type'] }} • {{ $document['file_size'] }}</p>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('documents.download', $document['id']) }}" class="inline-flex items-center px-4 py-2 border border-primary-300 bg-primary-50 rounded-md shadow-sm text-sm font-medium text-primary-700 hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Share
                    </button>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Document Details</h3>
                        <dl class="mt-2 text-sm text-gray-900">
                            <div class="mt-1">
                                <dt class="inline font-medium text-gray-500">Category:</dt>
                                <dd class="inline ml-1">{{ $document['category'] }}</dd>
                            </div>
                            <div class="mt-1">
                                <dt class="inline font-medium text-gray-500">Date:</dt>
                                <dd class="inline ml-1">{{ \Carbon\Carbon::parse($document['date'])->format('M d, Y') }}</dd>
                            </div>
                            <div class="mt-1">
                                <dt class="inline font-medium text-gray-500">Status:</dt>
                                <dd class="inline ml-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $document['status'] }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-2 text-sm text-gray-900">{{ $document['description'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Document Preview (Placeholder) -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Preview</h3>
            <div class="border rounded-lg p-4 h-96 flex flex-col items-center justify-center bg-gray-50">
                @if($document['file_type'] === 'PDF')
                    <svg class="h-20 w-20 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="1" points="14 2 14 8 20 8"></polyline>
                        <line stroke-linecap="round" stroke-linejoin="round" stroke-width="1" x1="16" y1="13" x2="8" y2="13"></line>
                        <line stroke-linecap="round" stroke-linejoin="round" stroke-width="1" x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="1" points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <p class="mt-4 text-gray-500 text-center">PDF preview is not available.<br>Please download the document to view its contents.</p>
                @else
                    <svg class="h-20 w-20 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                        <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="1" points="13 2 13 9 20 9"></polyline>
                    </svg>
                    <p class="mt-4 text-gray-500 text-center">Document preview is not available.<br>Please download the document to view its contents.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div>
        <!-- Document Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('documents.download', $document['id']) }}" class="flex items-center text-primary-600 hover:text-primary-800">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Document
                </a>
                
                <button class="flex items-center text-primary-600 hover:text-primary-800">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Document
                </button>
                
                <button class="flex items-center text-primary-600 hover:text-primary-800">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email Document
                </button>
                
                <button class="flex items-center text-primary-600 hover:text-primary-800">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Share Document
                </button>
            </div>
        </div>
        
        <!-- Related Documents -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Documents</h3>
            <div class="space-y-4">
                @if($document['category'] === 'Financial')
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Financial Aid Award Letter</h4>
                                <p class="text-xs text-gray-500">Jan 15, 2023 • PDF</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Payment Receipt</h4>
                                <p class="text-xs text-gray-500">Jan 25, 2023 • PDF</p>
                            </div>
                        </div>
                    </a>
                @elseif($document['category'] === 'Academic')
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Course Registration Confirmation</h4>
                                <p class="text-xs text-gray-500">Jan 05, 2023 • PDF</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Grade Report</h4>
                                <p class="text-xs text-gray-500">Dec 20, 2022 • PDF</p>
                            </div>
                        </div>
                    </a>
                @else
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Student ID Card Application</h4>
                                <p class="text-xs text-gray-500">Sep 01, 2022 • PDF</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Housing Assignment Letter</h4>
                                <p class="text-xs text-gray-500">Aug 15, 2022 • PDF</p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 