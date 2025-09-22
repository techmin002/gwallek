@extends('setting::layouts.master')

@section('title', 'Site')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Site</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Site</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Site</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Site Name</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Due Amount</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Payment Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sites as $site)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $site->name }}</td>
                                                <td class="text-center">{{ $site->amount }}</td>
                                                <td class="text-center">{{ $site->payment?->paid_amount ?? 0 }}</td>
                                                <td class="text-center">{{ $site->payment?->due_amount ?? 0 }}</td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">{{ $site->branch->name ?? '---' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="{{ route('paymentdetails.index', $site->id) }}"
                                                        class="btn btn-sm btn-info  m-1" title="Project Info">Payment
                                                        Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Site Name</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Due Amount</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Payment Details</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
