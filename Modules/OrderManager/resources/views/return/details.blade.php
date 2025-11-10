@extends('setting::layouts.master')

@section('title', 'Return Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0 bg-transparent">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active text-primary">Return Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Header -->
        <section class="content-header py-3 bg-gradient-info text-white shadow-sm rounded">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="fw-bold mb-0"><i class="fa fa-undo"></i> Return Details</h1>
                {{-- <a href="{{ route('orders.return') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a> --}}
            </div>
        </section>

        <!-- Main -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Card -->
                        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                            <!-- Header -->
                            <div class="card-header bg-gradient-primary text-white fw-bold fs-5">
                                <i class="fa fa-info-circle"></i> Return Summary
                            </div>

                            <div class="card-body bg-light">
                                <!-- Order Info -->
                                <div class="row mb-4">
                                    <!-- Site Info -->
                                    <div class="col-md-6">
                                        <div class="p-3 bg-white rounded shadow-sm h-100">
                                            <h5 class="text-primary fw-bold"><i class="fa fa-map-marker-alt"></i> Site
                                                Information</h5>
                                            <p class="mb-1"><strong>Site:</strong> {{ $return->site->name ?? 'N/A' }}</p>
                                            <p class="mb-1"><strong>Branch:</strong>
                                                {{ $return->site->branch->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Return Info -->
                                    <div class="col-md-6">
                                        <div class="p-3 bg-white rounded shadow-sm h-100">
                                            <h5 class="text-primary fw-bold"><i class="fa fa-clipboard-list"></i> Return
                                                Details</h5>
                                            <p class="mb-1"><strong>Date:</strong>
                                                <span class="badge bg-info text-dark">
                                                    {{ $return->created_at->format('d M, Y H:i') }}
                                                </span>
                                            </p>
                                            <p class="mb-0"><strong>Remarks:</strong>
                                                {!! $return->remarks
                                                    ? '<span class="text-muted">' . $return->remarks . '</span>'
                                                    : '<em class="text-secondary">No remarks</em>' !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Products Table -->
                                <div class="table-responsive">
                                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                        <i class="fa fa-boxes"></i> Returned Products
                                    </h5>
                                    <table
                                        class="table table-hover table-bordered align-middle shadow-sm rounded text-center">
                                        <thead class="bg-gradient-primary text-white">
                                            <tr>
                                                <th style="width:60px;">S.N</th>
                                                <th>Product</th>
                                                <th style="width:150px;">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($return->products as $index => $product)
                                                <tr>
                                                    <td><span class="badge bg-secondary">{{ $index + 1 }}</span></td>
                                                    <td class="fw-semibold">{{ $product->product->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            {{ $product->quantity }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer bg-white text-end">
                                <a href="{{ route('orders.return') }}" class="btn btn-info text-light fw-bold shadow-sm">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
