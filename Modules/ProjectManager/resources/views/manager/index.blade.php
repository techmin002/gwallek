@extends('setting::layouts.master')

@section('title', 'Project Manager')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Project Manager</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Project Manager</h1>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th>S.R</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($managers as $manager)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $manager->name }}</td>
                                                <td class="text-center">{{ $manager->email ?? '-' }}</td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">
                                                        {{ $manager->branch ? $manager->branch->name : '-' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="{{ route('managers.show', $manager->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>S.R</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th>Branch</th>
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
    </div>
@endsection
