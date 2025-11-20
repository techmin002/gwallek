@extends('setting::layouts.master')

@section('title', 'Add Income')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a></li>
        <li class="breadcrumb-item active">Add Income</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Income</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a></li>
                        <li class="breadcrumb-item active">Add Income</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">
                                <i class="fa fa-plus-circle"></i> Add New Income
                            </h3>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- Project -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select name="site_id" class="form-control" required>
                                            <option value="">-- Select Project --</option>
                                            @foreach($sites as $site)
                                                <option value="{{ $site->id }}">{{ $site->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter income title" required>
                                    </div>

                                    <!-- Amount -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" required>
                                    </div>

                                    <!-- Date -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Received Date <span class="text-danger">*</span></label>
                                        <input type="date" name="received_date" class="form-control" required>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" class="form-control" required>
                                            <option value="">-- Select Payment Method --</option>
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="e_wallet">E-Wallet (eSewa, Khalti)</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <!-- Receipt Image -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Receipt Image (optional)</label>
                                        <input type="file" name="receipt_image" class="form-control">
                                    </div>

                                    <!-- Note -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control" rows="3" placeholder="Add any additional notes..."></textarea>
                                    </div>

                                </div>

                                <div class="text-end">
                                    <a href="{{ route('incomes.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>
                                    <button class="btn btn-success">
                                        <i class="fa fa-check"></i> Save Income
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection
