@extends('setting::layouts.master')

@section('title', 'Order Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Approved Orders</a></li>
        <li class="breadcrumb-item active">Order Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Approved Order Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Approved Orders</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Info -->
        <div class="card shadow-lg border-0 rounded mb-4"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center text-white py-3">
                <h5 class="mb-2 fw-bold">Project</h5>
                <h3 class="fw-bold">{{ $order->project->name ?? 'N/A' }}</h3>
                <p class="mb-0">Order Date: {{ $order->created_at ? $order->created_at->format('d M, Y H:i') : 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{-- 🔹 Debug Info --}}
                @if ($order->items->count() > 0)
                    <div class="alert alert-info">
                        Total Items: {{ $order->items->count() }} |
                        Approved Items: {{ $approvedItems->count() }}
                    </div>
                @endif

                {{-- 🔹 Approved Items Table --}}
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h3 class="card-title">Approved Items</h3>
                    </div>
                    <div class="card-body">
                        @if ($approvedItems->count() > 0)
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvedItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->unit ?? '-' }}</td>
                                            <td>
                                                @if ($item->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($item->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($item->status == 'partial_purchased')
                                                    <span class="badge bg-info">Partial Purchased</span>
                                                @elseif($item->status == 'full_purchased')
                                                    <span class="badge bg-primary">Full Purchased</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning text-center">
                                <h5>No Approved Items Found</h5>
                                <p class="mb-0">There are no approved items in this order yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 🟢 Purchase Form for Approved Items --}}
                @if ($approvedItems->count() > 0)
                    @include('ordermanager::purchases.create', [
                        'order' => $order,
                        'approvedItems' => $approvedItems,
                    ])
                @endif

                {{-- 🔹 Nested Purchase Items Table --}}
                @if ($item->purchases->count() > 0)
                    <tr>
                        <td colspan="5" class="p-0">
                            <table class="table table-sm table-bordered mb-0 text-center">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Quantity Purchased</th>
                                        <th>Price Per Unit</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->purchases as $pIndex => $purchase)
                                        <tr>
                                            <td>{{ $pIndex + 1 }}</td>
                                            <td>{{ $purchase->title ?? '-' }}</td>
                                            <td>{{ $purchase->purchased_qty }}</td>
                                            <td>{{ number_format($purchase->per_unit_price, 2) }}</td>
                                            <td>{{ number_format($purchase->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endif

                <div class="mt-3">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Orders
                    </a>
                </div>

            </div>
        </section>
    </div>
@endsection
