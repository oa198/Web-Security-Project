<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Statement - {{ $student->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .statement-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .statement-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .statement-header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }
        .statement-header p {
            margin: 5px 0;
        }
        .statement-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .statement-info-left, .statement-info-right {
            width: 48%;
        }
        .statement-info h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 0;
            font-size: 14px;
        }
        .statement-summary {
            margin-bottom: 30px;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        .statement-summary-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .statement-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .statement-summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
        }
        .statement-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 11px;
        }
        .statement-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 8px;
            border-bottom: 2px solid #ddd;
            font-size: 11px;
        }
        .statement-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .statement-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .statement-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 10px;
        }
        .amount-positive {
            color: #047857;
        }
        .amount-negative {
            color: #dc2626;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 10px;
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
    <div class="statement-container">
        <!-- Print Button (Only visible on screen) -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Statement
            </button>
            <a href="{{ route('financial.payment-history', $student->id) }}" style="margin-left: 10px; padding: 8px 16px; background-color: #6b7280; color: white; border: none; border-radius: 4px; text-decoration: none;">
                Back to Payment History
            </a>
        </div>

        <!-- Statement Header -->
        <div class="statement-header">
            <img src="{{ asset('images/logo.png') }}" alt="University Logo" class="logo">
            <h1>FINANCIAL STATEMENT</h1>
            <p>Statement Date: {{ date('F d, Y') }}</p>
            <p>Statement Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
            <p>{{ config('app.name') }}</p>
        </div>

        <!-- Statement Information -->
        <div class="statement-info">
            <div class="statement-info-left">
                <h3>Student Information:</h3>
                <p>
                    <strong>{{ $student->user->name }}</strong><br>
                    Student ID: {{ $student->student_id }}<br>
                    {{ $student->user->email }}<br>
                    {{ $student->address ?? 'No address on file' }}<br>
                    Program: {{ $student->program->name ?? 'Not specified' }}<br>
                    Year: {{ $student->year_level ?? 'Not specified' }}
                </p>
            </div>
            <div class="statement-info-right">
                <h3>Account Summary:</h3>
                <p>
                    <strong>Account Number:</strong> {{ $student->student_id }}<br>
                    <strong>Status:</strong> {{ $totalDue > 0 ? 'Outstanding Balance' : 'Current' }}<br>
                    <strong>Payment Due:</strong> {{ $nextDueDate ? $nextDueDate->format('M d, Y') : 'No upcoming payments' }}<br>
                    <strong>Payment Terms:</strong> Due on receipt unless otherwise noted<br>
                </p>
            </div>
        </div>

        <!-- Account Summary -->
        <div class="statement-summary">
            <div class="statement-summary-title">ACCOUNT SUMMARY</div>
            <div class="statement-summary-row">
                <div>Previous Balance</div>
                <div>${{ number_format($previousBalance, 2) }}</div>
            </div>
            <div class="statement-summary-row">
                <div>New Charges (This Period)</div>
                <div>${{ number_format($newCharges, 2) }}</div>
            </div>
            <div class="statement-summary-row">
                <div>Payments Received (This Period)</div>
                <div>${{ number_format($newPayments, 2) }}</div>
            </div>
            <div class="statement-summary-row">
                <div>Scholarships/Credits (This Period)</div>
                <div>${{ number_format($newScholarships, 2) }}</div>
            </div>
            <div class="statement-summary-row">
                <div>Current Balance</div>
                <div class="{{ $totalDue > 0 ? 'amount-negative' : 'amount-positive' }}">${{ number_format($totalDue, 2) }}</div>
            </div>
        </div>

        <!-- Transaction History -->
        <h3>Transaction History</h3>
        <table class="statement-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <!-- Optional: Previous Balance Row -->
                <tr>
                    <td>{{ $startDate->format('M d, Y') }}</td>
                    <td>--</td>
                    <td>Previous Balance</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>${{ number_format($previousBalance, 2) }}</td>
                </tr>

                @php $runningBalance = $previousBalance; @endphp
                
                @foreach($transactions as $transaction)
                @php
                    // Update running balance based on transaction type
                    if (in_array($transaction->type, ['payment', 'scholarship', 'refund'])) {
                        $runningBalance -= $transaction->amount;
                    } else {
                        $runningBalance += $transaction->amount;
                    }
                    
                    // Set colors for different transaction types
                    $amountClass = in_array($transaction->type, ['payment', 'scholarship', 'refund']) ? 'amount-positive' : 'amount-negative';
                    $amountPrefix = in_array($transaction->type, ['payment', 'scholarship', 'refund']) ? '-' : '+';
                    
                    // Status styling
                    $statusClass = 'status-' . $transaction->status;
                @endphp
                <tr>
                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                    <td>{{ $transaction->type == 'payment' ? 'PMT-' : ($transaction->type == 'invoice' ? 'INV-' : 'TXN-') }}{{ $transaction->id }}</td>
                    <td>{{ $transaction->description ?: ucfirst($transaction->type) . ' #' . $transaction->id }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span></td>
                    <td class="{{ $amountClass }}">{{ $amountPrefix }}${{ number_format($transaction->amount, 2) }}</td>
                    <td>${{ number_format($runningBalance, 2) }}</td>
                </tr>
                @endforeach
                
                <!-- Optional: Ending Balance Row -->
                <tr style="font-weight: bold; background-color: #f3f4f6;">
                    <td>{{ $endDate->format('M d, Y') }}</td>
                    <td>--</td>
                    <td>Ending Balance</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>${{ number_format($totalDue, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Upcoming Payments -->
        @if(count($upcomingPayments) > 0)
        <h3>Upcoming Payments</h3>
        <table class="statement-table">
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Reference</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingPayments as $payment)
                <tr>
                    <td>{{ $payment->due_date ? $payment->due_date->format('M d, Y') : 'N/A' }}</td>
                    <td>INV-{{ $payment->id }}</td>
                    <td>{{ $payment->description ?: 'Invoice #' . $payment->id }}</td>
                    <td class="amount-negative">${{ number_format($payment->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Payment Instructions -->
        <div style="margin-top: 30px; font-size: 11px;">
            <h3 style="font-size: 14px;">Payment Instructions:</h3>
            <p>
                Please make payment by the due date to avoid late fees. You can pay:
            </p>
            <ul>
                <li>Online through the student portal at {{ config('app.url') }}/login</li>
                <li>By bank transfer to Account #: XXXX-XXXX-XXXX-XXXX</li>
                <li>In person at the Bursar's Office (Building A, Room 120)</li>
                <li>By mail to: University Finance Office, 123 University Way, Anytown, ST 12345</li>
            </ul>
            <p>
                <strong>Note:</strong> Please include your student ID and invoice number with your payment.
            </p>
        </div>

        <!-- Statement Footer -->
        <div class="statement-footer">
            <p>This statement reflects the activity in your account as of {{ date('F d, Y') }}.</p>
            <p>If you have questions about your statement, please contact the Bursar's Office at financial@example.edu or (555) 123-4567</p>
            <p>{{ config('app.name') }} - {{ config('app.url') }}</p>
            <p>Page 1 of 1</p>
        </div>
    </div>
</body>
</html>
