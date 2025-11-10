@extends('setting::layouts.master')

@section('title', 'Edit Brand')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
        <li class="breadcrumb-item active">Edit Brand</li>
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
                                <h3 class="fw-bold">Edit Brand</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('brands.update', $brand->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-3">

                                        <!-- Brand Name -->
                                        <div class="col-md-12">
                                            <label class="fw-semibold">Brand Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $brand->name }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" id="summernote">{{ $brand->description }}</textarea>
                                        </div>

                                        <!-- Brand Image -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Brand Image</label>
                                            <input type="file" name="image" class="form-control">
                                            @if ($brand->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('upload/brands/' . $brand->image) }}"
                                                        alt="{{ $brand->name }}" width="100">
                                                </div>
                                            @endif
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
                                                        {{ $brand->status == 'on' ? 'checked' : '' }} data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer justify-content-start">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('brands.index') }}" type="button"
                                            class="btn btn-danger btn-sm ms-2">Cancel</a>
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
