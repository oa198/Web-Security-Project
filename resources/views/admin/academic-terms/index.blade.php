@extends('layouts.admin')

@section('title', 'Academic Terms')
@section('page-title', 'Academic Terms')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Academic Terms</h2>
        
        @can('create', App\Models\AcademicTerm::class)
        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md" 
            id="create-term-btn" data-modal="create-term-modal">
            <i class="fas fa-plus mr-2"></i> Add Term
        </button>
        @endcan
    </div>
    
    <!-- Alert Messages -->
    <div id="alert-container" class="mb-6"></div>
    
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="filter-year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                <select id="filter-year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Years</option>
                    <!-- Years will be populated via JS -->
                </select>
            </div>
            <div>
                <label for="filter-term-type" class="block text-sm font-medium text-gray-700">Term Type</label>
                <select id="filter-term-type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="fall">Fall</option>
                    <option value="spring">Spring</option>
                    <option value="summer">Summer</option>
                    <option value="winter">Winter</option>
                </select>
            </div>
            <div>
                <label for="filter-status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="filter-status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Academic Terms Table -->
    <div class="bg-white rounded-lg shadow relative">
        <div id="loading-overlay" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
            <div class="spinner-border text-blue-500" role="status">
                <span class="sr-only">Loading...</span>
                <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name & Code
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dates
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Registration
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="terms-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Table content will be loaded via JS -->
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Loading academic terms...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t" id="pagination-container">
            <!-- Pagination will be added via JS -->
        </div>
    </div>
</div>

<!-- Create Term Modal -->
<div id="create-term-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-50 px-4 py-3 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                        Add New Academic Term
                    </h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form id="create-term-form">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Term Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="name-error"></span>
                        </div>
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Term Code</label>
                            <input type="text" id="code" name="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="code-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                            <input type="text" id="academic_year" name="academic_year" placeholder="e.g. 2025-2026" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="academic_year-error"></span>
                        </div>
                        <div>
                            <label for="term_type" class="block text-sm font-medium text-gray-700">Term Type</label>
                            <select id="term_type" name="term_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select Term Type</option>
                                <option value="fall">Fall</option>
                                <option value="spring">Spring</option>
                                <option value="summer">Summer</option>
                                <option value="winter">Winter</option>
                            </select>
                            <span class="text-red-500 text-xs error-message" id="term_type-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="start_date-error"></span>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="end_date-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="registration_start_date" class="block text-sm font-medium text-gray-700">Registration Start</label>
                            <input type="date" id="registration_start_date" name="registration_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="registration_start_date-error"></span>
                        </div>
                        <div>
                            <label for="registration_end_date" class="block text-sm font-medium text-gray-700">Registration End</label>
                            <input type="date" id="registration_end_date" name="registration_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="registration_end_date-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="add_drop_deadline" class="block text-sm font-medium text-gray-700">Add/Drop Deadline</label>
                            <input type="date" id="add_drop_deadline" name="add_drop_deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="add_drop_deadline-error"></span>
                        </div>
                        <div>
                            <label for="withdrawal_deadline" class="block text-sm font-medium text-gray-700">Withdrawal Deadline</label>
                            <input type="date" id="withdrawal_deadline" name="withdrawal_deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="withdrawal_deadline-error"></span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <span class="text-red-500 text-xs error-message" id="description-error"></span>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Set as active term
                        </label>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-2">
                    <button type="button" class="close-modal bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Save Term
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Term Modal Template (will be cloned and populated via JS) -->
<div id="edit-term-modal-template" class="hidden">
    <div id="edit-term-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Same structure as create modal, but for editing -->
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modals
    initModals();
    
    // Load academic terms
    loadAcademicTerms();
    
    // Setup filter listeners
    document.getElementById('filter-year').addEventListener('change', loadAcademicTerms);
    document.getElementById('filter-term-type').addEventListener('change', loadAcademicTerms);
    document.getElementById('filter-status').addEventListener('change', loadAcademicTerms);
    
    // Form submission handler for creating a term
    document.getElementById('create-term-form').addEventListener('submit', function(e) {
        e.preventDefault();
        createTerm();
    });
    
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }
    
    function initModals() {
        // Code to initialize modals (already handled in modal component)
    }
    
    function loadAcademicTerms(page = 1) {
        // Show loading overlay
        document.getElementById('loading-overlay').style.display = 'flex';
        
        // Get filter values
        const year = document.getElementById('filter-year').value;
        const termType = document.getElementById('filter-term-type').value;
        const status = document.getElementById('filter-status').value;
        
        // Build query parameters
        let queryParams = `?page=${page}`;
        if (year) queryParams += `&academic_year=${year}`;
        if (termType) queryParams += `&term_type=${termType}`;
        if (status) queryParams += `&is_active=${status === 'active' ? 1 : 0}`;
        
        // Fetch academic terms from API
        axios.get(`/admin/academic-terms${queryParams}`)
            .then(response => {
                const { data } = response;
                
                // Hide loading overlay
                document.getElementById('loading-overlay').style.display = 'none';
                
                // Populate academic years filter if not already
                if (!document.getElementById('filter-year').options.length > 1) {
                    populateYearsFilter(data.years || []);
                }
                
                // Render terms table
                renderTermsTable(data.data);
                
                // Render pagination
                renderPagination(data);
            })
            .catch(error => {
                console.error('Error fetching academic terms:', error);
                
                // Hide loading overlay
                document.getElementById('loading-overlay').style.display = 'none';
                
                // Show error message
                showAlert('error', 'Failed to load academic terms. Please try again later.');
            });
    }
    
    function populateYearsFilter(years) {
        const yearSelect = document.getElementById('filter-year');
        years.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        });
    }
    
    function renderTermsTable(terms) {
        const tableBody = document.getElementById('terms-table-body');
        
        if (!terms || terms.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No academic terms found.
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        terms.forEach(term => {
            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${term.name}</div>
                        <div class="text-xs text-gray-500">${term.code}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${formatDate(term.start_date)} - ${formatDate(term.end_date)}</div>
                        <div class="text-xs text-gray-500">${term.academic_year} ${term.term_type.charAt(0).toUpperCase() + term.term_type.slice(1)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${formatDate(term.registration_start_date)} - ${formatDate(term.registration_end_date)}</div>
                        <div class="text-xs text-gray-500">Add/Drop: ${formatDate(term.add_drop_deadline)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${term.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                            ${term.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @can('update', App\Models\AcademicTerm::class)
                        <button type="button" class="text-indigo-600 hover:text-indigo-900 mr-3" onclick="editTerm(${term.id})">
                            Edit
                        </button>
                        @endcan
                        
                        @can('delete', App\Models\AcademicTerm::class)
                        <button type="button" class="text-red-600 hover:text-red-900" onclick="deleteTerm(${term.id})">
                            Delete
                        </button>
                        @endcan
                    </td>
                </tr>
            `;
        });
        
        tableBody.innerHTML = html;
    }
    
    function renderPagination(data) {
        const paginationContainer = document.getElementById('pagination-container');
        
        if (!data.meta || data.meta.total <= data.meta.per_page) {
            paginationContainer.innerHTML = '';
            return;
        }
        
        const { current_page, last_page } = data.meta;
        
        let html = `
            <nav class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">${(current_page - 1) * data.meta.per_page + 1}</span> to 
                        <span class="font-medium">${Math.min(current_page * data.meta.per_page, data.meta.total)}</span> of 
                        <span class="font-medium">${data.meta.total}</span> results
                    </p>
                </div>
                <div>
                    <ul class="flex space-x-2">
        `;
        
        // Previous page button
        html += `
            <li>
                <button 
                    ${current_page === 1 ? 'disabled' : 'onclick="loadAcademicTerms(' + (current_page - 1) + ')"'}
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md ${current_page === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50'}"
                >
                    Previous
                </button>
            </li>
        `;
        
        // Page numbers (simplified)
        let startPage = Math.max(1, current_page - 2);
        let endPage = Math.min(last_page, current_page + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li>
                    <button 
                        onclick="loadAcademicTerms(${i})"
                        class="relative inline-flex items-center px-4 py-2 border ${i === current_page ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'} text-sm font-medium rounded-md"
                    >
                        ${i}
                    </button>
                </li>
            `;
        }
        
        // Next page button
        html += `
            <li>
                <button 
                    ${current_page === last_page ? 'disabled' : 'onclick="loadAcademicTerms(' + (current_page + 1) + ')"'}
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md ${current_page === last_page ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50'}"
                >
                    Next
                </button>
            </li>
        `;
        
        html += `
                    </ul>
                </div>
            </nav>
        `;
        
        paginationContainer.innerHTML = html;
    }
    
    function createTerm() {
        // Reset error messages
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
        });
        
        // Get form data
        const formData = new FormData(document.getElementById('create-term-form'));
        const termData = Object.fromEntries(formData.entries());
        
        // Convert is_active to boolean
        termData.is_active = formData.has('is_active');
        
        // Create term via API
        axios.post('/admin/academic-terms', termData)
            .then(response => {
                // Close modal
                document.getElementById('create-term-modal').classList.add('hidden');
                
                // Show success message
                showAlert('success', 'Academic term created successfully!');
                
                // Reload terms
                loadAcademicTerms();
                
                // Reset form
                document.getElementById('create-term-form').reset();
            })
            .catch(error => {
                console.error('Error creating term:', error);
                
                if (error.response && error.response.data && error.response.data.errors) {
                    // Display validation errors
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(field => {
                        const errorElement = document.getElementById(`${field}-error`);
                        if (errorElement) {
                            errorElement.textContent = errors[field][0];
                        }
                    });
                } else {
                    // Show general error
                    showAlert('error', 'Failed to create academic term. Please try again.');
                }
            });
    }
    
    // Function to show an alert message
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alert-container');
        
        const alertClass = type === 'success' 
            ? 'bg-green-100 border-green-400 text-green-700' 
            : 'bg-red-100 border-red-400 text-red-700';
            
        const alertHtml = `
            <div class="${alertClass} px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">${message}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        alertContainer.innerHTML = alertHtml;
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.querySelector('div[role="alert"]');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
    
    // Make these functions globally accessible
    window.loadAcademicTerms = loadAcademicTerms;
    window.editTerm = function(id) {
        // Implementation for editing a term
        console.log('Edit term:', id);
        // Fetch term details, populate edit form, show edit modal
    };
    window.deleteTerm = function(id) {
        // Implementation for deleting a term
        if (confirm('Are you sure you want to delete this academic term? This action cannot be undone.')) {
            axios.delete(`/admin/academic-terms/${id}`)
                .then(response => {
                    showAlert('success', 'Academic term deleted successfully!');
                    loadAcademicTerms();
                })
                .catch(error => {
                    console.error('Error deleting term:', error);
                    
                    if (error.response && error.response.data && error.response.data.message) {
                        showAlert('error', error.response.data.message);
                    } else {
                        showAlert('error', 'Failed to delete academic term. Please try again.');
                    }
                });
        }
    };
});
</script>
@endsection
