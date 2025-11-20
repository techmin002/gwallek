@extends('setting::layouts.master')

@section('title', 'Incomes')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Incomes</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Income List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Incomes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <div class="col-sm-12">
        <form method="GET" action="{{ route('incomes.index') }}" class="mb-3 d-flex align-items-center">
    <label class="me-2">Filter Project:</label>
    <select name="site_id" class="form-control me-2" onchange="this.form.submit()">
        <option value="">-- All Projects --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ (isset($selectedProject) && $selectedProject->id == $project->id) ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
    <noscript>
        <button type="submit" class="btn btn-primary">Filter</button>
    </noscript>
</form>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5>Total Project Cost</h5>
                <h3>Rs {{ number_format($totalProjectCost, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5>Total Income Received</h5>
                <h3>Rs {{ number_format($totalIncome, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body">
                <h5>Remaining Amount</h5>
                <h3>Rs {{ number_format($totalRemaining, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

</div>
        <!-- Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a href="{{ route('incomes.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Income
                                    </a>
                                </h3>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Project</th>
                                            <th>Title</th>
                                            <th>Amount</th>
                                            <th>Received Date</th>
                                            <th>Payment Method</th>
                                            <th>Receipt</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($incomes as $income)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $income->site->name ?? 'N/A' }}</td>
                                                <td>{{ $income->title }}</td>
                                                <td>Rs {{ number_format($income->amount, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($income->received_date)->format('F d, Y') }}</td>

                                                {{-- <td>{{ $income->received_date->format('F d, Y') }}</td> --}}

                                                <!-- Payment Method Badge -->
                                                <td>
                                                    @php
                                                        $method = $income->payment_method;
                                                        $class = 'badge-secondary';

                                                        if ($method == 'cash') $class = 'badge-success';
                                                        elseif ($method == 'card') $class = 'badge-info';
                                                        elseif ($method == 'e_wallet') $class = 'badge-primary';
                                                        elseif ($method == 'cheque') $class = 'badge-warning';
                                                        elseif ($method == 'bank_transfer') $class = 'badge-dark';
                                                    @endphp

                                                    <span class="badge {{ $class }}">
                                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                                    </span>
                                                </td>

                                                <!-- Receipt Image -->
                                                <td>
                                                    @if($income->receipt_image)
                                                        <a href="{{ asset('uploads/receipts/' . $income->receipt_image) }}" target="_blank">
                                                            <img src="{{ asset('uploads/receipts/' . $income->receipt_image) }}" width="50" />
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>

                                                <!-- Actions -->
                                                <td>
                                                    <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Delete this?')" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Project</th>
                                            <th>Title</th>
                                            <th>Amount</th>
                                            <th>Received Date</th>
                                            <th>Payment Method</th>
                                            <th>Receipt</th>
                                            <th>Action</th>
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
