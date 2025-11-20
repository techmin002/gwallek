@extends('setting::layouts.master')

@section('title', 'Payment Successful')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Payment Success</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="text-success mb-4">
                                    <i class="fa fa-check-circle fa-5x"></i>
                                </div>
                                <h2 class="text-success">Payment Successful!</h2>
                                <p class="lead">Your payment has been processed successfully.</p>
                                {{-- Add this to your success page --}}
                                @if (session('receipt_number'))
                                    <div class="alert alert-info mt-3">
                                        <h5>Receipt Number: {{ session('receipt_number') }}</h5>
                                        <p class="mb-0">Total Paid: ₹{{ number_format(session('total_paid'), 2) }}</p>
                                    </div>
                                @endif
                                @if (session('total_paid'))
                                    <div class="alert alert-info mt-3">
                                        <h5>Total Paid: ₹{{ number_format(session('total_paid'), 2) }}</h5>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('payments.select-project') }}" class="btn btn-primary btn-lg">
                                        <i class="fa fa-plus"></i> Make Another Payment
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                                        <i class="fa fa-home"></i> Go to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
