@extends('layouts.main')

@section('title', 'My Documents - Student Portal')

@section('page-title', 'Documents')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Documents</h2>
    <p class="text-gray-600 mt-1">
        Access and download your academic and financial documents.
    </p>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6">
    <div class="flex">
        <svg class="h-5 w-5 text-green-400 mr-3 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6">
    <div class="flex">
        <svg class="h-5 w-5 text-red-400 mr-3 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div>
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Document Search and Filters -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Search and Filter Documents</h3>
    <div class="flex flex-wrap gap-4">
        <div class="flex-grow">
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="document-search" name="search" class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search documents...">
            </div>
        </div>

        <div class="sm:flex sm:justify-end gap-4">
            <select id="category-filter" class="block w-full sm:w-auto rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                <option value="all">All Categories</option>
                <option value="Financial">Financial</option>
                <option value="Academic">Academic</option>
                <option value="Administrative">Administrative</option>
            </select>
            
            <select id="date-filter" class="mt-2 sm:mt-0 block w-full sm:w-auto rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                <option value="all">All Time</option>
                <option value="30">Last 30 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last Year</option>
            </select>
        </div>
    </div>
</div>

<!-- Financial Documents -->
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            <span class="inline-flex items-center">
                <svg class="h-5 w-5 text-primary-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Financial Documents
            </span>
        </h3>
        <span class="text-sm text-gray-500">{{ count($financialDocuments) }} documents</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($financialDocuments as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-md bg-gray-100 text-gray-600">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $document['title'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $document['description'] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($document['date'])->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_type'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_size'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('documents.show', $document['id']) }}" class="text-primary-600 hover:text-primary-800 mr-3">
                                View
                            </a>
                            <a href="{{ route('documents.download', $document['id']) }}" class="text-primary-600 hover:text-primary-800">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No financial documents available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Academic Documents -->
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            <span class="inline-flex items-center">
                <svg class="h-5 w-5 text-primary-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                Academic Documents
            </span>
        </h3>
        <span class="text-sm text-gray-500">{{ count($academicDocuments) }} documents</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($academicDocuments as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-md bg-gray-100 text-gray-600">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $document['title'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $document['description'] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($document['date'])->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_type'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_size'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('documents.show', $document['id']) }}" class="text-primary-600 hover:text-primary-800 mr-3">
                                View
                            </a>
                            <a href="{{ route('documents.download', $document['id']) }}" class="text-primary-600 hover:text-primary-800">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No academic documents available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Administrative Documents -->
<div>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            <span class="inline-flex items-center">
                <svg class="h-5 w-5 text-primary-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Administrative Documents
            </span>
        </h3>
        <span class="text-sm text-gray-500">{{ count($administrativeDocuments) }} documents</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($administrativeDocuments as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-md bg-gray-100 text-gray-600">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $document['title'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $document['description'] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($document['date'])->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_type'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $document['file_size'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('documents.show', $document['id']) }}" class="text-primary-600 hover:text-primary-800 mr-3">
                                View
                            </a>
                            <a href="{{ route('documents.download', $document['id']) }}" class="text-primary-600 hover:text-primary-800">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No administrative documents available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Document filtering functionality
    const searchInput = document.getElementById('document-search');
    const categoryFilter = document.getElementById('category-filter');
    const dateFilter = document.getElementById('date-filter');
    const documentRows = document.querySelectorAll('tbody tr');
    
    function filterDocuments() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value;
        const dateValue = parseInt(dateFilter.value);
        
        documentRows.forEach(row => {
            const titleElement = row.querySelector('.text-sm.font-medium.text-gray-900');
            const descriptionElement = row.querySelector('.text-sm.text-gray-500');
            
            if (!titleElement || !descriptionElement) return;
            
            const title = titleElement.textContent.trim().toLowerCase();
            const description = descriptionElement.textContent.trim().toLowerCase();
            const category = row.closest('div.mb-6')?.querySelector('h3')?.textContent.trim();
            
            let matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            let matchesCategory = categoryValue === 'all' || (category && category.includes(categoryValue));
            
            // Date filtering would require more logic with actual dates
            // For now, we'll just assume all match the date filter
            let matchesDate = true;
            
            row.closest('tr').style.display = (matchesSearch && matchesCategory && matchesDate) ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterDocuments);
    categoryFilter.addEventListener('change', filterDocuments);
    dateFilter.addEventListener('change', filterDocuments);
});
</script>
@endsection 