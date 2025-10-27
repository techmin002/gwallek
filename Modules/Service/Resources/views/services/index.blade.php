@extends('setting::layouts.master')

@section('title', 'Services')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Services</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Services</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Services</li>
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
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" href="{{ route('services.create') }}">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Icon</th>
                                            <th>Image</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>{!! $service->description ?? '-' !!}</td>
                                                <td class="text-center">
                                                    @if ($service->icon)
                                                        <img src="{{ asset('upload/images/services/' . $service->icon) }}"
                                                            width="120px" alt="{{ $service->title }}">
                                                    @else
                                                        <span class="text-muted">No Icon</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($service->image)
                                                        <img src="{{ asset('upload/images/services/' . $service->image) }}"
                                                            width="120px" alt="{{ $service->title }}">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.show', $service->id) }}"
                                                        class="btn btn-info btn-sm">Details</a>
                                                </td>
                                                <td>
                                                    @if ($service->status == 'on')
                                                        <a href="{{ route('services.status', $service->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('services.status', $service->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.edit', $service->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
                                                            event.preventDefault();
                                                            if (confirm('Are you sure? It will delete the service permanently!')) {
                                                                document.getElementById('destroy{{ $service->id }}').submit()
                                                            }
                                                        ">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="destroy{{ $service->id }}" class="d-none"
                                                        action="{{ route('services.destroy', $service->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Icon</th>
                                            <th>Image</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
