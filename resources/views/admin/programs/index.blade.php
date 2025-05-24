@extends('layouts.admin')

@section('title', 'Academic Programs')
@section('page-title', 'Academic Programs')

@section('styles')
<style>
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }
    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Academic Programs</h2>
        
        @can('create', App\Models\Program::class)
        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md" 
            id="create-program-btn" data-modal="create-program-modal">
            <i class="fas fa-plus mr-2"></i> Add Program
        </button>
        @endcan
    </div>
    
    <!-- Alert Messages -->
    <div id="alert-container" class="mb-6"></div>
    
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="filter-department" class="block text-sm font-medium text-gray-700">Department</label>
                <select id="filter-department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Departments</option>
                    <!-- Departments will be populated via JS -->
                </select>
            </div>
            <div>
                <label for="filter-level" class="block text-sm font-medium text-gray-700">Program Level</label>
                <select id="filter-level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Levels</option>
                    <option value="undergraduate">Undergraduate</option>
                    <option value="graduate">Graduate</option>
                    <option value="doctoral">Doctoral</option>
                    <option value="certificate">Certificate</option>
                    <option value="diploma">Diploma</option>
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
    
    <!-- Programs Table -->
    <div class="bg-white rounded-lg shadow relative">
        <div id="loading-overlay" class="loading-overlay">
            <div class="loader"></div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Program
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Level
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Credits
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="programs-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Table content will be loaded via JS -->
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Loading academic programs...
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

<!-- Create Program Modal -->
<div id="create-program-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-50 px-4 py-3 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                        Add New Academic Program
                    </h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form id="create-program-form">
                <div class="p-6 space-y-4">
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                        <select id="department_id" name="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Department</option>
                            <!-- Departments will be populated via JS -->
                        </select>
                        <span class="text-red-500 text-xs error-message" id="department_id-error"></span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Program Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="name-error"></span>
                        </div>
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Program Code</label>
                            <input type="text" id="code" name="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="code-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700">Program Level</label>
                            <select id="level" name="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select Level</option>
                                <option value="undergraduate">Undergraduate</option>
                                <option value="graduate">Graduate</option>
                                <option value="doctoral">Doctoral</option>
                                <option value="certificate">Certificate</option>
                                <option value="diploma">Diploma</option>
                            </select>
                            <span class="text-red-500 text-xs error-message" id="level-error"></span>
                        </div>
                        <div>
                            <label for="credit_hours" class="block text-sm font-medium text-gray-700">Credit Hours</label>
                            <input type="number" id="credit_hours" name="credit_hours" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="credit_hours-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="duration_years" class="block text-sm font-medium text-gray-700">Duration (Years)</label>
                            <input type="number" id="duration_years" name="duration_years" min="0.5" step="0.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="duration_years-error"></span>
                        </div>
                        <div>
                            <label for="tuition_fee" class="block text-sm font-medium text-gray-700">Tuition Fee (Optional)</label>
                            <input type="number" id="tuition_fee" name="tuition_fee" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="text-red-500 text-xs error-message" id="tuition_fee-error"></span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <span class="text-red-500 text-xs error-message" id="description-error"></span>
                    </div>
                    
                    <div>
                        <label for="admission_requirements" class="block text-sm font-medium text-gray-700">Admission Requirements</label>
                        <textarea id="admission_requirements" name="admission_requirements" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <span class="text-red-500 text-xs error-message" id="admission_requirements-error"></span>
                    </div>
                    
                    <div>
                        <label for="graduation_requirements" class="block text-sm font-medium text-gray-700">Graduation Requirements</label>
                        <textarea id="graduation_requirements" name="graduation_requirements" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <span class="text-red-500 text-xs error-message" id="graduation_requirements-error"></span>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Program is active
                        </label>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-2">
                    <button type="button" class="close-modal bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Save Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modals
    initModals();
    
    // Load departments for filter and form
    loadDepartments();
    
    // Load academic programs
    loadPrograms();
    
    // Setup filter listeners
    document.getElementById('filter-department').addEventListener('change', loadPrograms);
    document.getElementById('filter-level').addEventListener('change', loadPrograms);
    document.getElementById('filter-status').addEventListener('change', loadPrograms);
    
    // Form submission handler for creating a program
    document.getElementById('create-program-form').addEventListener('submit', function(e) {
        e.preventDefault();
        createProgram();
    });
    
    function initModals() {
        // Initialize modal functionality
        // (Already handled by the modal component)
    }
    
    function loadDepartments() {
        // Show loading overlay
        document.getElementById('loading-overlay').style.display = 'flex';
        
        // Fetch departments from API
        axios.get('/api/departments')
            .then(response => {
                const departments = response.data;
                
                // Populate department dropdowns
                populateDepartmentDropdown('filter-department', departments);
                populateDepartmentDropdown('department_id', departments);
                
                // Hide loading overlay if programs are already loaded
                if (document.getElementById('programs-table-body').children.length > 1) {
                    document.getElementById('loading-overlay').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching departments:', error);
                
                // Hide loading overlay
                document.getElementById('loading-overlay').style.display = 'none';
                
                // Show error message
                showAlert('error', 'Failed to load departments. Please try again later.');
            });
    }
    
    function populateDepartmentDropdown(elementId, departments) {
        const dropdown = document.getElementById(elementId);
        
        // Clear existing options except the first one
        while (dropdown.options.length > 1) {
            dropdown.remove(1);
        }
        
        // Add department options
        departments.forEach(department => {
            const option = document.createElement('option');
            option.value = department.id;
            option.textContent = department.name;
            dropdown.appendChild(option);
        });
    }
    
    function loadPrograms(page = 1) {
        // Show loading overlay
        document.getElementById('loading-overlay').style.display = 'flex';
        
        // Get filter values
        const departmentId = document.getElementById('filter-department').value;
        const level = document.getElementById('filter-level').value;
        const status = document.getElementById('filter-status').value;
        
        // Build query parameters
        let queryParams = `?page=${page}`;
        if (departmentId) queryParams += `&department_id=${departmentId}`;
        if (level) queryParams += `&level=${level}`;
        if (status) queryParams += `&is_active=${status === 'active' ? 1 : 0}`;
        
        // Fetch programs from API
        axios.get(`/api/admin/programs${queryParams}`)
            .then(response => {
                const { data } = response;
                
                // Hide loading overlay
                document.getElementById('loading-overlay').style.display = 'none';
                
                // Render programs table
                renderProgramsTable(data.data);
                
                // Render pagination
                renderPagination(data);
            })
            .catch(error => {
                console.error('Error fetching programs:', error);
                
                // Hide loading overlay
                document.getElementById('loading-overlay').style.display = 'none';
                
                // Show error message
                showAlert('error', 'Failed to load academic programs. Please try again later.');
            });
    }
    
    function renderProgramsTable(programs) {
        const tableBody = document.getElementById('programs-table-body');
        
        if (!programs || programs.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No academic programs found.
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        programs.forEach(program => {
            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${program.name}</div>
                        <div class="text-xs text-gray-500">${program.code}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${program.department ? program.department.name : 'N/A'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${program.level.charAt(0).toUpperCase() + program.level.slice(1)}</div>
                        <div class="text-xs text-gray-500">${program.duration_years} years</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${program.credit_hours}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${program.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                            ${program.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @can('update', App\Models\Program::class)
                        <a href="{{ route('admin.programs.edit', '') }}/${program.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Edit
                        </a>
                        @endcan
                        
                        <a href="{{ route('admin.programs.show', '') }}/${program.id}" class="text-blue-600 hover:text-blue-900">
                            View
                        </a>
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
                    ${current_page === 1 ? 'disabled' : 'onclick="loadPrograms(' + (current_page - 1) + ')"'}
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
                        onclick="loadPrograms(${i})"
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
                    ${current_page === last_page ? 'disabled' : 'onclick="loadPrograms(' + (current_page + 1) + ')"'}
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
    
    function createProgram() {
        // Reset error messages
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
        });
        
        // Get form data
        const formData = new FormData(document.getElementById('create-program-form'));
        const programData = Object.fromEntries(formData.entries());
        
        // Convert is_active to boolean
        programData.is_active = formData.has('is_active');
        
        // Create program via API
        axios.post('/api/admin/programs', programData)
            .then(response => {
                // Close modal
                document.getElementById('create-program-modal').classList.add('hidden');
                
                // Show success message
                showAlert('success', 'Academic program created successfully!');
                
                // Reload programs
                loadPrograms();
                
                // Reset form
                document.getElementById('create-program-form').reset();
            })
            .catch(error => {
                console.error('Error creating program:', error);
                
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
                    showAlert('error', 'Failed to create academic program. Please try again.');
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
    window.loadPrograms = loadPrograms;
});
</script>
@endsection
