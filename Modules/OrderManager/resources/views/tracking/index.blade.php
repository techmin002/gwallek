@extends('setting::layouts.master')

@section('title', 'Order Tracking')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Orders Tracking</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-primary"><i class="fas fa-shipping-fast me-2"></i> Track Your Order</h2>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">

                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-shipping-fast me-2"></i> Track Your Order</h3>
                    </div>
                    <div class="card-body">

                        {{-- Search Form --}}
                        <form action="{{ route('orders.tracking.search') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="order_id" id="order_id" class="form-control"
                                    placeholder="Enter Order ID..." required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Error Message --}}
                        @if (session('error'))
                            <div class="alert alert-danger mt-3 shadow-sm">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        {{-- Show Order Details --}}
                        @isset($order)
                            <div class="card border-success shadow-sm mt-3">
                                <div class="card-header bg-success text-white">
                                    <h4 class="card-title mb-0">
                                        <i class="fas fa-info-circle mr-2"></i>Details of Order #{{ $order->id }}
                                    </h4>
                                </div>
                                <div class="card-body p-3">
                                    <table class="table table-custom mb-0">
                                        <tbody>
                                            <tr>
                                                <th>ID</th>
                                                <td>{{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @php
                                                        $statusClass = match ($order->status) {
                                                            'completed' => 'success',
                                                            'reject' => 'danger',
                                                            'dispatch' => 'info',
                                                            default => 'warning',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $statusClass }} rounded-pill">{{ ucfirst($order->status) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Project</th>
                                                <td>{{ $order->project->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Branch</th>
                                                <td>{{ $order->project->branch->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Details</th>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-gradient-primary">
                                                        <i class="fa fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endisset

                    </div>
                </div>

            </div>
        </section>
    </div>
    @push('styles')
        <style>
            .table-custom {
                border-radius: 0.75rem;
                overflow: hidden;
                border: 1px solid #e0e0e0;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .table-custom th,
            .table-custom td {
                padding: 0.75rem 1rem;
                vertical-align: middle;
            }

            .table-custom tbody tr {
                transition: all 0.3s ease;
            }

            .table-custom tbody tr:hover {
                background-color: #f7f9fc;
            }

            .table-custom th {
                background-color: #f5f5f5;
                font-weight: 600;
                width: 25%;
            }

            .btn-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #fff;
                border: none;
                transition: all 0.3s ease;
            }

            .btn-gradient-primary:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }
        </style>
    @endpush
@endsection
