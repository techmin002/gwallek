@extends('setting::layouts.master')

@section('title', 'Site Images')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sites.index') }}">Site</a></li>
        <li class="breadcrumb-item active">Images</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Upload Images Card -->
        <div class="card mb-3">
            <div class="card-header bg-info">
                <h3 class="card-title">Add Site Images</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sites.images.store', $site->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="images">Select Images</label>
                        <input type="file" name="images[]" multiple class="form-control" required>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Publish</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="status" value="off">
                                    <input type="checkbox" name="status" value="on" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Upload Images</button>
                </form>
            </div>
        </div>

        <!-- Existing Site Images Table -->
        <div class="card">
            <div class="card-header bg-secondary">
                <h3 class="card-title">Site Images</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>S.N</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($site->images as $image)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('upload/sites/' . $image->image) }}" width="100"
                                        class="img-fluid">
                                </td>
                                <td>
                                    @if ($image->status == 'on')
                                        <a href="{{ route('siteimages.status', $image->id) }}"
                                            class="btn btn-success btn-sm">On</a>
                                    @else
                                        <a href="{{ route('siteimages.status', $image->id) }}"
                                            class="btn btn-danger btn-sm">Off</a>
                                    @endif

                                    <button class="btn btn-danger btn-sm"
                                        onclick="event.preventDefault(); if(confirm('Are you sure? It will delete the image permanently!')) {
            document.getElementById('destroy{{ $image->id }}').submit();
        }">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <form id="destroy{{ $image->id }}" class="d-none"
                                        action="{{ route('siteimages.destroy', $image->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger">No Images Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-left">
                <a href="{{ route('sites.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>



    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                toolbar: false,
                height: 100,
                disableResizeEditor: true
            });
        });
    </script>
@endsection
