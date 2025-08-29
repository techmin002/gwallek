@extends('setting::layouts.master')

@section('title', 'Edit Category')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">Edit Category</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="card shadow-lg" style="border-radius: 24px; border:none;">
                            <div class="card-header text-center"
                                style="background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%); color:#fff;">
                                <h3 class="fw-bold">Edit Category</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('categories.update', $category->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-3">

                                        <!-- Category Name -->
                                        <div class="col-md-12">
                                            <label class="fw-semibold">Category Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $category->name }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" id="summernote">{{ $category->description }}</textarea>
                                        </div>

                                        <!-- Existing Image -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Current Image</label><br>
                                            @if ($category->image)
                                                <img src="{{ asset('upload/categories/' . $category->image) }}"
                                                    width="100">
                                            @else
                                                -
                                            @endif
                                        </div>

                                        <!-- Category Image -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Change Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                        </div>

                                        <!-- Publish Status -->
                                        <div class="col-md-12 mt-3">
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Publish</h3>
                                                </div>
                                                <div class="card-body">
                                                    <input type="hidden" name="status" value="off">
                                                    <input type="checkbox" name="status" value="on"
                                                        {{ $category->status == 'on' ? 'checked' : '' }}
                                                        data-bootstrap-switch data-off-color="danger"
                                                        data-on-color="success">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer justify-content-start">
                                        <button type="submit" class="btn btn-success">Update Category</button>
                                        <a href="{{ route('categories.index') }}" class="btn btn-danger ms-2">Cancel</a>
                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
