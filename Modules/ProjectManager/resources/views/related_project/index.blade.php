@extends('setting::layouts.master')

@section('title', 'Related Project')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Related Project</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Related Project</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Related Project</li>
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
                            {{-- @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin') --}}
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a href="{{ route('relatedproject.create', $site->id) }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Related Project
                                    </a>
                                </h3>

                            </div>
                            {{-- @endif --}}

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($site->relatedProjects as $project)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>
                                                    @if ($project->image)
                                                        <img src="{{ asset('upload/site/related_projects/' . $project->image) }}"
                                                            width="60" class="rounded">
                                                    @else
                                                        <span class="badge badge-secondary">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{!! $project->description !!}</td>
                                                <td>
                                                    @if ($project->status == 'on')
                                                        <a href="{{ route('relatedproject.status', $project->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('relatedproject.status', $project->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Edit -->
                                                    <a href="{{ route('relatedproject.edit', $project->id) }}" type="button" class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('relatedproject.destroy', $project->id) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#relatedProjectsTable').DataTable({
                "pageLength": 10,
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endpush
