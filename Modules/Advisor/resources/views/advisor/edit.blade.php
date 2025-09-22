@extends('setting::layouts.master')

@section('title', 'Edit Advisor')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('advisors.index') }}">Advisors</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <form action="{{ route('advisors.update', $advisor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $advisor->name) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <input type="text" name="type" class="form-control"
                                                    value="{{ old('type', $advisor->type) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text" name="designation" class="form-control"
                                                    value="{{ old('designation', $advisor->designation) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Experience</label>
                                                <input type="text" name="experience" class="form-control"
                                                    value="{{ old('experience', $advisor->experience) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Projects</label>
                                                <input type="text" name="projects" class="form-control"
                                                    value="{{ old('projects', $advisor->projects) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>LinkedIn</label>
                                                <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username"
                                                    value="{{ old('linkedin', $advisor->linkedin) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="mail"  placeholder="abcs@email.com" class="form-control"
                                                    value="{{ old('mail', $advisor->mail) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Facebook</label>
                                                <input type="url" name="facebook" class="form-control"
                                                    placeholder="https://facebook.com/username"
                                                    value="{{ old('facebook', $advisor->facebook) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" class="summernote">{{ old('description', $advisor->description) }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Quote</label>
                                                <textarea name="quote" class="summernote">{{ old('quote', $advisor->quote) }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Icon</label>
                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" onchange="showPreview1(event);"
                                                    name="image">

                                                @if ($advisor->image)
                                                    <div class="preview mt-2">
                                                        <img src="{{ asset('upload/images/advisor/' . $advisor->image) }}"
                                                            id="file-ip-1-preview" width="200px">
                                                    </div>
                                                @endif

                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- Bootstrap Switch -->
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Publish</h3>
                                                </div>
                                                <div class="card-body">
                                                    <input type="checkbox" name="status"
                                                        {{ old('status', $advisor->status) == 'on' ? 'checked' : '' }}
                                                        data-bootstrap-switch data-off-color="danger"
                                                        data-on-color="success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center mt-3">
                                        <button type="submit" class="btn btn-primary">Update <i
                                                class="bi bi-check"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
