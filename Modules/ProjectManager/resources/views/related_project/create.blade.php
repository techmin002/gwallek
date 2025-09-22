@extends('setting::layouts.master')

@section('title', 'Create Related Project')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('relatedproject.index', $site->id) }}">Related Project</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create Related Project</h4>
                    </div>
                    <form action="{{ route('relatedproject.store', $site->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">

                            <!-- Project Name -->
                            <div class="form-group">
                                <label for="name">Project Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter project name" required>
                                <div class="invalid-feedback">Please enter project name!</div>
                            </div>

                            <!-- Image -->
                            <div class="form-group">
                                <label for="image">Project Image <small>(Optional)</small></label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description <small>(Optional)</small></label>
                                <textarea class="form-control" name="description" id="summernote" rows="5"
                                    placeholder="Enter project description"></textarea>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Publish</h3>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="status" value="off">
                                            <input type="checkbox" name="status" value="on" checked
                                                data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-start">
                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                            <a href="{{ route('relatedproject.index', $site->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
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
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather',
                    'Roboto', 'Trirong'
                ],
                fontNamesIgnoreCheck: ['Merriweather', 'Roboto', 'Trirong']
            });

            $('form').on('submit', function() {
                $('#description').val($('#description').summernote('code'));
            });
        });

        // Bootstrap validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
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
            }, false);
        })();
    </script>
@endpush
