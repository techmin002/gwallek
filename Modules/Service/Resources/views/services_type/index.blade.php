@extends('setting::layouts.master')

@section('title', 'Service Type')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Service Type</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service Type ( {{ $servicetype->name }} )</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Type</li>
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
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" href="{{ route('type.create', $servicetype->id) }}">
                                        <i class="fa fa-plus"></i> Add Service Type
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
                                            <th>Title</th>
                                            {{-- <th>Overview</th>
                                            <th>Description</th>
                                            <th>Benefits</th> --}}
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicetype->type as $why)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $why->name }}</td>
                                                <td>{{ $why->title }}</td>
                                                {{-- <td>{!! $why->overview !!}</td>
                                                <td>{!! $why->description ?? '-' !!}</td>
                                                <td>{!! $why->benifits ?? '-' !!}</td> --}}
                                                <td class="text-center">
                                                    @if ($why->image)
                                                        <img src="{{ asset('upload/images/servicestype/' . $why->image) }}"
                                                            width="120px" alt="{{ $why->title }}">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($why->status == 'on')
                                                        <a href="{{ route('type.status', $why->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('type.status', $why->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('type.edit', $why->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();
                                                            if(confirm('Are you sure? It will delete permanently!')) {
                                                                document.getElementById('destroy{{ $why->id }}').submit()
                                                            }">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="destroy{{ $why->id }}" class="d-none"
                                                        action="{{ route('type.delete', $why->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            {{-- <th>Overview</th>
                                            <th>Description</th>
                                            <th>Benefits</th> --}}
                                            <th>Image</th>
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
                </div>
            </div>
        </section>
    </div>
@endsection
