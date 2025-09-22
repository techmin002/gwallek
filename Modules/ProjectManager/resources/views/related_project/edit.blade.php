@extends('setting::layouts.master')

@section('title', 'Edit Related Project')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Edit Related Project</h1>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('relatedproject.update', $project->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Project Name -->
                            <div class="form-group">
                                <label for="name">Project Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $project->name }}" required>
                                <div class="invalid-feedback">Please enter project name!</div>
                            </div>

                            <!-- Image -->
                            <div class="form-group">
                                <label for="image">Project Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                                @if ($project->image)
                                    <img src="{{ asset('upload/site/related_projects/' . $project->image) }}" width="100"
                                        class="mt-2">
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="summernote" rows="4">{{ $project->description }}</textarea>
                            </div>
                            <!-- Publish Status -->
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Publish</h3>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="status" value="off">
                                            <input type="checkbox" name="status" value="on"
                                                {{ $project->status == 'on' ? 'checked' : '' }} data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('relatedproject.index', $project->site_id) }}"
                                class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Summernote init
                $('#description').summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });

                // Sync before submit
                $('form').on('submit', function() {
                    $('#description').val($('#description').summernote('code'));
                });

                // Bootstrap validation
                (function() {
                    'use strict';
                    var forms = document.getElementsByClassName('needs-validation');
                    Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                })();
            });
        </script>
    @endpush
