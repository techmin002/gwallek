@extends('setting::layouts.master')

@section('title', 'Orders')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Order History Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1>Order History Details</h1>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header shadow-lg border-0 rounded mb-4"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body text-center text-white py-3">
                                    <h3 class="fw-bold">{{ $data->project->name ?? 'N/A' }}</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.N</th>
                                            <th>Status</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data->histories as $history)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span
                                                        class="badge
            @if ($history->status == 'completed') bg-success
            @elseif($history->status == 'reject') bg-danger
            @else bg-warning @endif">
                                                        {{ ucfirst($history->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $history->message ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($history->date)->format('d M Y') }}</td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="4">No History found for this order</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Status</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('orders.show', $data->id) }}" class="btn btn-secondary mt-3"><i
                                        class="fa fa-arrow-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
