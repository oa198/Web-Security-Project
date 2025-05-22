@extends('layouts.app')

@section('title', 'Financial Information - Student Portal')

@section('page_title', 'Financial Information')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Current Balance</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($currentBalance, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Charges</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($totalCharges, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Credits</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format(abs($totalCredits), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm border p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction History</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4">Date</th>
                        <th class="text-left py-3 px-4">Type</th>
                        <th class="text-left py-3 px-4">Description</th>
                        <th class="text-left py-3 px-4">Amount</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($financialRecords as $record)
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4">{{ $record->payment_date ? $record->payment_date->format('m/d/Y') : ($record->due_date ? $record->due_date->format('m/d/Y') : $record->created_at->format('m/d/Y')) }}</td>
                            <td class="py-3 px-4">{{ ucfirst($record->type) }}</td>
                            <td class="py-3 px-4">{{ $record->description }}</td>
                            <td class="py-3 px-4">
                                @if($record->amount < 0)
                                    <span class="text-green-600">${{ number_format($record->amount, 2) }}</span>
                                @else
                                    <span class="text-red-600">${{ number_format($record->amount, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $statusClass = match($record->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'processed' => 'bg-blue-100 text-blue-800',
                                        'refunded' => 'bg-purple-100 text-purple-800',
                                        'waived' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusClass }}">{{ ucfirst($record->status) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($record->receipt_number)
                                    <a href="#" class="text-primary-600 hover:text-primary-700" title="View Receipt">Receipt #{{ $record->receipt_number }}</a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">No financial records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 