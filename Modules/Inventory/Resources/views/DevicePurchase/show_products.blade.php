@extends('setting::layouts.master')

@section('title', 'Purchased Products')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Purchased Products</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Purchased Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Purchased Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- PURCHASE INFO --}}
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">
                                <i class="fas fa-info-circle mr-2"></i> Purchase Information
                            </h3>
                        </div>
                        <div class="badge-group">
                            <span class="badge badge-info">
                                <i class="fas fa-user-tie mr-1"></i> Supplier: {{ $supplier->name ?? '-' }}
                            </span>
                            <span class="badge badge-info ml-2">
                                <i class="fas fa-file-invoice mr-1"></i> Bill No: {{ $bill_no ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- PRODUCTS TABLE --}}
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-box mr-2"></i>Products List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->product->name ?? '-' }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ number_format($product->unit_price, 2) }}</td>
                                            <td>{{ number_format($product->total, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- SUMMARY CARD --}}
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title"><i class="fas fa-calculator mr-2"></i>Purchase Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-5">Total Products:</dt>
                                    <dd class="col-sm-7">{{ $products->count() }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-5">Products Total:</dt>
                                    <dd class="col-sm-7">{{ number_format($products->sum('total'), 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-right">
                                <h4 class="mb-0">
                                    <span class="text-muted mr-2">Grand Total:</span>
                                    <span class="text-primary">
                                        {{ number_format($products->sum('total'), 2) }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
