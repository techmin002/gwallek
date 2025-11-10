@extends('setting::layouts.master')

@section('title', 'Deposite Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Deposite Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Deposite Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Deposite Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h4>Today Deposit: {{ $todayCollection }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h4>Total Deposit: {{ $grandTotal }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deposits Table -->
                <div class="card mb-4">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>S.N</th>
                                    <th>Bank Name</th>
                                    <th>Branch Name</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($data as $out)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $out->bank->bank_name ?? 'N/A' }}</td>
                                        <td>{{ $out->branch->name ?? 'N/A' }}</td>
                                        <td>{{ $out->date ?? 'N/A' }}</td>
                                        <td>{{ $out->amount ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ asset('upload/images/deposits/' . $out->image) }}"
                                                target="_blank">View Receipt</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No deposit data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th colspan="3">Grand Total</th>
                                    <th colspan="2">{{ number_format($grandTotal, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('cash-counter.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <!-- Expenses Table -->
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4>Reduce Amount From Expenses</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($expenses as $expense)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expense->date ?? 'N/A' }}</td>
                                        <td>{{ $expense->title ?? 'N/A' }}</td>
                                        <td>{{ $expense->category->title ?? 'N/A' }}</td>
                                        <td>{{ $expense->description ?? '-' }}</td>
                                        <td>{{ $expense->amount ?? 'N/A' }}</td>
                                        <td>
                                            @if ($expense->receipt)
                                                <a href="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}"
                                                    target="_blank">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No expense data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th colspan="5">Total Expense</th>
                                    <th colspan="2">{{ number_format($expenses->sum('amount'), 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
