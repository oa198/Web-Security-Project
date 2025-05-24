<x-ui.card 
    title="Financial Summary" 
    subtitle="Current semester balance"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('financial.index') }}" class="text-sm text-purple-600 hover:underline">Details</a>
    </x-slot>
    
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm text-gray-500">Current Balance</p>
            <h3 class="text-2xl font-bold text-red-600">
                $1,250.00
            </h3>
            <p class="text-xs text-gray-500 mt-1">
                Amount Due
            </p>
        </div>
        
        <div class="flex space-x-4">
            <div class="text-center">
                <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500">Charges</p>
                <p class="text-sm font-semibold">$8,750</p>
            </div>
            
            <div class="text-center">
                <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500">Credits</p>
                <p class="text-sm font-semibold">$7,500</p>
            </div>
        </div>
    </div>
    
    <div class="mt-4 border-t border-gray-100 pt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Recent Transactions</h4>
        
        <div class="space-y-3">
            <!-- Transaction 1 -->
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="p-2 rounded-full bg-red-100 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Tuition Fee</p>
                        <p class="text-xs text-gray-500">Spring 2023 Semester</p>
                    </div>
                </div>
                <div class="text-sm font-semibold text-red-600">
                    $4,500
                </div>
            </div>
            
            <!-- Transaction 2 -->
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="p-2 rounded-full bg-green-100 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Scholarship</p>
                        <p class="text-xs text-gray-500">Academic Merit Award</p>
                    </div>
                </div>
                <div class="text-sm font-semibold text-green-600">
                    -$2,500
                </div>
            </div>
            
            <!-- Transaction 3 -->
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="p-2 rounded-full bg-red-100 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Housing Fee</p>
                        <p class="text-xs text-gray-500">Campus Dormitory</p>
                    </div>
                </div>
                <div class="text-sm font-semibold text-red-600">
                    $2,750
                </div>
            </div>
        </div>
    </div>
</x-ui.card>
