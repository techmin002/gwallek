@extends('setting::layouts.master')

@section('title', 'Order Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                        <h1>Order Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders lists</a></li>
                            
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
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>S.N</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items as $index => $item)
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

                                        {{-- <td>
                                            @if ($item->status == 'pending')
                                                <form action="{{ route('orders.items.status', [$order->id, $item->id]) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button name="status" value="approved"
                                                        class="btn btn-success btn-sm">Approve</button>
                                                    <button name="status" value="rejected"
                                                        class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            @else
                                                <em class="text-muted">No action</em>
                                            @endif
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No items found for this order</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot class="table-light">
                                <tr>
                                    <th>S.N</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer">
                        <a href="javascript:void(0);" onclick="history.back();" class="btn btn-secondary mt-3">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
