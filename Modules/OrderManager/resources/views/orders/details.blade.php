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

                <!-- Order Status Card -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Left: Status -->
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 me-3" style="margin-right: 5px"><strong>Status:</strong></h5>
                            @if ($order->status == 'completed')
                                <button class="btn btn-sm btn-success">{{ ucfirst($order->status) }}</button>
                            @elseif ($order->status == 'reject')
                                <button class="btn btn-sm btn-danger">{{ ucfirst($order->status) }}</button>
                            @else
                                <button class="btn btn-sm btn-warning">{{ ucfirst($order->status) }}</button>
                            @endif
                        </div>

                        <!-- Center: Take Action -->
                        <div class="text-center flex-grow-1">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#actionModal"
                                @if (in_array($order->status, ['reject', 'completed'])) disabled @endif>
                                Take Action
                            </button>
                        </div>

                        <!-- Right: History -->
                        <div>
                            <a href="{{ route('order.history', $order->id) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-history me-1"></i> View History
                            </a>
                        </div>

                        <!-- Take Action Modal -->
                        <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('orderhistory.store', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title" id="actionModalLabel">Take Action on Order</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($order->products as $index => $item)
                                                <input type="hidden" name="products[{{ $index }}][product_id]"
                                                    value="{{ $item->product->id }}">
                                                <input type="hidden" name="products[{{ $index }}][quantity]"
                                                    value="{{ $item->quantity }}">
                                            @endforeach
                                            <input type="hidden" name="branch_id"
                                                value="{{ $order->project->branch->id ?? 'N/A' }}">
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                                            <div class="form-group">
                                                <label><strong>Select Status</strong></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">-- Select Status --</option>

                                                    @php
                                                        switch ($order->status) {
                                                            case 'pending':
                                                                $allowed = ['accept', 'reject'];
                                                                break;
                                                            case 'accept':
                                                                $allowed = ['reject', 'onloading'];
                                                                break;
                                                            case 'onloading':
                                                                $allowed = ['dispatch'];
                                                                break;
                                                            case 'dispatch':
                                                                $allowed = ['completed'];
                                                                break;
                                                            default:
                                                                $allowed = [];
                                                        }
                                                    @endphp

                                                    @foreach ($allowed as $status)
                                                        <option value="{{ $status }}"
                                                            {{ $order->status == $status ? 'selected' : '' }}>
                                                            {{ ucfirst($status) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Date</strong></label>
                                                <input type="date" name="action_date" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Message</strong></label>
                                                <textarea name="message" class="form-control" rows="3" placeholder="Enter message..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Save Action</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>S.N</th>
                                    <th>Image</th> <!-- ✅ Added -->
                                    <th>Product Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Price</th> <!-- ✅ Added -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->products as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        
                                        <!-- ✅ Product Image -->
                                        <td>
                                            @if ($item->product->image)
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                    alt="Product Image"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>

                                        <td class="text-start ps-4">{{ $item->product->name ?? 'N/A' }}</td>
                                        <td>{{ $item->product->unit->name ?? 'N/A' }}</td>
                                        <td>{{ $item->quantity }}</td>

                                        <!-- ✅ Product Price -->
                                        <td>
                                            @if(isset($item->product->price))
                                                Rs. {{ number_format($item->product->price, 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No products found for this order</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>S.N</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
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
