@extends('setting::layouts.master')

@section('title', 'Edit Service Type')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Service Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('services.show', $service->id) }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- form column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Service Type</h3>
                            </div>

                            <form action="{{ route('type.update', $type->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <div class="card-body">
                                    <!-- Service Name (readonly) -->
                                    <div class="form-group">
                                        <label>Service</label>
                                        <input type="text" class="form-control" value="{{ $service->name }}" readonly>
                                    </div>

                                    <!-- Service Name -->
                                    <div class="form-group">
                                        <label for="name">Service Type Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter service Type name" value="{{ old('name', $service->name) }}"
                                            required>
                                        @error('name')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter title"
                                            value="{{ old('title', $type->title) }}" required>
                                        @error('title')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Overview -->
                                    <div class="form-group">
                                        <label for="overview">Overview</label>
                                        <textarea name="overview" class="form-control summernote" rows="4" placeholder="Enter overview">{{ old('overview', $type->overview) }}</textarea>
                                        @error('overview')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Benefits -->
                                    <div class="form-group">
                                        <label for="benifits">Benefits</label>
                                        <textarea name="benifits" class="form-control summernote" rows="4" placeholder="Enter benefits">{{ old('benifits', $type->benifits) }}</textarea>
                                        @error('benifits')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control summernote" placeholder="Enter description">{{ old('description', $type->description) }}</textarea>
                                        @error('description')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Image Upload -->
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" onchange="showPreview1(event);"
                                                    name="image">
                                                @error('image')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror

                                                <div class="preview mt-2">
                                                    @if ($type->image)
                                                        <img src="{{ asset('upload/images/servicestype/' . $type->image) }}"
                                                            id="file-ip-1-preview" width="200px">
                                                    @else
                                                        <img src="" id="file-ip-1-preview" width="200px"
                                                            style="display:none;">
                                                    @endif
                                                </div>
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
                                                <input type="checkbox" name="status" data-bootstrap-switch
                                                    data-off-color="danger" data-on-color="success"
                                                    {{ $type->status == 'on' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize Summernote for all textareas with class 'summernote'
            $('.summernote').summernote({
                placeholder: 'Enter text here...',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Image Preview
            window.showPreview1 = function(event) {
                if (event.target.files.length > 0) {
                    var src = URL.createObjectURL(event.target.files[0]);
                    var preview = document.getElementById("file-ip-1-preview");
                    preview.src = src;
                    preview.style.display = "block";
                }
            }
        });
    </script>
@endsection
