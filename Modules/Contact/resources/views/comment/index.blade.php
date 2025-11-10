@extends('setting::layouts.master')

@section('title', 'Blog Comments')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Blog Comments</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Blog Comments</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Blog</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $key => $comment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $comment->blog->title ?? 'N/A' }}</td>
                                                <td>{{ $comment->name }}</td>
                                                <td>{{ $comment->email }}</td>
                                                <td>{{ $comment->website ?? '-' }}</td>
                                                <td>{{ $comment->comment }}</td>
                                                <td>
                                                    @if ($comment->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($comment->status == 'accept')
                                                        <span class="badge bg-success">Accept</span>
                                                    @else
                                                        <span class="badge bg-danger">Reject</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($comment->status != 'accept')
                                                        <form action="{{ route('blogscomment.accept', $comment->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Accept</button>
                                                        </form>
                                                    @endif
                                                    @if ($comment->status != 'reject')
                                                        <form action="{{ route('blogscomment.reject', $comment->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm mt-2">Reject</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Blog</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Comment</th>
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
