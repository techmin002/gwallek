@extends('setting::layouts.master')

@section('title', 'Manager Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('managers.index') }}">Project Manager</a></li>
        <li class="breadcrumb-item active">Manager Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manager: {{ $manager->name }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Manager Info Card -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Manager Information</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $manager->name }}</p>
                        <p><strong>Email:</strong> {{ $manager->email ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $manager->phone ?? '-' }}</p>
                        @if (auth()->user()->access_type == 'Super Admin')
                            <p><strong>Branch:</strong> {{ $manager->branch ? $manager->branch->name : '-' }}</p>
                        @endif
                    </div>
                </div>

                <!-- Sites Table -->
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Assigned Sites</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>S.R</th>
                                    <th>Site Name</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    @if (auth()->user()->access_type == 'Super Admin')
                                        <th>Branch</th>
                                    @endif
                                    <th>Details</th>
                                    @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sites as $site)
                                    @php
                                        $ids = Modules\ProjectManager\Models\ProjectAssignment::where(
                                            'site_id',
                                            $site['id'],
                                        )->pluck('staff_id');
                                        $staffs = App\Models\User::where('branch_id', $site['branch_id'])
                                            ->whereNotIn('id', $ids)
                                            ->where('access_type', 'Staff')
                                            ->get();

                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $site->name }}</td>
                                        <td class="text-center">{{ $site->customer ? $site->customer->name : '-' }}</td>
                                        <td class="text-center">{{ number_format($site->amount, 2) }}</td>
                                        <td class="text-center">
                                            {{ $site->start_date ? \Carbon\Carbon::parse($site->start_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            @if ($site->end_date)
                                                {{ \Carbon\Carbon::parse($site->end_date)->format('d-m-Y') }}
                                            @else
                                                <span class="text-danger">NA</span>
                                            @endif
                                        </td>
                                        @if (auth()->user()->access_type == 'Super Admin')
                                            <td class="text-center">{{ $site->branch ? $site->branch->name : '-' }}</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{ route('sites.details', $site->id) }}" class="btn btn-info btn-sm">
                                                View Details
                                            </a>
                                        </td>
                                        @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                            <td>
                                                <button class="btn btn-primary btn-sm assign-staff-btn" data-toggle="modal"
                                                    data-target="#assignStaffModal{{ $site->id }}"
                                                    data-site-id="{{ $site->id }}">
                                                    Assign Staff
                                                </button>

                                                <div class="modal fade" id="assignStaffModal{{ $site->id }}"
                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <form action="{{ route('sites.assignStaff', $site->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="site_id"
                                                                value="{{ $site->id }}">
                                                            <input type="hidden" name="branch_id"
                                                                value="{{ $manager->branch_id }}">
                                                            <input type="hidden" name="manager_id"
                                                                value="{{ $manager->id }}">

                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h5 class="modal-title">Assign Staff</h5>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="form-group">
                                                                        <label for="staff_ids_{{ $site->id }}">Select
                                                                            Staff</label>
                                                                        <select name="staff_ids[]"
                                                                            id="staff_ids_{{ $site->id }}"
                                                                            class="form-control" multiple required>
                                                                            @foreach ($staffs as $staff)
                                                                                <option value="{{ $staff->id }}"
                                                                                    {{ $site->assignments->pluck('staff_id')->contains($staff->id) ? 'selected' : '' }}>
                                                                                    {{ $staff->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="assign_date_{{ $site->id }}">Assign
                                                                            Date</label>
                                                                        <input type="date" name="assign_date"
                                                                            id="assign_date_{{ $site->id }}"
                                                                            class="form-control"
                                                                            value="{{ $site->assignments->first() ? $site->assignments->first()->assign_date : now()->format('Y-m-d') }}"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-success">Assign</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th>S.R</th>
                                    <th>Site Name</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    @if (auth()->user()->access_type == 'Super Admin')
                                        <th>Branch</th>
                                    @endif
                                    <th>Details</th>
                                    @if (auth()->user()->access_type == 'Super Admin' || auth()->user()->access_type == 'Admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @foreach ($sites as $site)
                $('#staff_ids_{{ $site->id }}').select2({
                    dropdownParent: $('#assignStaffModal{{ $site->id }}'),
                    placeholder: "Select Staff",
                    allowClear: true
                });
            @endforeach
        });
    </script>
@endpush
