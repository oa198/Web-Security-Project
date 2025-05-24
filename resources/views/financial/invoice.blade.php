<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 28px;
        }
        .invoice-header p {
            margin: 5px 0;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details-left, .invoice-details-right {
            width: 48%;
        }
        .invoice-details h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        .invoice-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .invoice-total {
            text-align: right;
            margin-top: 30px;
        }
        .invoice-total h3 {
            margin: 0;
        }
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-overdue {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .status-cancelled {
            background-color: #f3f4f6;
            color: #374151;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Print Button (Only visible on screen) -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Invoice
            </button>
            <a href="{{ route('financial.show', $invoice->id) }}" style="margin-left: 10px; padding: 8px 16px; background-color: #6b7280; color: white; border: none; border-radius: 4px; text-decoration: none;">
                Back to Details
            </a>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <img src="{{ asset('images/logo.png') }}" alt="University Logo" class="logo">
            <h1>INVOICE</h1>
            <p><strong>Invoice #{{ $invoice->id }}</strong></p>
            <p>{{ config('app.name') }}</p>
            <p>{{ date('F d, Y') }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-details-left">
                <h3>Billed To:</h3>
                <p>
                    <strong>{{ $invoice->student->user->name }}</strong><br>
                    Student ID: {{ $invoice->student->student_id }}<br>
                    {{ $invoice->student->user->email }}<br>
                    {{ $invoice->student->address ?? 'No address on file' }}
                </p>
            </div>
            <div class="invoice-details-right">
                <h3>Invoice Details:</h3>
                <p>
                    <strong>Invoice Date:</strong> {{ $invoice->created_at->format('M d, Y') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'Not specified' }}<br>
                    <strong>Status:</strong> 
                    <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span><br>
                    @if($invoice->term)
                    <strong>Term:</strong> {{ $invoice->term->name }}<br>
                    @endif
                </p>
            </div>
        </div>

        <!-- Invoice Items -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($invoiceItems && count($invoiceItems) > 0)
                    @foreach($invoiceItems as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>${{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $invoice->description ?: 'Invoice charge' }}</td>
                        <td>${{ number_format($invoice->amount, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Payments Info (if any) -->
        @if(count($payments) > 0)
        <div>
            <h3>Payments Received:</h3>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : $payment->created_at->format('M d, Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?: 'Not specified')) }}</td>
                        <td>{{ $payment->transaction_id ?: 'N/A' }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Invoice Total -->
        <div class="invoice-total">
            <table style="width: 300px; margin-left: auto;">
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                @if(count($payments) > 0)
                <tr>
                    <td><strong>Total Paid:</strong></td>
                    <td>${{ number_format($totalPaid, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Balance Due:</strong></td>
                    <td>${{ number_format(max(0, $invoice->amount - $totalPaid), 2) }}</td>
                </tr>
                @else
                <tr>
                    <td><strong>Balance Due:</strong></td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Payment Instructions -->
        <div style="margin-top: 30px;">
            <h3>Payment Instructions:</h3>
            <p>
                Please make payment by the due date to avoid late fees. You can pay:
            </p>
            <ul>
                <li>Online through the student portal</li>
                <li>By bank transfer to Account #: XXXX-XXXX-XXXX-XXXX</li>
                <li>In person at the Bursar's Office</li>
            </ul>
            <p>
                <strong>Note:</strong> Please include your student ID and invoice number with your payment.
            </p>
        </div>

        <!-- Invoice Footer -->
        <div class="invoice-footer">
            <p>Thank you for your prompt payment.</p>
            <p>{{ config('app.name') }} - {{ config('app.url') }}</p>
            <p>Questions? Contact the Bursar's Office at financial@example.edu or (555) 123-4567</p>
        </div>
    </div>
</body>
</html>
