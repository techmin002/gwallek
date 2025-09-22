@extends('setting::layouts.master')

@section('title', 'Order Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">Order Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Order Details</h1>
                <h5>Project: {{ $order->project->name ?? 'N/A' }}</h5>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->products as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->product->unit->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No products found for this order</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Grand Total</th>
                                    <th>{{ number_format($order->total_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3"><i
                                class="fa fa-arrow-left"></i> Back to Orders</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
