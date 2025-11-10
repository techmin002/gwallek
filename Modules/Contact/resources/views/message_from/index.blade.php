@extends('setting::layouts.master')

@section('title', 'Message From')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        {{-- <li class="breadcrumb-item"><a href="{{ route('message-from.index') }}">Message From</a></li> --}}
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Message From</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Message From</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('messagesfrom.update',$messages->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title"><i class="fas fa-edit"></i> Message Details</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name"><i class="fas fa-user"></i> Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $messages->name) }}" placeholder="Enter name" required>
                                    </div>

                                    <!-- Role -->
                                    <div class="form-group">
                                        <label for="role"><i class="fas fa-briefcase"></i> Role</label>
                                        <input type="text" name="role" class="form-control" id="role"
                                            value="{{ old('role', $messages->role) }}"
                                            placeholder="e.g. Managing Director" required>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description"><i class="fas fa-align-left"></i> Description</label>
                                        <textarea name="description" class="form-control" id="summernote" rows="6"
                                            placeholder="Write the message here...">{{ old('description', $messages->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Image -->
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-secondary text-white">
                                    <h3 class="card-title"><i class="fas fa-image"></i> Profile Image</h3>
                                </div>
                                <div class="card-body text-center">
                                    <input type="file" name="image" class="form-control-file" accept="image/*"
                                        onchange="previewImage(event, 'imagePreview')">
                                    <div class="mt-3">
                                        @if ($messages->image)
                                            <img src="{{ asset('upload/images/message_from/' . $messages->image) }}"
                                                alt="Current Image" id="imagePreview"
                                                class="img-thumbnail rounded shadow-sm" style="max-width: 200px;">
                                        @else
                                            <img id="imagePreview" class="img-thumbnail d-none" style="max-width: 200px;">
                                        @endif
                                    </div>
                                    @error('image')
                                        <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Signature -->
                            <div class="card shadow-sm border-0 mt-3">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title"><i class="fas fa-pen-fancy"></i> Signature</h3>
                                </div>
                                <div class="card-body text-center">
                                    <input type="file" name="signature" class="form-control-file" accept="image/*"
                                        onchange="previewImage(event, 'signaturePreview')">
                                    <div class="mt-3">
                                        @if ($messages->signature)
                                            <img src="{{ asset('upload/images/message_from/' . $messages->signature) }}"
                                                alt="Current Signature" id="signaturePreview"
                                                class="img-thumbnail rounded shadow-sm" style="max-width: 200px;">
                                        @else
                                            <img id="signaturePreview" class="img-thumbnail d-none"
                                                style="max-width: 200px;">
                                        @endif
                                    </div>
                                    @error('signature')
                                        <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                        {{-- <a href="{{ route('message-from.index') }}" class="btn btn-secondary"><i
                                class="fas fa-times"></i> Cancel</a> --}}
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
                output.classList.remove("d-none");
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
