{{-- Admissions Management Partial View --}}
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Admissions Management</h2>
        <div class="flex gap-2">
            <button id="filter-all" onclick="filterApplications('all')" 
                class="px-3 py-1.5 text-sm font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                All
            </button>
            <button id="filter-pending" onclick="filterApplications('pending')" 
                class="px-3 py-1.5 text-sm font-medium rounded-lg bg-purple-600 text-white hover:bg-purple-700">
                Pending
            </button>
            <button id="filter-approved" onclick="filterApplications('approved')" 
                class="px-3 py-1.5 text-sm font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                Approved
            </button>
            <button id="filter-rejected" onclick="filterApplications('rejected')" 
                class="px-3 py-1.5 text-sm font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                Rejected
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Applications List Panel --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-medium text-gray-900 text-lg mb-4">Applications</h3>
                <div class="space-y-2">
                    {{-- Application 1 --}}
                    <button
                        onclick="selectApplication('app001')"
                        id="app-app001"
                        class="w-full flex items-center p-3 rounded-lg transition-colors bg-purple-50 border-purple-200 border"
                    >
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold">
                            SJ
                        </div>
                        <div class="ml-3 text-left flex-1">
                            <p class="font-medium text-gray-900">Sarah Johnson</p>
                            <p class="text-sm text-gray-500">Computer Science</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            pending
                        </span>
                    </button>

                    {{-- Application 2 --}}
                    <button
                        onclick="selectApplication('app002')"
                        id="app-app002"
                        class="w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border"
                    >
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                            MC
                        </div>
                        <div class="ml-3 text-left flex-1">
                            <p class="font-medium text-gray-900">Michael Chen</p>
                            <p class="text-sm text-gray-500">Engineering</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            pending
                        </span>
                    </button>

                    {{-- Application 3 (Approved Example) --}}
                    <button
                        onclick="selectApplication('app003')"
                        id="app-app003"
                        class="application-item approved w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border hidden"
                    >
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold">
                            JD
                        </div>
                        <div class="ml-3 text-left flex-1">
                            <p class="font-medium text-gray-900">Jessica Davis</p>
                            <p class="text-sm text-gray-500">Business Administration</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            approved
                        </span>
                    </button>

                    {{-- Application 4 (Rejected Example) --}}
                    <button
                        onclick="selectApplication('app004')"
                        id="app-app004"
                        class="application-item rejected w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border hidden"
                    >
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-semibold">
                            TW
                        </div>
                        <div class="ml-3 text-left flex-1">
                            <p class="font-medium text-gray-900">Thomas Wilson</p>
                            <p class="text-sm text-gray-500">Mechanical Engineering</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            rejected
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Application Details Panel --}}
        <div class="lg:col-span-2">
            {{-- Selected Application Detail View --}}
            <div id="application-detail" class="space-y-6">
                {{-- Applicant Info Card --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold text-xl">
                                SJ
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Sarah Johnson</h3>
                                <p class="text-gray-500">Computer Science</p>
                                <div class="mt-2 space-y-1">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        sarah.j@example.com
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        (555) 123-4567
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        San Francisco, CA, USA
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            pending
                        </span>
                    </div>
                </div>

                {{-- Required Documents Card --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-medium text-gray-900 text-lg mb-4">Required Documents</h3>
                    <div class="space-y-4">
                        {{-- Document 1 --}}
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-white rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">High School Transcript</p>
                                    <p class="text-sm text-gray-500">Verified</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Verified
                            </span>
                        </div>
                        
                        {{-- Document 2 --}}
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-white rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">ID Proof</p>
                                    <p class="text-sm text-gray-500">Verified</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Verified
                            </span>
                        </div>
                        
                        {{-- Document 3 --}}
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-white rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Recommendation Letter</p>
                                    <p class="text-sm text-gray-500">Pending verification</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <button 
                        onclick="rejectApplication('app001')"
                        class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-red-600 hover:bg-red-50 flex items-center justify-center font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Reject
                    </button>
                    <button 
                        onclick="approveApplication('app001')"
                        class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center justify-center font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Approve
                    </button>
                </div>
            </div>

            {{-- Empty State (no application selected) --}}
            <div id="no-application-selected" class="hidden bg-white rounded-lg shadow p-6">
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">
                        Select an Application
                    </h3>
                    <p class="text-gray-500 mt-1">
                        Choose an application from the list to view details
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterApplications(status) {
        // Update filter button styles
        const filterButtons = ['all', 'pending', 'approved', 'rejected'];
        filterButtons.forEach(filter => {
            const btn = document.getElementById(`filter-${filter}`);
            if (filter === status) {
                btn.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');
                btn.classList.add('bg-purple-600', 'text-white');
            } else {
                btn.classList.remove('bg-purple-600', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700');
            }
        });
        
        // Filter applications based on status
        const applicationItems = document.querySelectorAll('.application-item');
        applicationItems.forEach(item => {
            item.classList.add('hidden');
        });
        
        // Show all or specific status
        if (status === 'all') {
            applicationItems.forEach(item => {
                item.classList.remove('hidden');
            });
        } else {
            const filteredItems = document.querySelectorAll(`.application-item.${status}`);
            filteredItems.forEach(item => {
                item.classList.remove('hidden');
            });
        }
    }
    
    function selectApplication(appId) {
        // Reset all application buttons
        const appButtons = document.querySelectorAll('[id^="app-"]');
        appButtons.forEach(btn => {
            btn.classList.remove('bg-purple-50', 'border-purple-200');
            btn.classList.add('hover:bg-gray-50', 'border-transparent');
        });
        
        // Highlight the selected application
        const selectedButton = document.getElementById(`app-${appId}`);
        if (selectedButton) {
            selectedButton.classList.remove('hover:bg-gray-50', 'border-transparent');
            selectedButton.classList.add('bg-purple-50', 'border-purple-200');
        }
        
        // Show detail view, hide empty state
        document.getElementById('application-detail').classList.remove('hidden');
        document.getElementById('no-application-selected').classList.add('hidden');
    }
    
    function approveApplication(appId) {
        // In a real application, you would make an API call here
        alert(`Application ${appId} approved!`);
        
        // Update UI to show approved status
        const statusBadge = document.querySelector('#application-detail .rounded-full');
        if (statusBadge) {
            statusBadge.classList.remove('bg-yellow-100', 'text-yellow-800', 'bg-red-100', 'text-red-800');
            statusBadge.classList.add('bg-green-100', 'text-green-800');
            statusBadge.textContent = 'approved';
        }
        
        // Hide action buttons
        const actionButtons = document.querySelector('#application-detail .flex.gap-4');
        if (actionButtons) {
            actionButtons.classList.add('hidden');
        }
    }
    
    function rejectApplication(appId) {
        // In a real application, you would make an API call here
        alert(`Application ${appId} rejected!`);
        
        // Update UI to show rejected status
        const statusBadge = document.querySelector('#application-detail .rounded-full');
        if (statusBadge) {
            statusBadge.classList.remove('bg-yellow-100', 'text-yellow-800', 'bg-green-100', 'text-green-800');
            statusBadge.classList.add('bg-red-100', 'text-red-800');
            statusBadge.textContent = 'rejected';
        }
        
        // Hide action buttons
        const actionButtons = document.querySelector('#application-detail .flex.gap-4');
        if (actionButtons) {
            actionButtons.classList.add('hidden');
        }
    }
</script>
