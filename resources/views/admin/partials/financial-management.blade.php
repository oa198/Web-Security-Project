{{-- Financial Management Partial View --}}
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Financial Management</h2>
        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center text-sm font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export Report
        </button>
    </div>

    {{-- Financial Overview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Outstanding Card --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center text-purple-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-gray-500">Total Outstanding</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">$45,000</div>
        </div>

        {{-- Past Due Accounts Card --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center text-red-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-gray-500">Past Due Accounts</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">12</div>
        </div>

        {{-- Paid in Full Card --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center text-green-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-gray-500">Paid in Full</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">85%</div>
        </div>
    </div>

    {{-- Student Financial Management --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Students List --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Search students..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    />
                </div>
            </div>
            
            <div class="mb-4 flex">
                <button class="px-3 py-1 text-xs font-medium rounded-lg bg-purple-100 text-purple-600 mr-2">
                    All
                </button>
                <button class="px-3 py-1 text-xs font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 mr-2">
                    Past Due
                </button>
                <button class="px-3 py-1 text-xs font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Hold
                </button>
            </div>

            <div class="space-y-2">
                {{-- Student 1 --}}
                <button
                    onclick="selectFinancialStudent('S2023001')"
                    id="financial-student-S2023001"
                    class="w-full flex items-center p-3 rounded-lg transition-colors bg-purple-50 border-purple-200 border"
                >
                    <div class="text-left flex-1">
                        <p class="font-medium text-gray-900">Alex Johnson</p>
                        <p class="text-sm text-gray-500">S2023001</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Past Due
                    </span>
                </button>

                {{-- Student 2 --}}
                <button
                    onclick="selectFinancialStudent('S2023002')"
                    id="financial-student-S2023002"
                    class="w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border"
                >
                    <div class="text-left flex-1">
                        <p class="font-medium text-gray-900">Emily Davis</p>
                        <p class="text-sm text-gray-500">S2023002</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Good Standing
                    </span>
                </button>

                {{-- Student 3 --}}
                <button
                    onclick="selectFinancialStudent('S2023003')"
                    id="financial-student-S2023003"
                    class="w-full flex items-center p-3 rounded-lg transition-colors hover:bg-gray-50 border-transparent border"
                >
                    <div class="text-left flex-1">
                        <p class="font-medium text-gray-900">Michael Brown</p>
                        <p class="text-sm text-gray-500">S2023003</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Hold
                    </span>
                </button>
            </div>
        </div>

        {{-- Selected Student Financial Details --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Alex Johnson</h3>
                        <p class="text-gray-500">S2023001</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Past Due
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    {{-- Current Balance --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Current Balance</p>
                        <p class="text-2xl font-bold text-red-600">$2,500</p>
                    </div>
                    
                    {{-- Last Payment --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Last Payment</p>
                        <p class="text-2xl font-bold text-gray-900">$1,500</p>
                        <p class="text-xs text-gray-500">2/15/2024</p>
                    </div>
                </div>

                {{-- Scholarships & Aid --}}
                <h4 class="font-medium text-gray-900 mb-3">Scholarships & Aid</h4>
                <div class="space-y-4 mb-6">
                    {{-- Scholarship 1 --}}
                    <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Merit Scholarship</p>
                            <p class="text-sm text-gray-500">Annual Award</p>
                        </div>
                        <p class="font-bold text-gray-900">$5,000</p>
                    </div>
                    
                    {{-- Scholarship 2 --}}
                    <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Need-based Grant</p>
                            <p class="text-sm text-gray-500">Annual Award</p>
                        </div>
                        <p class="font-bold text-gray-900">$2,500</p>
                    </div>
                </div>

                {{-- Recent Transactions --}}
                <h4 class="font-medium text-gray-900 mb-3">Recent Transactions</h4>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Tuition</p>
                            <p class="text-sm text-gray-500">Fall 2024 Semester</p>
                        </div>
                        <p class="font-bold text-red-600">$12,500</p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-4">
                <button class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Send Payment Reminder
                </button>
                <button class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Record Payment
                </button>
            </div>
        </div>
    </div>

    {{-- Tuition Configuration Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-medium text-gray-900 text-lg mb-4">Tuition Configuration</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                {{-- Base Tuition Input --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Tuition</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input
                            type="number"
                            value="12500"
                            class="block w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                </div>

                {{-- Payment Deadline Input --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Deadline</label>
                    <div class="relative rounded-md shadow-sm">
                        <input
                            type="date"
                            value="2025-08-15"
                            class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                </div>

                {{-- Late Fee Settings --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Late Fee Amount</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input
                                type="number"
                                value="250"
                                class="block w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Late Fee Percentage</label>
                        <div class="relative rounded-md shadow-sm">
                            <input
                                type="number"
                                value="5"
                                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Discount Programs --}}
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-3">Discount Programs</h4>
                
                <div class="space-y-3 mb-4">
                    {{-- Discount 1 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Early Payment</p>
                                <p class="text-sm text-gray-600">5% off tuition</p>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded text-gray-700 text-sm hover:bg-gray-50">
                            Edit
                        </button>
                    </div>
                    
                    {{-- Discount 2 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Need-based Aid</p>
                                <p class="text-sm text-gray-600">10% off tuition</p>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded text-gray-700 text-sm hover:bg-gray-50">
                            Edit
                        </button>
                    </div>
                    
                    {{-- Discount 3 --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Academic Excellence</p>
                                <p class="text-sm text-gray-600">15% off tuition</p>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded text-gray-700 text-sm hover:bg-gray-50">
                            Edit
                        </button>
                    </div>
                </div>
                
                <button class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Discount Program
                </button>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mt-6">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Reset to Defaults
            </button>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Save Changes
            </button>
        </div>
    </div>
</div>

<script>
    function selectFinancialStudent(studentId) {
        // Reset all student buttons
        const studentButtons = document.querySelectorAll('[id^="financial-student-"]');
        studentButtons.forEach(btn => {
            btn.classList.remove('bg-purple-50', 'border-purple-200');
            btn.classList.add('hover:bg-gray-50', 'border-transparent');
        });
        
        // Highlight the selected student
        const selectedButton = document.getElementById(`financial-student-${studentId}`);
        if (selectedButton) {
            selectedButton.classList.remove('hover:bg-gray-50', 'border-transparent');
            selectedButton.classList.add('bg-purple-50', 'border-purple-200');
        }
        
        // In a real application, you would fetch student data here
        // and update the UI with the selected student's information
    }
</script>
