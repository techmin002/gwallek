@extends('setting::layouts.master')

@section('title', 'Payment Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payments.select-project') }}">Payments</a></li>
        <li class="breadcrumb-item active">Payment Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment Details</h1>
                    </div>
                   @include("ordermanager::payments.billbtn")
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Payment Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Payment Details</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Payment ID:</th>
                                                <td>#{{ $payment->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Transaction ID:</th>
                                                <td>{{ $payment->transaction_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Receipt Number:</th>
                                                <td>{{ $payment->receipt_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Type:</th>
                                                <td>
                                                    <span class="badge badge-light text-uppercase">
                                                        {{ $payment->payment_type }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Paid Amount:</th>
                                                <td class="text-success"><strong>₹{{ number_format($payment->total_paid_amount, 2) }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Transaction Info</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Paid By:</th>
                                                <td>{{ $payment->paidBy->name ?? 'System' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Date:</th>
                                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Invoice No:</th>
                                                <td>
                                                    @if($payment->invoice)
                                                        <span class="badge badge-success">{{ $payment->invoice->invoice_no }}</span>
                                                    @else
                                                        <span class="badge badge-warning">No Invoice Generated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Items Count:</th>
                                                <td>
                                                    <span class="badge badge-info">{{ $payment->paymentItems->count() }} items</span>
                                                @php
                                                    $paidItems = $payment->paymentItems->where('payment_status', 'paid')->count();
                                                    $partialItems = $payment->paymentItems->where('payment_status', 'partial')->count();
                                                    $unpaidItems = $payment->paymentItems->where('payment_status', 'unpaid')->count();
                                                @endphp
                                                <br>
                                                <small>
                                                    Paid: {{ $paidItems }}, 
                                                    Partial: {{ $partialItems }}, 
                                                    Unpaid: {{ $unpaidItems }}
                                                </small>
                                            </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($payment->remark)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h5>Remarks</h5>
                                        <div class="alert alert-info">
                                            {{ $payment->remark }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($payment->attachment)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h5>Attachment</h5>
                                        <a href="{{ Storage::url($payment->attachment) }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="fa fa-download"></i> Download Attachment
                                        </a>
                                    </div>
                                </div>
                                @endif

                                <!-- Payment Items Details -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>Payment Items ({{ $payment->paymentItems->count() }})</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Title</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Total Price</th>
                                                        <th>Previous Paid</th>
                                                        <th>This Payment</th>
                                                        <th>Remaining</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($payment->paymentItems as $index => $paymentItem)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $paymentItem->purchaseItem->title }}</td>
                                                        <td>{{ $paymentItem->purchaseItem->purchased_qty }}</td>
                                                        <td>₹{{ number_format($paymentItem->purchaseItem->per_unit_price, 2) }}</td>
                                                        <td>₹{{ number_format($paymentItem->purchaseItem->total_price, 2) }}</td>
                                                        <td>₹{{ number_format($paymentItem->previous_paid, 2) }}</td>
                                                        <td class="text-success">₹{{ number_format($paymentItem->paid_amount, 2) }}</td>
                                                        <td class="text-warning">₹{{ number_format($paymentItem->remaining_amount, 2) }}</td>
                                                        <td>
                                                            @if($paymentItem->payment_status == 'paid')
                                                                <span class="badge badge-success">Paid</span>
                                                            @elseif($paymentItem->payment_status == 'partial')
                                                                <span class="badge badge-warning">Partial</span>
                                                            @else
                                                                <span class="badge badge-danger">Unpaid</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-primary">
                                                        <td colspan="5" class="text-right"><strong>Totals:</strong></td>
                                                        <td><strong>₹{{ number_format($payment->paymentItems->sum('previous_paid'), 2) }}</strong></td>
                                                        <td><strong class="text-success">₹{{ number_format($payment->paymentItems->sum('paid_amount'), 2) }}</strong></td>
                                                        <td><strong class="text-warning">₹{{ number_format($payment->paymentItems->sum('remaining_amount'), 2) }}</strong></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Details -->
                                @if($payment->project)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>Project Details</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Project Name:</th>
                                                    <td>{{ $payment->project->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer:</th>
                                                    <td>{{ $payment->project->customer->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Location:</th>
                                                    <td>{{ $payment->project->location ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Branch:</th>
                                                    <td>{{ $payment->project->branch->name ?? 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="text-center mt-4">
                                    <a href="{{ route('payments.select-project') }}" class="btn btn-primary">
                                        <i class="fa fa-arrow-left"></i> Back to Payments
                                    </a>
                                    @if($payment->invoice)
                                        <a href="{{ route('payments.download-bill', $payment->invoice->id) }}" class="btn btn-success">
                                            <i class="fa fa-download"></i> Download Invoice
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-warning generate-bill-btn" data-payment-id="{{ $payment->id }}">
                                            <i class="fa fa-file-invoice"></i> Generate Bill
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection