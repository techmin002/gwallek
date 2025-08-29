@extends('setting::layouts.master')

@section('title', 'Customer')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Customer</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
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
                            <div class="card-header">
                                @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Create
                                        </a>
                                    </h3>
                                    @include('projectmanager::customer.create')
                                @endif
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>S.R</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Address</th> --}}
                                            <th>Image</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Status</th>
                                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $customer->name }}</td>
                                                <td class="text-center">{{ $customer->phone }}</td>
                                                <td class="text-center">{{ $customer->email ?? '-' }}</td>
                                                {{-- <td class="text-center">{{ $customer->address }}</td> --}}
                                                <td class="text-center">
                                                    @if ($customer->image)
                                                        <img src="{{ asset('upload/images/customers/' . $customer->image) }}"
                                                            width="120px">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>

                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">{{ $customer->branch->name ?? '-' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    @if ($customer->status == 'on')
                                                        <a href="{{ route('customer.status', $customer->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('customer.status', $customer->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                    <td>
                                                        <!-- Edit Button -->
                                                        <button type="button" class="btn btn-sm btn-info"
                                                            data-toggle="modal"
                                                            data-target="#editCustomerModal{{ $customer->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @include('projectmanager::customer.edit')

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                                class="btn btn-sm btn-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>S.R</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Address</th> --}}
                                            <th>Image</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Status</th>
                                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                <th>Actions</th>
                                            @endif
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
