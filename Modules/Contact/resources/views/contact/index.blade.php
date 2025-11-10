@extends('setting::layouts.master')

@section('title', 'Contact')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Contact</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contact</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contact</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            @if (auth()->user()->name === 'Super Admin')
                                            <th>Branch Name</th>
                                            @endif
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $key => $contact)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->subject ?? '-' }}</td>
                                                <td>{{ $contact->message }}</td>
                                                @if (auth()->user()->name === 'Super Admin')
                                                    <td>{{ $contact->branch->name ?? 'N/A' }}</td>
                                                @endif
                                                <td>
                                                    @if ($contact->status == 'pending')
                                                        <a href="{{ route('messages.toggleStatus', $contact->id) }}"
                                                            class="btn btn-danger btn-sm">
                                                            Pending
                                                        </a>
                                                    @else
                                                        <span class="btn btn-success btn-sm disabled">Read</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="
                    event.preventDefault();
                    if(confirm('Are you sure? This will delete the contact permanently!')){
                        document.getElementById('destroy{{ $contact->id }}').submit();
                    }
                ">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="destroy{{ $contact->id }}"
                                                        action="{{ route('messages.destroy', $contact->id) }}"
                                                        method="POST" class="d-none">
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
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            @if (auth()->user()->name === 'Super Admin')
                                            <th>Branch Name</th>
                                            @endif
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
