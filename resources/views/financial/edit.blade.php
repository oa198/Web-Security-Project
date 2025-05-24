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
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('financial.show', $financialRecord->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Record #{{ $financialRecord->id }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Edit Financial Record</h1>
            <p class="mt-2 text-sm text-gray-600">Update the financial record details.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('financial.update', $financialRecord->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-4 py-5 sm:p-6">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student -->
                        <div class="col-span-1">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Student <span class="text-red-500">*</span></label>
                            <select id="student_id" name="student_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $financialRecord->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->user->name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Record Type -->
                        <div class="col-span-1">
                            <label for="type" class="block text-sm font-medium text-gray-700">Record Type <span class="text-red-500">*</span></label>
                            <select id="type" name="type" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Type</option>
                                <option value="invoice" {{ old('type', $financialRecord->type) == 'invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="payment" {{ old('type', $financialRecord->type) == 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="scholarship" {{ old('type', $financialRecord->type) == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                                <option value="fine" {{ old('type', $financialRecord->type) == 'fine' ? 'selected' : '' }}>Fine</option>
                                <option value="refund" {{ old('type', $financialRecord->type) == 'refund' ? 'selected' : '' }}>Refund</option>
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="col-span-1">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" value="{{ old('amount', $financialRecord->amount) }}" step="0.01" min="0" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">USD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select id="status" name="status" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Status</option>
                                <option value="pending" {{ old('status', $financialRecord->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status', $financialRecord->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ old('status', $financialRecord->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="cancelled" {{ old('status', $financialRecord->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="refunded" {{ old('status', $financialRecord->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <!-- Academic Term -->
                        <div class="col-span-1">
                            <label for="term_id" class="block text-sm font-medium text-gray-700">Academic Term</label>
                            <select id="term_id" name="term_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Academic Term (Optional)</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ old('term_id', $financialRecord->term_id) == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Due Date -->
                        <div class="col-span-1 invoice-fields" style="{{ old('type', $financialRecord->type) != 'invoice' ? 'display: none;' : '' }}">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $financialRecord->due_date ? $financialRecord->due_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Payment Date -->
                        <div class="col-span-1 payment-fields" style="{{ old('type', $financialRecord->type) != 'payment' ? 'display: none;' : '' }}">
                            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $financialRecord->payment_date ? $financialRecord->payment_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Payment Method -->
                        <div class="col-span-1 payment-fields" style="{{ old('type', $financialRecord->type) != 'payment' ? 'display: none;' : '' }}">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method', $financialRecord->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="credit_card" {{ old('payment_method', $financialRecord->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="bank_transfer" {{ old('payment_method', $financialRecord->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="check" {{ old('payment_method', $financialRecord->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                                <option value="other" {{ old('payment_method', $financialRecord->payment_method) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Transaction ID -->
                        <div class="col-span-1 payment-fields" style="{{ old('type', $financialRecord->type) != 'payment' ? 'display: none;' : '' }}">
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $financialRecord->transaction_id) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Related Invoice -->
                        <div class="col-span-1 payment-fields" style="{{ old('type', $financialRecord->type) != 'payment' ? 'display: none;' : '' }}">
                            <label for="invoice_id" class="block text-sm font-medium text-gray-700">Related Invoice</label>
                            <select id="invoice_id" name="invoice_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Invoice (Optional)</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" {{ old('invoice_id', $financialRecord->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                        #{{ $invoice->id }} - ${{ number_format($invoice->amount, 2) }} ({{ $invoice->student->user->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $financialRecord->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end space-x-2">
                    <a href="{{ route('financial.show', $financialRecord->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const invoiceFields = document.querySelectorAll('.invoice-fields');
        const paymentFields = document.querySelectorAll('.payment-fields');

        // Toggle field visibility based on record type
        typeSelect.addEventListener('change', function() {
            if (this.value === 'invoice') {
                invoiceFields.forEach(field => field.style.display = 'block');
                paymentFields.forEach(field => field.style.display = 'none');
            } else if (this.value === 'payment') {
                invoiceFields.forEach(field => field.style.display = 'none');
                paymentFields.forEach(field => field.style.display = 'block');
            } else {
                invoiceFields.forEach(field => field.style.display = 'none');
                paymentFields.forEach(field => field.style.display = 'none');
            }
        });

        // Initialize the form state
        if (typeSelect.value === 'invoice') {
            invoiceFields.forEach(field => field.style.display = 'block');
            paymentFields.forEach(field => field.style.display = 'none');
        } else if (typeSelect.value === 'payment') {
            invoiceFields.forEach(field => field.style.display = 'none');
            paymentFields.forEach(field => field.style.display = 'block');
        }
    });
</script>
@endsection
@endsection
