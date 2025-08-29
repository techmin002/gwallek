@extends('setting::layouts.master')

@section('title', 'Edit Unit')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
        <li class="breadcrumb-item active">Edit Unit</li>
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
                                <h3 class="fw-bold">Edit Unit</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('units.update', $unit->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-3">

                                        <!-- Unit Name -->
                                        <div class="col-md-12">
                                            <label class="fw-semibold">Unit Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $unit->name }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" id="summernote">{{ $unit->description }}</textarea>
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
                                                        {{ $unit->status == 'on' ? 'checked' : '' }} data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer justify-content-start">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('units.index') }}" type="button"
                                            class="btn btn-danger btn-sm ms-2" data-dismiss="modal">Cancel</a>
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
