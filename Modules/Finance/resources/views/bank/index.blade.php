@extends('setting::layouts.master')

@section('title', 'Banks')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Banks</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Banks</h1>
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
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal" data-target="#createBankModal">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                                @include('finance::bank.create')
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Bank Name</th>
                                            <th class="text-center">Holder Name</th>
                                            <th class="text-center">Account No.</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Mobile No</th>
                                            <th class="text-center">Opening Amount</th>
                                            <th class="text-center">Closing Amount</th>
                                            <th class="text-center">View Details</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banks as $bank)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $bank->bank_name }}</td>
                                                <td class="text-center">{{ $bank->bank_holder_name }}</td>
                                                <td class="text-center">{{ $bank->account_number }}</td>
                                                <td class="text-center">{{ $bank->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $bank->mobile_no ?? '-' }}</td>
                                                <td class="text-center">{{ number_format($bank->opening_amount, 2) }}</td>
                                                <td class="text-center">{{ number_format($bank->closing_amount, 2) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('banks.show', $bank->id) }}"
                                                        class="btn btn-sm btn-info" data-toggle="tooltip" title="View Bank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if ($bank->status == 'on')
                                                        <a href="{{ route('banks.status', $bank->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('banks.status', $bank->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                {{-- <td class="text-center">{{ $bank->created_at->format('Y-m-d') }}</td> --}}
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#editBankModal{{ $bank->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('finance::bank.edit')

                                                    <form action="{{ route('banks.destroy', $bank->id) }}" method="POST"
                                                        style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this bank?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" title="Delete">
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
                                            <th class="text-center">Bank Name</th>
                                            <th class="text-center">Holder Name</th>
                                            <th class="text-center">Account No.</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Mobile No</th>
                                            <th class="text-center">Opening Amount</th>
                                            <th class="text-center">Closing Amount</th>
                                            <th class="text-center">View Details</th>
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
@endsection
