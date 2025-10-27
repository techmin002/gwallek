@extends('setting::layouts.master')

@section('title', 'Expense Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mechanicals.reports.index') }}">Mechanical Reports</a></li>
        <li class="breadcrumb-item active">Expense Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="fw-bold text-primary">
                    <i class="fa fa-file-invoice"></i> Expense Details
                </h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Expense Info -->
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header bg-gradient-dark text-white">
                        <h4 class="mb-0"><i class="fa fa-info-circle me-2"></i> Expense Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <td>{{ $expense->title }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td class="fw-bold text-success">{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td><span class="badge bg-info">{{ $expense->payment_method }}</span></td>
                            </tr>
                            <tr>
                                <th>Receipt</th>
                                <td>
                                    @if ($expense->receipt)
                                        <img src="{{ asset('upload/images/mechanical_expenses/receipts/' . $expense->receipt) }}"
                                            alt="Expense Receipt" class="img-thumbnail" width="150">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{!! $expense->description ?? '-' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Products Used -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-info text-white">
                        <h4 class="mb-0"><i class="fa fa-boxes me-2"></i> Products Used</h4>
                    </div>
                    <div class="card-body">
                        @if ($expense->products->count() > 0)
                            <table class="table table-bordered table-hover text-center">
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
                                            <td>{{ number_format($product->amount, 2) }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td class="fw-bold text-success">{{ number_format($product->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td colspan="5">Product Total:</td>
                                        <td class="text-danger">{{ number_format($expense->products->sum('total'), 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No products used for this expense.</p>
                        @endif
                    </div>
                </div>

                <!-- Back -->
                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
