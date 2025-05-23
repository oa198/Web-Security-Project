/**
 * Programs Management JavaScript
 * Handles AJAX requests and UI interactions for the programs management page
 */

document.addEventListener('DOMContentLoaded', function() {
    // API URL Constants
    const API_URLS = {
        PROGRAMS: '/api/programs',
        DEPARTMENTS: '/api/admin/departments',
        ADMIN_PROGRAMS: '/api/admin/programs'
    };

    // DOM Elements
    const programsTable = document.querySelector('table tbody');
    const filterDepartment = document.getElementById('filter-department');
    const filterLevel = document.getElementById('filter-level');
    const filterStatus = document.getElementById('filter-status');
    const createProgramBtn = document.getElementById('create-program-btn');
    const createProgramModal = document.getElementById('create-program-modal');
    const loadingOverlay = document.getElementById('loading-overlay');
    const alertContainer = document.getElementById('alert-container');
    
    // Token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    /**
     * Initialize the page
     */
    function init() {
        loadPrograms();
        loadDepartments();
        setupEventListeners();
    }
    
    /**
     * Setup all event listeners
     */
    function setupEventListeners() {
        // Filter changes
        filterDepartment.addEventListener('change', loadPrograms);
        filterLevel.addEventListener('change', loadPrograms);
        filterStatus.addEventListener('change', loadPrograms);
        
        // Create program button
        if (createProgramBtn) {
            createProgramBtn.addEventListener('click', openCreateProgramModal);
        }
        
        // Delegate for edit and delete buttons
        document.addEventListener('click', function(e) {
            // Edit program
            if (e.target.closest('.edit-program-btn')) {
                const programId = e.target.closest('.edit-program-btn').dataset.id;
                window.location.href = `/admin/programs/${programId}/edit`;
            }
            
            // View program
            if (e.target.closest('.view-program-btn')) {
                const programId = e.target.closest('.view-program-btn').dataset.id;
                window.location.href = `/admin/programs/${programId}`;
            }
            
            // Delete program
            if (e.target.closest('.delete-program-btn')) {
                const programId = e.target.closest('.delete-program-btn').dataset.id;
                confirmDeleteProgram(programId);
            }

            // Manage requirements
            if (e.target.closest('.manage-requirements-btn')) {
                const programId = e.target.closest('.manage-requirements-btn').dataset.id;
                window.location.href = `/admin/programs/${programId}/manage-requirements`;
            }
        });
    }
    
    /**
     * Load programs from API with filters
     */
    function loadPrograms() {
        showLoading();
        
        // Build query parameters
        const params = new URLSearchParams();
        if (filterDepartment.value) params.append('department_id', filterDepartment.value);
        if (filterLevel.value) params.append('degree_level', filterLevel.value);
        if (filterStatus.value) params.append('status', filterStatus.value);
        
        // Fetch programs
        fetch(`${API_URLS.ADMIN_PROGRAMS}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            renderPrograms(data.data || data);
            hideLoading();
        })
        .catch(error => {
            console.error('Error fetching programs:', error);
            showAlert('Failed to load programs. Please try again.', 'error');
            hideLoading();
        });
    }
    
    /**
     * Load departments for the filter dropdown
     */
    function loadDepartments() {
        fetch(API_URLS.DEPARTMENTS, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const departments = data.data || data;
            renderDepartmentOptions(departments);
        })
        .catch(error => {
            console.error('Error fetching departments:', error);
        });
    }
    
    /**
     * Render departments in the filter dropdown
     */
    function renderDepartmentOptions(departments) {
        let html = '<option value="">All Departments</option>';
        
        departments.forEach(department => {
            html += `<option value="${department.id}">${department.name}</option>`;
        });
        
        filterDepartment.innerHTML = html;
    }
    
    /**
     * Render programs in the table
     */
    function renderPrograms(programs) {
        if (!programsTable) return;
        
        if (programs.length === 0) {
            programsTable.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">
                        No programs found. Please adjust your filters or create a new program.
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        
        programs.forEach(program => {
            const statusClass = program.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            
            html += `
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-medium">${program.name}</span>
                            <span class="text-sm text-gray-500">${program.code}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        ${program.department ? program.department.name : 'N/A'}
                    </td>
                    <td class="px-6 py-4 capitalize">
                        ${program.degree_level}
                    </td>
                    <td class="px-6 py-4">
                        ${program.credits_required} credits / ${program.duration_years} years
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${program.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <button class="view-program-btn text-blue-600 hover:text-blue-900" data-id="${program.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="edit-program-btn text-indigo-600 hover:text-indigo-900" data-id="${program.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="manage-requirements-btn text-green-600 hover:text-green-900" data-id="${program.id}">
                                <i class="fas fa-list-check"></i>
                            </button>
                            <button class="delete-program-btn text-red-600 hover:text-red-900" data-id="${program.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        programsTable.innerHTML = html;
    }
    
    /**
     * Open the create program modal
     */
    function openCreateProgramModal() {
        if (createProgramModal) {
            // Assuming you have a modal component that can be shown
            // This would depend on your modal implementation
            const modal = new Modal(createProgramModal);
            modal.show();
        }
    }
    
    /**
     * Confirm deletion of a program
     */
    function confirmDeleteProgram(programId) {
        if (confirm('Are you sure you want to delete this program? This action cannot be undone.')) {
            deleteProgram(programId);
        }
    }
    
    /**
     * Delete a program via API
     */
    function deleteProgram(programId) {
        showLoading();
        
        fetch(`${API_URLS.ADMIN_PROGRAMS}/${programId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            showAlert('Program successfully deleted.', 'success');
            loadPrograms();
        })
        .catch(error => {
            console.error('Error deleting program:', error);
            showAlert('Failed to delete program. Please try again.', 'error');
            hideLoading();
        });
    }
    
    /**
     * Show loading overlay
     */
    function showLoading() {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
    }
    
    /**
     * Hide loading overlay
     */
    function hideLoading() {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }
    
    /**
     * Show alert message
     */
    function showAlert(message, type = 'info') {
        if (!alertContainer) return;
        
        const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' :
                          type === 'error' ? 'bg-red-100 border-red-500 text-red-700' :
                          'bg-blue-100 border-blue-500 text-blue-700';
        
        const alertIcon = type === 'success' ? 'fa-check-circle' :
                         type === 'error' ? 'fa-exclamation-circle' :
                         'fa-info-circle';
        
        const alert = `
            <div class="border-l-4 p-4 ${alertClass} relative" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <i class="fas ${alertIcon} mr-3"></i>
                    </div>
                    <div>
                        <p class="font-bold">${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                        <p>${message}</p>
                    </div>
                </div>
                <button type="button" class="absolute top-0 right-0 mt-2 mr-2 text-gray-400 hover:text-gray-900" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        alertContainer.innerHTML = alert;
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alertElement = alertContainer.querySelector('[role="alert"]');
            if (alertElement) {
                alertElement.remove();
            }
        }, 5000);
    }
    
    // Initialize on page load
    init();
});
