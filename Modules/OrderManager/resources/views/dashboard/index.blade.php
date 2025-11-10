@extends('setting::layouts.master')

@section('title', 'Completed Orders')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Orders Dashboard</li>
    </ol>
@endsection

@section('content')
    <style>
        .card {
            border-radius: 15px;
            border: none;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-footer-link {
            display: block;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 10px 0;
            font-weight: 500;
            text-decoration: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .card-footer-link i {
            margin-left: 6px;
            transition: transform 0.3s ease;
        }

        .card-footer-link:hover {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
            text-decoration: none;
        }

        .card-footer-link:hover i {
            transform: translateX(5px);
        }
    </style>

    <div class="content-wrapper">
        <div class="mt-5 container-fluid">
            <h3 class="mb-3" style="font-weight: 700">Orders Dashboard</h3>
            <div class="row">
                <!-- Total Orders -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-white shadow"
                        style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 15px; overflow: hidden;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="text-center">
                                <h3 class="card-title mb-4" style="font-size: 1.2rem; font-weight: 600;">Total Orders</h3>
                                <br>
                                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $totalorders }}</h2>
                            </div>
                            <i class="fas fa-box fa-2x ms-5"></i>
                        </div>

                        <a href="{{ route('orders.index') }}" class="card-footer-link">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Dispatched Orders -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-white shadow"
                        style="background: linear-gradient(135deg, #1cf94c, #039422); border-radius: 15px; overflow: hidden;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="text-center">
                                <h3 class="card-title mb-4" style="font-size: 1.2rem; font-weight: 600;">Dispatched</h3><br>
                                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $dispatchorders }}</h2>
                            </div>
                            <i class="fas fa-truck fa-2x ms-5"></i>
                        </div>

                        <a href="{{ route('orders.dispatched') }}" class="card-footer-link">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Rejected Orders -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-white shadow"
                        style="background: linear-gradient(135deg, #e74a3b, #be2617); border-radius: 15px; overflow: hidden;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="text-center">
                                <h3 class="card-title mb-4" style="font-size: 1.2rem; font-weight: 600;">Rejected</h3><br>
                                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $rejectedorders }}</h2>
                            </div>
                            <i class="fas fa-times-circle fa-2x ms-5"></i>
                        </div>

                        <a href="{{ route('orders.rejected') }}" class="card-footer-link">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-white shadow"
                        style="background: linear-gradient(135deg, #36b9cc, #258391); border-radius: 15px; overflow: hidden;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="text-center">
                                <h3 class="card-title mb-4" style="font-size: 1.2rem; font-weight: 600;">Completed</h3><br>
                                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $completeorders }}</h2>
                            </div>
                            <i class="fas fa-check-circle fa-2x ms-5"></i>
                        </div>

                        <a href="{{ route('orders.completed') }}" class="card-footer-link">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="col-lg-12 connectedSortable">
            <div class="card">
                <div class="card-body">
                    <h5 style="font-weight: 700">Order Table</h5>
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Project Name</th>
                                <th>View Details</th>
                                @if (auth()->user()->access_type == 'Super Admin')
                                <th>Branch</th>
                                @endif
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->project->name ?? 'N/A' }}</td>

                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-secondary">
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
                                        <button
                                            class="btn btn-sm
        @if ($order->status == 'completed') btn-success
        @elseif($order->status == 'reject') btn-danger
        @else btn-warning @endif">
                                            {{ ucfirst($order->status ?? 'Pending') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Project Name</th>
                                <th>View Details</th>
                                @if (auth()->user()->access_type == 'Super Admin')
                                <th>Branch</th>
                                @endif
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
@endsection
