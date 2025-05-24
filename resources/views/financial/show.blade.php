@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('financial.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Financial Records</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Record #{{ $financialRecord->id }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <!-- Record Details Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl leading-6 font-semibold text-gray-900">
                        Financial Record #{{ $financialRecord->id }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ ucfirst($financialRecord->type) }} details
                    </p>
                </div>
                <div class="flex space-x-2">
                    @if($financialRecord->type == 'invoice' && $financialRecord->status != 'paid')
                    <a href="{{ route('financial.create', ['type' => 'payment', 'invoice_id' => $financialRecord->id, 'student_id' => $financialRecord->student_id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Record Payment
                    </a>
                    @endif

                    @can('update', $financialRecord)
                    <a href="{{ route('financial.edit', $financialRecord->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Edit
                    </a>
                    @endcan
                    
                    @can('delete', $financialRecord)
                    <form action="{{ route('financial.destroy', $financialRecord->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this record?')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <!-- Record Type -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Record Type
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $typeColors = [
                                    'invoice' => 'bg-blue-100 text-blue-800',
                                    'payment' => 'bg-green-100 text-green-800',
                                    'scholarship' => 'bg-purple-100 text-purple-800',
                                    'fine' => 'bg-red-100 text-red-800',
                                    'refund' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $color = $typeColors[$financialRecord->type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($financialRecord->type) }}
                            </span>
                        </dd>
                    </div>
                    
                    <!-- Amount -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Amount
                        </dt>
                        <dd class="mt-1 text-sm font-medium sm:mt-0 sm:col-span-2">
                            <span class="text-lg {{ in_array($financialRecord->type, ['payment', 'scholarship', 'refund']) ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($financialRecord->amount, 2) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'overdue' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-gray-100 text-gray-800',
                                    'refunded' => 'bg-blue-100 text-blue-800',
                                ];
                                $statusColor = $statusColors[$financialRecord->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ ucfirst($financialRecord->status) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Student Information -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Student
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold mr-3">
                                    {{ substr($financialRecord->student->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium">{{ $financialRecord->student->user->name }}</p>
                                    <p class="text-gray-500 text-xs">ID: {{ $financialRecord->student->student_id }}</p>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <!-- Academic Term -->
                    @if($financialRecord->term)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Academic Term
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $financialRecord->term->name }}
                        </dd>
                    </div>
                    @endif

                    <!-- Due Date (for invoices) -->
                    @if($financialRecord->type == 'invoice' && $financialRecord->due_date)
                    <div class="bg-{{ $financialRecord->term ? 'white' : 'gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Due Date
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $financialRecord->due_date->format('M d, Y') }}
                            @if($financialRecord->status == 'pending' && now()->gt($financialRecord->due_date))
                                <span class="ml-2 px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-red-100 text-red-800">
                                    Overdue by {{ now()->diffInDays($financialRecord->due_date) }} days
                                </span>
                            @elseif($financialRecord->status == 'pending')
                                <span class="ml-2 text-gray-500 text-xs">
                                    Due in {{ now()->diffInDays($financialRecord->due_date) }} days
                                </span>
                            @endif
                        </dd>
                    </div>
                    @endif

                    <!-- Payment Details (for payments) -->
                    @if($financialRecord->type == 'payment')
                        <!-- Payment Date -->
                        <div class="bg-{{ $financialRecord->term ? 'white' : 'gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Payment Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $financialRecord->payment_date ? $financialRecord->payment_date->format('M d, Y') : 'Not specified' }}
                            </dd>
                        </div>

                        <!-- Payment Method -->
                        @if($financialRecord->payment_method)
                        <div class="bg-{{ $financialRecord->term ? 'gray-50' : 'white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Payment Method
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ ucfirst(str_replace('_', ' ', $financialRecord->payment_method)) }}
                                @if($financialRecord->transaction_id)
                                    <span class="ml-2 text-gray-500">
                                        (Transaction ID: {{ $financialRecord->transaction_id }})
                                    </span>
                                @endif
                            </dd>
                        </div>
                        @endif

                        <!-- Related Invoice -->
                        @if($financialRecord->invoice)
                        <div class="bg-{{ $financialRecord->payment_method ? ($financialRecord->term ? 'white' : 'gray-50') : ($financialRecord->term ? 'gray-50' : 'white') }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Related Invoice
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{ route('financial.show', $financialRecord->invoice->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    Invoice #{{ $financialRecord->invoice->id }} - ${{ number_format($financialRecord->invoice->amount, 2) }}
                                </a>
                            </dd>
                        </div>
                        @endif
                    @endif

                    <!-- Description -->
                    <div class="bg-{{ ($financialRecord->type == 'payment' && $financialRecord->invoice) ? 'gray-50' : 'white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! nl2br(e($financialRecord->description)) ?: '<span class="text-gray-500">No description provided</span>' !!}
                        </dd>
                    </div>

                    <!-- Created/Updated Information -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Record Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <div>Created: {{ $financialRecord->created_at->format('M d, Y h:i A') }}</div>
                            <div>Last Updated: {{ $financialRecord->updated_at->format('M d, Y h:i A') }}</div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Related Records Section -->
        @if(count($relatedRecords) > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Related Records
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Other financial records associated with this one
                </p>
            </div>
            <div class="border-t border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($relatedRecords as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $record->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $recordTypeColor = $typeColors[$record->type] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $recordTypeColor }}">
                                        {{ ucfirst($record->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="{{ in_array($record->type, ['payment', 'scholarship', 'refund']) ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format($record->amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $recordStatusColor = $statusColors[$record->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $recordStatusColor }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $record->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('financial.show', $record->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('financial.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Financial Records
            </a>
        </div>
    </div>
</div>
@endsection
