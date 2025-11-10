@extends('setting::layouts.master')

@section('title', 'Edit Services')


@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Edit Service</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Service</h3>
                    </div>
                    <form action="{{ route('services.update', $service->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Service Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ old('name', $service->name) }}" placeholder="Enter service name" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="summernote" rows="4" placeholder="Enter description">{{ old('description', $service->description) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon">Icon</label>
                                        <input type="file" id="file-ip-1" accept="image/*"
                                            class="form-control-file border" onchange="showPreview1(event);" name="icon">
                                        @error('icon')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror

                                        <div class="preview mt-2">
                                            @if ($service->icon)
                                                <img src="{{ asset('upload/images/services/' . $service->icon) }}"
                                                    id="file-ip-1-preview" width="200px">
                                            @else
                                                <img src="" id="file-ip-1-preview" width="200px"
                                                    style="display:none;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- Image --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" id="file-ip-1" accept="image/*"
                                            class="form-control-file border" onchange="showPreview1(event);" name="image">
                                        @if ($service->image)
                                            <img src="{{ asset('upload/images/services/' . $service->image) }}"
                                                alt="{{ $service->title }}" width="200px" class="mt-2">
                                        @endif
                                        <div class="preview mt-2">
                                            <img src="" id="file-ip-1-preview" width="200px">
                                        </div>
                                        @error('image')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- Publish --}}
                            <div class="col-md-6">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="checkbox" name="status" data-bootstrap-switch data-off-color="danger"
                                            data-on-color="success" {{ $service->status == 'on' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
