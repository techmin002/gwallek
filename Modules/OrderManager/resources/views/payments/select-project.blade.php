@extends('setting::layouts.master')

@section('title', 'Select Project for Payment')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Select Project</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Select Project</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('payments.history') }}" class="btn btn-info">
                            <i class="fa fa-history"></i> View All Payments
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Choose Project</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('payments.project-items') }}" method="POST" id="projectForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="project_id">Select Project *</label>
                                        <select name="project_id" id="project_id" class="form-control select2" required>
                                            <option value="">Select a Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">
                                                    {{ $project->name }} - {{ $project->customer->name ?? 'N/A' }} - {{ $project->branch->name ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fa fa-arrow-right"></i> Continue to Payment Items
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Recent Payments Table -->
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h3 class="card-title">Recent Payments</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Receipt No.</th>
                                                <th>Project</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Items</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentPayments as $payment)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $payment->receipt_number }}</strong>
                                                        @if($payment->invoice)
                                                            <br><small class="text-muted">Invoice: {{ $payment->invoice->invoice_no }}</small>
                                                        @endif
                                                        <br><small class="text-muted">TXN: {{ $payment->transaction_id }}</small>
                                                    </td>
                                                    <td>{{ $payment->project->name ?? 'N/A' }}</td>
                                                    <td>{{ $payment->project->customer->name ?? 'N/A' }}</td>
                                                    <td class="text-success">
                                                        <strong>₹{{ number_format($payment->total_paid_amount, 2) }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $payment->paymentItems->count() }} items
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small>
                                                            @foreach($payment->paymentItems->take(2) as $paymentItem)
                                                                {{ $paymentItem->purchaseItem->title }}<br>
                                                            @endforeach
                                                            @if($payment->paymentItems->count() > 2)
                                                                +{{ $payment->paymentItems->count() - 2 }} more
                                                            @endif
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-light text-uppercase">
                                                            {{ $payment->payment_type }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}</td>
                                                   
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('payments.show', $payment->id) }}" 
                                                               class="btn btn-sm btn-info" title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @if($payment->invoice)
                                                                <a href="{{ route('payments.download-bill', $payment->invoice->id) }}" 
                                                                   class="btn btn-sm btn-success" title="Download Bill">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @else
                                                                <button type="button" 
                                                                        class="btn btn-sm btn-warning generate-bill-btn" 
                                                                        data-payment-id="{{ $payment->id }}"
                                                                        title="Generate Bill">
                                                                    <i class="fa fa-file-invoice"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a project",
            allowClear: true
        });

        // Initialize DataTable
        $('#paymentsTable').DataTable({
            "order": [[6, "desc"]], // Sort by date descending
            "pageLength": 10
        });

        // Generate bill button click
        $('.generate-bill-btn').click(function() {
            const paymentId = $(this).data('payment-id');
            generateBill(paymentId);
        });

        function generateBill(paymentId) {
            Swal.fire({
                title: 'Generate Bill?',
                text: 'Do you want to generate a bill for this payment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Generate Bill',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/payments/${paymentId}/generate-bill`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Bill generated successfully!',
                        icon: 'success',
                        confirmButtonText: 'Download Bill'
                    }).then(() => {
                        // Redirect to download the bill
                        window.location.href = `/payments/bill/${result.value.invoice_id}/download`;
                    });
                }
            });
        }
    });
</script>
@endpush