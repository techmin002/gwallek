@extends('setting::layouts.master')

@section('title', 'Expenses Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Expenses Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expenses Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Expenses Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card shadow-lg">
                            <div
                                class="card-header bg-gradient-info text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fa fa-file-invoice"></i>
                                    Expense Details of <span
                                        class="fw-bold text-dark">{{ $expense->mechanical->name ?? '-' }}</span>
                                </h4>
                            </div>
                            <div class="card shadow-lg border-0 rounded-4">
                                <div class="card-body p-4">

                                    <!-- Expense Info -->
                                    <h4 class="fw-bold text-primary mb-3">
                                        <i class="fa fa-info-circle me-2"></i> Expense Information
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light w-25">Mechanical</th>
                                                    <td>{{ $expense->mechanical->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Title</th>
                                                    <td>{{ $expense->title }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Branch</th>
                                                    <td>{{ $expense->mechanical->branch->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Total Amount</th>
                                                    <td class="fw-bold text-success">
                                                        {{ number_format($expense->amount, 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Date</th>
                                                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Description</th>
                                                    <td>{!! $expense->description ?? '-' !!}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Receipt</th>
                                                    <td>
                                                        @if ($expense->receipt)
                                                            <a href="{{ asset('upload/images/mechanical_expenses/receipts/' . $expense->receipt) }}"
                                                                target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="fa fa-file-alt"></i> View Receipt
                                                            </a>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Products Info -->
                                    <h4 class="fw-bold text-primary mt-5 mb-3">
                                        <i class="fa fa-boxes me-2"></i> Products Used
                                    </h4>
                                    @if ($expense->products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover align-middle">
                                                <thead class="table-dark text-white">
                                                    <tr>
                                                        <th class="text-center">S.N</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Title</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($expense->products as $product)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $product->name }}</td>
                                                            <td class="text-center">{{ $product->title }}</td>
                                                            <td class="text-center">
                                                                {{ number_format($product->amount, 2) }}</td>
                                                            <td class="text-center">{{ $product->quantity }}</td>
                                                            <td class="text-center fw-bold text-success">
                                                                {{ number_format($product->total, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Grand Total Row -->
                                                    <tr class="table-info fw-bold">
                                                        <td colspan="4" class="text-center"><strong>Grand Total:</strong>
                                                        </td>
                                                        <td colspan="2" class="text-center text-danger fs-5">
                                                            <strong>{{ number_format($expense->products->sum('total'), 2) }}</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No products added for this expense.</p>
                                    @endif

                                    <!-- Back Button -->
                                    <div class="text-start mt-4">
                                        <a href="{{ route('mechanicals.expenses.index') }}"
                                            class="btn btn-outline-secondary px-4">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
