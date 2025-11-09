@extends('setting::layouts.master')

@section('title', 'Orders return')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Orders return</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders return</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Orders return</li>
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
                                    <a href="#" class="btn btn-info shadow" data-toggle="modal"
                                        data-target="#createReturnModal">
                                        <i class="fa fa-plus-circle"></i> Create Return
                                    </a>
                                    @include('ordermanager::return.create')
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-hover table-bordered align-middle">
                                    <thead class="text-dark text-center">
                                        <tr>
                                            <th>S.N</th>
                                            <th>Site</th>
                                            @if (auth()->user()->name === 'Super Admin')
                                            <th>Branch</th>
                                            @endif
                                            <th>Date</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($returns as $return)
                                            <tr>
                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-primary">{{ $loop->iteration }}</span>
                                                </td>
                                                <td class="text-center"><strong>{{ $return->site->name ?? 'N/A' }}</strong>
                                                </td>
                                                @if (auth()->user()->name === 'Super Admin')
                                                    <td class="text-center">
                                                        <span class="badge badge-info">
                                                            {{ $return->site->branch->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                @endif

                                                <td class="text-center"><i class="far fa-clock text-muted"></i>
                                                    {{ $return->created_at->format('d M, Y H:i') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('returns.details', $return->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>

                                                <td>
                                                    <a data-toggle="modal" data-target="#editReturnModal{{ $return->id }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('ordermanager::return.edit')
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
            document.getElementById('destroy{{ $return->id }}').submit()
        }
        ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $return->id }}" class="d-none"
                                                            action="{{ route('returns.destroy', $return->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light text-center">
                                        <tr>
                                            <th>S.N</th>
                                            <th>Site</th>
                                            @if (auth()->user()->name === 'Super Admin')
                                            <th>Branch</th>
                                            @endif
                                            <th>Date</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
        </section>
    </div>
@endsection
