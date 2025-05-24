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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Make Payment</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Make a Payment</h1>
            <p class="mt-2 text-sm text-gray-600">Secure online payment for your tuition and fees</p>
        </div>

        <!-- Payment Container -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Payment Details
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    @if(isset($invoice))
                    Payment for Invoice #{{ $invoice->id }}
                    @else
                    Make a general payment to your account
                    @endif
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <form id="payment-form" action="{{ route('financial.process-payment') }}" method="POST">
                    @csrf
                    
                    @if(isset($invoice))
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    @endif
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <!-- Payment Summary -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-md">
                        <h4 class="text-md font-medium text-gray-700 mb-4">Payment Summary</h4>
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Student:</span>
                            <span>{{ $student->user->name }} (ID: {{ $student->student_id }})</span>
                        </div>
                        
                        @if(isset($invoice))
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Invoice Date:</span>
                            <span>{{ $invoice->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Due Date:</span>
                            <span>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Invoice Amount:</span>
                            <span>${{ number_format($invoice->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Amount Paid:</span>
                            <span>${{ number_format($amountPaid ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-gray-900 mt-2 pt-2 border-t border-gray-200">
                            <span>Balance Due:</span>
                            <span>${{ number_format($balanceDue ?? $invoice->amount, 2) }}</span>
                        </div>
                        @else
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span>Current Balance:</span>
                            <span>${{ number_format($totalDue ?? 0, 2) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Amount -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount ($)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" min="1" name="amount" id="amount" 
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                placeholder="0.00" 
                                value="{{ $balanceDue ?? ($invoice->amount ?? '') }}" required>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="togglePaymentFields()">
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>

                    <!-- Credit Card Payment Fields -->
                    <div id="credit_card_fields">
                        <div class="mb-6">
                            <label for="card_holder" class="block text-sm font-medium text-gray-700">Card Holder Name</label>
                            <input type="text" name="card_holder" id="card_holder" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="John Doe">
                        </div>
                        <div class="mb-6">
                            <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                            <input type="text" name="card_number" id="card_number" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="•••• •••• •••• ••••">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="col-span-1">
                                <label for="expiry_month" class="block text-sm font-medium text-gray-700">Expiration Month</label>
                                <select id="expiry_month" name="expiry_month" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="expiry_year" class="block text-sm font-medium text-gray-700">Expiration Year</label>
                                <select id="expiry_year" name="expiry_year" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Year</option>
                                    @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" name="cvv" id="cvv" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="•••">
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Fields -->
                    <div id="bank_transfer_fields" class="hidden">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Please use the following bank details to make your transfer:
                                    </p>
                                    <ul class="mt-2 text-sm text-blue-700 list-disc list-inside">
                                        <li>Bank Name: University Federal Bank</li>
                                        <li>Account Name: University Name</li>
                                        <li>Account Number: XXXX-XXXX-XXXX-XXXX</li>
                                        <li>Routing Number: XXXXXXXXX</li>
                                        <li>Reference: INV-{{ isset($invoice) ? $invoice->id : 'GENERAL' }}-{{ $student->student_id }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="bank_reference" class="block text-sm font-medium text-gray-700">Bank Reference Number</label>
                            <input type="text" name="bank_reference" id="bank_reference" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Enter your bank reference number">
                        </div>
                        <div class="mb-6">
                            <label for="bank_transfer_date" class="block text-sm font-medium text-gray-700">Transfer Date</label>
                            <input type="date" name="bank_transfer_date" id="bank_transfer_date" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <!-- PayPal Fields -->
                    <div id="paypal_fields" class="hidden">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        After clicking "Submit Payment", you will be redirected to PayPal to complete your payment.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Any additional information regarding this payment"></textarea>
                    </div>

                    <!-- Payment Agreement -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="agreement" name="agreement" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="agreement" class="font-medium text-gray-700">I authorize this payment</label>
                                <p class="text-gray-500">I understand and agree that my payment information will be processed securely. All information provided is accurate and complete.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('financial.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Security Info -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Secure Payment Information
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>
                        All payment information is encrypted and secure. We do not store your credit card details.
                    </p>
                    <div class="mt-4 flex items-center space-x-4">
                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V7z"/>
                        </svg>
                        <span>Your information is protected by industry-standard encryption technology.</span>
                    </div>
                    <div class="mt-2 flex items-center space-x-4">
                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V7z"/>
                        </svg>
                        <span>All transactions are securely processed and a receipt will be emailed to you.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Payment Form -->
<script>
    function togglePaymentFields() {
        const paymentMethod = document.getElementById('payment_method').value;
        
        // Hide all payment method fields
        document.getElementById('credit_card_fields').classList.add('hidden');
        document.getElementById('bank_transfer_fields').classList.add('hidden');
        document.getElementById('paypal_fields').classList.add('hidden');
        
        // Show the selected payment method fields
        if (paymentMethod === 'credit_card') {
            document.getElementById('credit_card_fields').classList.remove('hidden');
        } else if (paymentMethod === 'bank_transfer') {
            document.getElementById('bank_transfer_fields').classList.remove('hidden');
        } else if (paymentMethod === 'paypal') {
            document.getElementById('paypal_fields').classList.remove('hidden');
        }
    }
    
    // Format the credit card number input
    document.getElementById('card_number').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        
        // Add spaces after every 4 digits
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        
        e.target.value = value;
    });
    
    // Format the CVV input
    document.getElementById('cvv').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        e.target.value = value;
    });
</script>
@endsection
