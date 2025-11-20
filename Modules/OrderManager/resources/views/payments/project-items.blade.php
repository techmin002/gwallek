@extends('setting::layouts.master')

@section('title', 'Select Purchase Items for Payment')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payments.select-project') }}">Select Project</a></li>
        <li class="breadcrumb-item active">Select Items</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Select Purchase Items</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('payments.select-project') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Project Info -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Project Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Project Name:</strong> {{ $project->name }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Customer:</strong> {{ $project->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Location:</strong> {{ $project->location ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                       @include('ordermanager::payments.items')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

