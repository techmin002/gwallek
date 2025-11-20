@extends('setting::layouts.master')

@section('title', 'Orders')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Approved All Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Approved All Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                              <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Project Name</th>
                                            <th>View Details</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Date </th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->project->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('purchases.show', $order->id) }}"
                                                        class="btn btn-sm btn-secondary">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td>{{ $order->project->branch->name ?? 'N/A' }}</td>
                                                @endif


                                                <td>
                                                    {{ $order->created_at ? $order->created_at->format('d M, Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusLabel = $order->status;
                                                        $statusClass = 'btn-secondary';

                                                        if ($order->status == 'pending') {
                                                            $statusLabel = 'pending';
                                                            $statusClass = 'btn-warning';
                                                        } elseif ($order->status == 'approved') {
                                                            $statusLabel = 'approved';
                                                            $statusClass = 'btn-success';
                                                        } elseif ($order->status == 'rejected') {
                                                            $statusLabel = 'Rejected';
                                                            $statusClass = 'btn-danger';
                                                        }
                                                    @endphp

                                                    <span class="btn btn-sm {{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Project Name</th>
                                            <th>payments</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#ordersTable').DataTable({
                "pageLength": 10,
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endpush
