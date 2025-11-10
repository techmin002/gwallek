@extends('setting::layouts.master')

@section('title', 'Edit Product')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit Product</li>
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
                                <h3 class="fw-bold">Edit Product</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-3">

                                        <!-- Product Name -->
                                        <div class="col-md-6">
                                            <label class="fw-semibold">Product Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $product->name }}" required>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6">
                                            <label class="fw-semibold">Category</label>
                                            <select name="category_id" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Brand -->
                                        <div class="col-md-6 mt-3">
                                            <label class="fw-semibold">Brand</label>
                                            <select name="brand_id" class="form-control" required>
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-3 mt-3">
                                            <label class="fw-semibold">Price</label>
                                            <input type="number" step="0.01" name="price" class="form-control"
                                                value="{{ $product->price }}">
                                        </div>

                                        <!-- Unit -->
                                        <div class="col-md-3 mt-3">
                                            <label class="fw-semibold">Unit</label>
                                            <select name="unit_id" class="form-control">
                                                <option value="">Select Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Stock -->
                                        <div class="col-md-6 mt-3">
                                            <label class="fw-semibold">Stock</label>
                                            <input type="number" name="stock" class="form-control"
                                                value="{{ $product->stock }}">
                                        </div>

                                        <!-- Branch -->
                                        @if (auth()->user()->name === 'Super Admin')
                                            <!-- Show branch select only for Super Admin -->
                                            <div class="col-md-6 mt-3">
                                                <label class="fw-semibold">Branch</label>
                                                <select name="branch_id" class="form-control">
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            {{ $product->branch_id == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <!-- Hidden input for normal users -->
                                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                        @endif


                                        <!-- Main Image -->
                                        <div class="col-md-6 mt-3">
                                            <label class="fw-semibold">Product Image</label>
                                            <input type="file" name="image" class="form-control">
                                            @if ($product->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('upload/products/' . $product->image) }}"
                                                        width="100">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" id="summernote">{{ $product->description }}</textarea>
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
                                                        {{ $product->status == 'on' ? 'checked' : '' }}
                                                        data-bootstrap-switch data-off-color="danger"
                                                        data-on-color="success">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer justify-content-start mt-3">
                                        <button type="submit" class="btn btn-success">Update Product</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-danger ms-2">Cancel</a>
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
