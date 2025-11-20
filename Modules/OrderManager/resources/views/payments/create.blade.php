@extends('setting::layouts.master')

@section('title', 'Make Payment')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payments.select-project') }}">Select Project</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payments.project-items') }}?project_id={{ $project->id }}">Select
                Items</a></li>
        <li class="breadcrumb-item active">Make Payment</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Make Payment</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('payments.project-items') }}?project_id={{ $project->id }}"
                            class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Items
                        </a>
                    </div>
                </div>
            </div>
        </section>
{{-- Add this at the top of your form for debugging --}}
@if($errors->any())
    <div class="alert alert-danger">
        <h4>Validation Errors:</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Payment Details - {{ $project->name }}</h3>
                            </div>
                            <div class="card-body">
                                <!-- Project Info -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <h6>Project: {{ $project->name }}</h6>
                                            <p class="mb-0">Customer: {{ $project->customer->name ?? 'N/A' }} | Location:
                                                {{ $project->location ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- @include('ordermanager::payments.paymenttable') --}}
                                @include('ordermanager::payments.frame')

                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </section>
    </div>

@endsection
