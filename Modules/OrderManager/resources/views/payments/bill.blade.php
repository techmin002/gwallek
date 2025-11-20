<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #333;
            background: white;
        }
        
        .invoice {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        
        .company {
            flex: 1;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-details {
            font-size: 10px;
            color: #666;
            line-height: 1.2;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .invoice-meta {
            font-size: 10px;
        }
        
        .details-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 15px 0;
            font-size: 10px;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 11px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 2px;
        }
        
        .detail-label {
            font-weight: bold;
            min-width: 80px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10px;
        }
        
        .items-table th {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            border: 1px solid #ddd;
            padding: 6px 4px;
            vertical-align: top;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .items-table .text-center {
            text-align: center;
        }
        
        .summary {
            margin-top: 20px;
            font-size: 10px;
        }
        
        .summary-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .summary-table td {
            padding: 4px 8px;
            border: 1px solid #ddd;
        }
        
        .summary-label {
            background: #f5f5f5;
            font-weight: bold;
        }
        
        .total-row {
            background: #333;
            color: white;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 2px solid #333;
            font-size: 9px;
            text-align: center;
            color: #666;
        }
        
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            padding-top: 4px;
            text-align: center;
            font-size: 9px;
        }
        
        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-paid {
            background: #e8f5e8;
            color: #2e7d32;
        }
        
        .status-partial {
            background: #fff3e0;
            color: #ef6c00;
        }
        
        .status-unpaid {
            background: #ffebee;
            color: #c62828;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .invoice {
                padding: 10mm;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <!-- Header -->
        <div class="header">
            <div class="company">
                <div class="company-name">{{ $company->company_name }}</div>
                <div class="company-details">
                    {{ $company->company_address }}<br>
                    Tel: {{ $company->company_phone }} | Email: {{ $company->company_email }}
                </div>
            </div>
            
            <div class="invoice-info">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-meta">
                    <strong>Invoice No:</strong> {{ $invoice->invoice_no }}<br>
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->generated_at)->format('d/m/Y') }}<br>
                    <strong>Receipt:</strong> {{ $payment->receipt_number }}
                </div>
            </div>
        </div>
        
        <!-- Client & Project Details -->
        <div class="details-section">
            <div>
                <div class="section-title">BILL TO</div>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span>{{ $project->customer->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span>{{ $project->customer->phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span>{{ $project->customer->address ?? 'N/A' }}</span>
                </div>
            </div>
            
            <div>
                <div class="section-title">PROJECT</div>
                <div class="detail-row">
                    <span class="detail-label">Project:</span>
                    <span>{{ $project->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Location:</span>
                    <span>{{ $project->location ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Branch:</span>
                    <span>{{ $project->branch->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="35%">Description</th>
                    <th width="8%" class="text-center">Qty</th>
                    <th width="12%" class="text-right">Unit Price</th>
                    <th width="12%" class="text-right">Total</th>
                    <th width="12%" class="text-right">Paid Now</th>
                    <th width="12%" class="text-right">Balance</th>
                    <th width="4%" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentItems as $index => $paymentItem)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $paymentItem->purchaseItem->title }}</td>
                    <td class="text-center">{{ $paymentItem->purchaseItem->purchased_qty }}</td>
                    <td class="text-right">₹{{ number_format($paymentItem->purchaseItem->per_unit_price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($paymentItem->purchaseItem->total_price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($paymentItem->paid_amount, 2) }}</td>
                    <td class="text-right">₹{{ number_format($paymentItem->remaining_amount, 2) }}</td>
                    <td class="text-center">
                        <span class="status status-{{ $paymentItem->payment_status }}">
                            {{ substr(strtoupper($paymentItem->payment_status), 0, 1) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
       <!-- Summary -->
<div class="summary">
    <table class="summary-table">
        <tr>
            <td class="summary-label">Payment Method</td>
            <td>{{ strtoupper($payment->payment_type) }}</td>
        </tr>
        <tr>
            <td class="summary-label">Payment Date</td>
            <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="summary-label">Processed By</td>
            <td>{{ $payment->paidBy->name ?? 'System' }}</td>
        </tr>
        @php
            $totalPreviousPaid = $paymentItems->sum('previous_paid');
            $totalThisPayment = $paymentItems->sum('paid_amount');
            $totalRemaining = $paymentItems->sum('remaining_amount');
            $grandTotal = $totalPreviousPaid + $totalThisPayment + $totalRemaining;
        @endphp
        @if($totalPreviousPaid > 0)
        <tr>
            <td class="summary-label">Previous Paid</td>
            <td class="text-right">₹{{ number_format($totalPreviousPaid, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="summary-label">This Payment</td>
            <td class="text-right">₹{{ number_format($totalThisPayment, 2) }}</td>
        </tr>
        @if($totalRemaining > 0)
        <tr>
            <td class="summary-label">Remaining Balance</td>
            <td class="text-right">₹{{ number_format($totalRemaining, 2) }}</td>
        </tr>
        @endif
        <tr class="total-row">
            <td>GRAND TOTAL</td>
            <td class="text-right">₹{{ number_format($grandTotal, 2) }}</td>
        </tr>
    </table>
</div>
        
        @if($payment->remark)
        <div style="margin-top: 15px; font-size: 9px; color: #666;">
            <strong>Remarks:</strong> {{ $payment->remark }}
        </div>
        @endif
        
        <!-- Signatures -->
        <div class="signatures">
            <div>
                <div class="signature-line">Customer Signature</div>
            </div>
            <div>
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            {{ $company->company_name }} | {{ $company->company_address }} | Tel: {{ $company->company_phone }} | Email: {{ $company->company_email }}<br>
            This is a computer generated invoice. No signature required.
        </div>
    </div>
</body>
</html>