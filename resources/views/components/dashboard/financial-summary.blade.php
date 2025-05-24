<x-ui.card 
    title="Financial Summary" 
    subtitle="Current semester balance"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('financial.index') }}" class="text-sm text-purple-600 hover:underline">Details</a>
    </x-slot>
    
    @if(isset($currentBalance))
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm text-gray-500">Current Balance</p>
                <h3 class="text-2xl font-bold {{ $currentBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ${{ number_format(abs($currentBalance), 2) }}
                </h3>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $currentBalance > 0 ? 'Amount Due' : 'Credit Balance' }}
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
                    <p class="text-sm font-semibold">${{ number_format($totalCharges ?? 0, 0) }}</p>
                </div>
                
                <div class="text-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500">Credits</p>
                    <p class="text-sm font-semibold">${{ number_format(abs($totalCredits ?? 0), 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="mt-4 border-t border-gray-100 pt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Recent Transactions</h4>
            
            @if(isset($recentTransactions) && count($recentTransactions) > 0)
                <div class="space-y-3">
                    @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="p-2 rounded-full {{ $transaction->amount > 0 ? 'bg-red-100' : 'bg-green-100' }} mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $transaction->amount > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->description }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->details }}</p>
                                </div>
                            </div>
                            <div class="text-sm font-semibold {{ $transaction->amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $transaction->amount > 0 ? '' : '-' }}${{ number_format(abs($transaction->amount), 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No recent transactions found.</p>
            @endif
        </div>
    @else
        <div class="p-4 flex flex-col items-center justify-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">No financial data available</h3>
            <p class="text-xs text-gray-500 mt-1">Financial information will appear here once available.</p>
        </div>
    @endif
</x-ui.card>
