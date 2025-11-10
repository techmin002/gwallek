@extends('setting::layouts.master')

@section('title', 'Advisors')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Advisors</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" href="{{ route('advisors.create') }}">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Type</th>
                                            <th>LinkedIn</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($advisors as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><img
                                                        src="{{ asset('upload/images/advisor/' . $value->image) }}"
                                                        width="120px" alt="{{ $value->name }}"> </td>
                                                <td>{{ $value->type }}</td>
                                                <td>
                                                    @if ($value->linkedin)
                                                        <a href="{{ $value->linkedin }}" target="_blank">
                                                            <i class="fab fa-linkedin"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('advisors.status', $value->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('advisors.status', $value->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('advisors.edit', $value->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
                                                event.preventDefault();
                                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                                    document.getElementById('destroy{{ $value->id }}').submit()
                                                }
                                            ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $value->id }}" class="d-none"
                                                            action="{{ route('advisors.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Type</th>
                                            <th>LinkedIn</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
