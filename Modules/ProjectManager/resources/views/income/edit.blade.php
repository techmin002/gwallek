@extends('setting::layouts.master')

@section('title', 'Edit Income')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a></li>
        <li class="breadcrumb-item active">Edit Income</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Income</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a></li>
                        <li class="breadcrumb-item active">Edit Income</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title">
                                <i class="fa fa-edit"></i> Update Income
                            </h3>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('incomes.update', $income->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <!-- Project -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select name="site_id" class="form-control" required>
                                            <option value="">-- Select Project --</option>
                                            @foreach($sites as $site)
                                                <option value="{{ $site->id }}" 
                                                    {{ $income->site_id == $site->id ? 'selected' : '' }}>
                                                    {{ $site->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" 
                                               value="{{ $income->title }}" required>
                                    </div>

                                    <!-- Amount -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control"
                                               value="{{ $income->amount }}" required>
                                    </div>

                                    <!-- Received Date -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Received Date <span class="text-danger">*</span></label>
                                        <input type="date" name="received_date" class="form-control"
       value="{{ \Carbon\Carbon::parse($income->received_date)->format('Y-m-d') }}" required>

                                    </div>

                                    <!-- Payment Method -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" class="form-control" required>
                                            <option value="">-- Select Payment Method --</option>
                                            <option value="cash" {{ $income->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="card" {{ $income->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                            <option value="e_wallet" {{ $income->payment_method == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                            <option value="cheque" {{ $income->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                            <option value="bank_transfer" {{ $income->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="other" {{ $income->payment_method == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <!-- Receipt Image -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Receipt Image (optional)</label>
                                        <input type="file" name="receipt_image" class="form-control">

                                        @if($income->receipt_image)
                                            <div class="mt-2">
                                                <p class="text-muted m-0">Current Receipt:</p>
                                                <a href="{{ asset('uploads/receipts/' . $income->receipt_image) }}" target="_blank">
                                                    <img src="{{ asset('uploads/receipts/' . $income->receipt_image) }}" width="70">
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Note -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control" rows="3">{{ $income->note }}</textarea>
                                    </div>

                                </div>

                                <div class="text-end">
                                    <a href="{{ route('incomes.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>

                                    <button class="btn btn-warning text-white">
                                        <i class="fa fa-save"></i> Update Income
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
