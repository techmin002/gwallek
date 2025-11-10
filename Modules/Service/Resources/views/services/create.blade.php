@extends('setting::layouts.master')

@section('title', 'Create Service')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <h3 class="card-title">Create Service</h3>
                            </div>

                            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Service Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter service name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="summernote" placeholder="Enter description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="icon">Icon</label>
                                                <input type="file" id="file-ip-1" accept="icon/*"
                                                    class="form-control-file border" onchange="showPreview1(event);"
                                                    name="icon">
                                                @error('icon')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="200px"
                                                        style="display:none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Image </label>
                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ old('image') }}"
                                                    onchange="showPreview1(event);" name="image">
                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="200px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Publish</h3>
                                            </div>
                                            <div class="card-body">
                                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                                    data-off-color="danger" data-on-color="success">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $('textarea.summernote').summernote({
            placeholder: 'Enter Description',
            tabsize: 2,
            height: 200
        });
    </script>
@endsection
