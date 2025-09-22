@extends('setting::layouts.master')

@section('title', 'Site Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('managers.index') }}">Project Manager</a></li>
        <li class="breadcrumb-item active">Site Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Site: {{ $site->name ?? '-' }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Site Info Card -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Site Information</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Customer:</strong> {{ $site->customer ? $site->customer->name : '---' }}</p>
                        <p><strong>Amount:</strong> {{ $site->amount ? number_format($site->amount, 2) : '---' }}</p>
                        <p><strong>Start Date:</strong>
                            {{ $site->start_date ? \Carbon\Carbon::parse($site->start_date)->format('d-m-Y') : '---' }}</p>
                        <p><strong>End Date:</strong>
                            {{ $site->end_date ? \Carbon\Carbon::parse($site->end_date)->format('d-m-Y') : '--' }}</p>
                        @if (auth()->user()->access_type == 'Super Admin')
                            <p><strong>Branch:</strong> {{ $site->branch ? $site->branch->name : '---' }}</p>
                        @endif
                    </div>
                </div>

                <!-- Assigned Staff Table -->
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Assigned Staff</h3>
                    </div>
                    <div class="card-body">
                        @if ($site->assignments && $site->assignments->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th>S.R</th>
                                        <th>Staff Name</th>
                                        <th>Assign Date</th>
                                        @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($site->assignments as $assignment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $assignment->staff ? $assignment->staff->name : '-' }}</td>
                                            <td>{{ $assignment->created_at ? \Carbon\Carbon::parse($assignment->created_at)->format('d-m-Y') : '-' }}
                                            </td>
                                            @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                                <td>
                                                    <form action="{{ route('assignments.removeStaff', $assignment->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to remove this staff?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-danger">No Staff Assign</p>
                        @endif
                    </div>
                </div>

                <!-- Construction Image Card -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Construction Image</h3>
                    </div>
                    <div class="card-body text-center">
                        @if (!empty($site->image))
                            <img src="{{ asset('upload/sites/' . $site->image) }}" alt="Construction Image"
                                class="img-fluid">
                        @else
                            <p class="text-danger">No Image</p>
                        @endif
                    </div>
                </div>

                <!-- Contract Image Card -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Contract Image</h3>
                    </div>
                    <div class="card-body text-center">
                        @if (!empty($site->contract_image))
                            <img src="{{ asset('upload/sites/contracts/' . $site->contract_image) }}" alt="Contract Image"
                                class="img-fluid">
                        @else
                            <p class="text-danger">No Image</p>
                        @endif
                    </div>
                </div>
                <!-- Site Details Card -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Site Details</h3>
                    </div>
                    <div class="card-body">
                        <!-- Description -->
                        <div class="mb-3">
                            <label><strong>Description:</strong></label>
                            <textarea class="form-control summernote" readonly>{!! $site->description ?? '-' !!}</textarea>
                        </div>

                        <!-- Overview -->
                        <div class="mb-3">
                            <label><strong>Overview:</strong></label>
                            <textarea class="form-control summernote" readonly>{!! $site->overview ?? '-' !!}</textarea>
                        </div>

                        <!-- Key Features -->
                        <div class="mb-3">
                            <label><strong>Key Features:</strong></label>
                            <textarea class="form-control summernote" readonly>{!! $site->key_features ?? '-' !!}</textarea>
                        </div>

                        <!-- Technical Specifications -->
                        <div class="mb-3">
                            <label><strong>Technical Specifications:</strong></label>
                            <textarea class="form-control summernote" readonly>{!! $site->technical_specifications ?? '-' !!}</textarea>
                        </div>

                        <!-- Environmental Impact -->
                        <div class="mb-3">
                            <label><strong>Environmental Impact:</strong></label>
                            <textarea class="form-control summernote" readonly>{!! $site->environmental_impact ?? '-' !!}</textarea>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
    <a href="{{ route('sites.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('.summernote').each(function() {
                $(this).summernote({
                    toolbar: false,
                    airMode: false,
                    disableResizeEditor: true,
                    height: 150
                });
                $(this).summernote('disable');
            });
        });
    </script>
@endsection
