@extends('setting::layouts.master')

@section('title', 'Mechanical')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Mechanical</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mechanical</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Mechanical</li>
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
                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#createMechanicalModal">
                                        <i class="fa fa-plus"></i> Create Mechanical
                                    </button>
                                </div>
                            </div>

                            @include('mechanical::mechanical.create') {{-- Create Modal --}}


                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Category</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Purchase Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Vehicle No.</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mechanicals as $mechanical)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $mechanical->name }}</td>
                                                <td class="text-center">{{ $mechanical->category->name ?? '-' }}</td>
                                                @if (auth()->user()->access_type == 'Super Admin')
                                                    <td class="text-center">{{ $mechanical->branch->name ?? '-' }}</td>
                                                @endif
                                                <td class="text-center">{{ $mechanical->purchase_date ?? '-' }}</td>
                                                <td class="text-center">{{ number_format($mechanical->amount, 2) }}</td>
                                                <td class="text-center">{{ $mechanical->vehicle_number ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($mechanical->status == 'on')
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#editMechanicalModal{{ $mechanical->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @include('mechanical::mechanical.edit', [
                                                        'mechanical' => $mechanical,
                                                    ])
                                                    <form
                                                        action="{{ route('mechanicals.items.destroy', $mechanical->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this mechanical?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Category</th>
                                            @if (auth()->user()->access_type == 'Super Admin')
                                                <th class="text-center">Branch</th>
                                            @endif
                                            <th class="text-center">Purchase Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Vehicle No.</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
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

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
