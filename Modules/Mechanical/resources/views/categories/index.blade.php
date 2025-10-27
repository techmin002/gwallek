@extends('setting::layouts.master')

@section('title', 'Mechanical Categories')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Mechanical Categories</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mechanical Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Mechanical Categories</li>
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
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#createCategoryModal">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                                @include('mechanical::categories.create')
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $category->name }}</td>

                                                <td class="text-center">
                                                    @if ($category->image)
                                                        <img src="{{ asset('upload/images/mechanicalscategories/' . $category->image) }}"
                                                            alt="{{ $category->name }}" width="50"
                                                            class="img-thumbnail">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="text-center">{{ $category->description ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($category->status == 'on')
                                                        <a href="{{ route('mechanicals.categories.status', $category->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('mechanicals.categories.status', $category->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Edit Button --}}
                                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editCategoryModal{{ $category->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    {{-- Edit Modal --}}
                                                    @include('mechanical::categories.edit', [
                                                        'category' => $category,
                                                    ])

                                                    <form
                                                        action="{{ route('mechanicals.categories.destroy', $category->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
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
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Description</th>
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
