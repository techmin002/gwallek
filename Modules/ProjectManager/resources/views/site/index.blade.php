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
                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                <div class="card-header">
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Create
                                        </a>
                                    </h3>
                                    @include('projectmanager::site.create')
                                </div>
                            @endif

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Site Name</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Details</th>
                                            <th class="text-center">Site Images & Related Project</th>
                                            <th class="text-center">Status</th>
                                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sites as $site)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $site->name }}</td>
                                                <td class="text-center">{{ $site->amount }}</td>
                                                <td class="text-center">{{ $site->start_date }}</td>
                                                <td class="text-center">
                                                    @if ($site->end_date)
                                                        {{ $site->end_date }}
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">{{ $site->branch->name ?? '---' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="{{ route('sites.details', $site->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        View Details
                                                    </a>
                                                    <a href="{{ route('paymentdetails.index', $site->id) }}"
                                                        class="btn btn-sm btn-info  m-1" title="Project Info">Payment
                                                        Details
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('sites.images', $site->id) }}"
                                                        class="btn btn-info btn-sm w-75">
                                                        Site Images
                                                    </a>
                                                    <a href="{{ route('relatedproject.index', $site->id) }}"
                                                        class="btn btn-info btn-sm w-75 mt-2">
                                                        Related Project
                                                    </a>
                                                </td>
                                                </td>
                                                <td class="text-center">
                                                    @if ($site->status == 'on')
                                                        <a href="{{ route('site.status', $site->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('site.status', $site->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info"
                                                            data-toggle="modal"
                                                            data-target="#editSiteModal{{ $site->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @include('projectmanager::site.edit')
                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $site->id }}').submit()}">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $site->id }}" class="d-none"
                                                                action="{{ route('sites.destroy', $site->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Address</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Details</th>
                                            <th class="text-center">Site Images & Related Project</th>
                                            <th class="text-center">Status</th>
                                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                <th class="text-center">Action</th>
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
