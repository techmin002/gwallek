@extends('setting::layouts.master')

@section('title', 'Mechanical Expenses')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Mechanical Expenses</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mechanical Expenses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Mechanical Expenses</li>
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

                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#createExpenseModal">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                                @include('mechanical::expenses.create')
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Mechanical</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Details</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $expense->mechanical->name ?? '-' }}</td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">{{ $expense->mechanical->branch->name ?? '-' }}
                                                    </td>
                                                @endif
                                                <td class="text-center">{{ $expense->title }}</td>
                                                <td class="text-center">{{ $expense->amount }}</td>

                                                <td class="text-center">
                                                    @if ($expense->receipt)
                                                        <img src="{{ asset('upload/images/mechanical_expenses/receipts/' . $expense->receipt) }}"
                                                            alt="Expense Receipt" class="img-thumbnail mt-2" width="100">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td class="text-center">{{ $expense->date }}</td>
                                                <td class="text-center">{!! $expense->description ?? '-' !!}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('mechanicals.expenses.show', $expense->id) }}"
                                                        class="btn btn-info btn-sm text-white" data-toggle="tooltip"
                                                        data-placement="top" title="View Details">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editExpenseModal{{ $expense->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('mechanical::expenses.edit', [
                                                        'expense' => $expense,
                                                    ])

                                                    <form
                                                        action="{{ route('mechanicals.expenses.destroy', $expense->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Mechanical</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Details</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
