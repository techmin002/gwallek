@extends('setting::layouts.master')

@section('title', 'Mechanical Expense Report')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Mechanical Expense Report</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="fw-bold text-primary">
                    <i class="fa fa-cogs"></i> Mechanical Report
                </h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Mechanical Info -->
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header bg-gradient-info text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-user-cog me-2"></i>
                            Mechanical Information
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4 text-center">
                                @if ($mechanical->image)
                                    <img src="{{ asset('upload/images/mechanicals/' . $mechanical->image) }}"
                                        class="img-fluid rounded shadow" alt="Mechanical Image">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $mechanical->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $mechanical->category->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Number</th>
                                        <td>{{ $mechanical->vehicle_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Engine Number</th>
                                        <td>{{ $mechanical->engine_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Chassis Number</th>
                                        <td>{{ $mechanical->chasis_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Branch</th>
                                        <td>{{ $mechanical->branch->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Purchesh amount </th>
                                        <td>{{ $mechanical->amount ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total </th>
                                        <td>{{ number_format($grandTotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($mechanical->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expenses Table -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-dark text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-file-invoice-dollar me-2"></i> Expenses
                        </h4>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>S.N</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Receipt</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expense->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                                        <td class="fw-bold text-success">{{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $expense->payment_method }}</span>
                                        </td>
                                        <td>
                                            @if ($expense->receipt)
                                                <img src="{{ asset('upload/images/mechanical_expenses/receipts/' . $expense->receipt) }}"
                                                    alt="Expense Receipt" class="img-thumbnail mt-2" width="100">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{!! $expense->description ?? '-' !!}</td>
                                        <td class="text-center">
                                            <a href="{{ route('report.details', $expense->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- Collapse Row
                                    <tr>
                                        <td colspan="8" class="p-0">
                                            <div class="collapse" id="detailsRow{{ $expense->id }}">
                                                <div class="p-3 bg-light">
                                                    <h6 class="fw-bold mb-2">
                                                        <i class="fa fa-boxes me-1"></i> Products Used
                                                    </h6>

                                                    @if ($expense->products->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered mb-3">
                                                                <thead class="table-warning">
                                                                    <tr>
                                                                        <th>S.N</th>
                                                                        <th>Name</th>
                                                                        <th>Title</th>
                                                                        <th>Amount</th>
                                                                        <th>Quantity</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($expense->products as $product)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $product->name ?? '-' }}</td>
                                                                            <td>{{ $product->title ?? '-' }}</td>
                                                                            <td>{{ number_format($product->amount, 2) }}
                                                                            </td>
                                                                            <td>{{ $product->quantity }}</td>
                                                                            <td class="fw-bold text-success">
                                                                                {{ number_format($product->total, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr class="table-light fw-bold">
                                                                        <td colspan="4">Product
                                                                            Total:</td>
                                                                        <td colspan="2" class="text-danger">
                                                                            {{ number_format($expense->products->sum('total'), 2) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <p class="text-muted mb-0">No products used for this expense.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold"><strong>Grand Total (All
                                            Expenses)</strong></td>
                                    <td colspan="3" class="fw-bold text-dark fs-5">
                                        <strong> {{ number_format($grandTotal, 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>



                <!-- Back -->
                <div class="mt-4">
                    <a href="{{ route('mechanicals.reports.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fa fa-arrow-left"></i> Back to Reports
                    </a>
                </div>

            </div>
        </section>
    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
