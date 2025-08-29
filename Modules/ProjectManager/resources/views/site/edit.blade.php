<!-- Edit Site Modal -->
<div class="modal fade" id="editSiteModal{{ $site->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editSiteModalLabel{{ $site->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #fff;">
                <h4 class="modal-title fs-5">Edit Site</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('sites.update', $site->id) }}" class="needs-validation" novalidate method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="container">

                        <!-- Header -->
                        <div class="row bg-secondary mb-2">
                            <div class="col-md-12">
                                <h5>Site Details</h5>
                            </div>
                        </div>

                        <!-- Name & Amount -->
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name_{{ $site->id }}">Site Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name_{{ $site->id }}"
                                    value="{{ $site->name }}" required>
                                <div class="invalid-feedback">Please enter site name!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="amount_{{ $site->id }}">Amount <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount"
                                    id="amount_{{ $site->id }}" value="{{ $site->amount }}" required>
                                <div class="invalid-feedback">Please enter amount!</div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="start_date_{{ $site->id }}">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date"
                                    id="start_date_{{ $site->id }}"
                                    value="{{ $site->start_date ? \Carbon\Carbon::parse($site->start_date)->format('Y-m-d') : '' }}"
                                    required>
                                <div class="invalid-feedback">Please select start date!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="end_date_{{ $site->id }}">End Date</label>
                                <input type="date" class="form-control" name="end_date"
                                    id="end_date_{{ $site->id }}"
                                    value="{{ $site->end_date ? \Carbon\Carbon::parse($site->end_date)->format('Y-m-d') : '' }}">
                                <div class="invalid-feedback">Please select end date!</div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="image_{{ $site->id }}">Site Image <small>(Optional)</small></label>
                                <input type="file" class="form-control" name="image"
                                    id="image_{{ $site->id }}" accept="image/*">
                                @if ($site->image)
                                    <img src="{{ asset('upload/sites/' . $site->image) }}" class="img-thumbnail mt-2"
                                        width="100">
                                @endif
                            </div>

                            <div class="col-lg-6">
                                <label for="contract_image_{{ $site->id }}">Contract Paper <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="contract_image"
                                    id="contract_image_{{ $site->id }}" accept="image/*">
                                @if ($site->contract_image)
                                    <a href="{{ asset('upload/sites/' . $site->contract_image) }}" target="_blank"
                                        class="d-block mt-2">View Existing</a>
                                @endif
                            </div>
                        </div>

                        <!-- Branch / Staff / Customer -->
                        <div class="row mt-2">
                            @if (auth()->user()->access_type == 'Super Admin')
                                <div class="col-lg-6">
                                    <label for="branch_id_{{ $site->id }}">Select Branch <span
                                            class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id_{{ $site->id }}" class="form-control"
                                        required>
                                        <option value="">-- Select Branch --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ $site->branch_id == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a branch!</div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="assign_to_{{ $site->id }}">Assign To <span
                                            class="text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to_{{ $site->id }}" class="form-control"
                                        required>
                                        <option value="">-- Select Manager --</option>
                                        @foreach ($staff as $user)
                                            @if ($user->branch_id == $site->branch_id)
                                                <option value="{{ $user->id }}"
                                                    {{ $site->assign_to == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please assign to a user!</div>
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <label for="customer_id_{{ $site->id }}">Customer <span
                                            class="text-danger">*</span></label>
                                    <select name="customer_id" id="customer_id_{{ $site->id }}"
                                        class="form-control" required>
                                        <option value="">-- Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            @if ($customer->branch_id == $site->branch_id)
                                                <option value="{{ $customer->id }}"
                                                    {{ $site->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a customer!</div>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                <div class="col-lg-6">
                                    <label for="assign_to_{{ $site->id }}">Assign To <span
                                            class="text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to_{{ $site->id }}" class="form-control"
                                        required>
                                        <option value="">-- Select Manager --</option>
                                        @foreach ($staff as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $site->assign_to == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please assign to a user!</div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="customer_id_{{ $site->id }}">Customer <span
                                            class="text-danger">*</span></label>
                                    <select name="customer_id" id="customer_id_{{ $site->id }}"
                                        class="form-control" required>
                                        <option value="">-- Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $site->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a customer!</div>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="description_{{ $site->id }}">Description
                                    <small>(Optional)</small></label>
                                <textarea class="form-control" name="description" id="description_{{ $site->id }}" rows="3">{{ $site->description }}</textarea>
                            </div>
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
                                            {{ $site->status == 'on' ? 'checked' : '' }} data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-start d-flex">
                    <button type="submit" class="btn btn-primary w-25">Update</button>
                    <button type="reset" class="btn btn-danger w-25">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if (auth()->user()->access_type == 'Super Admin')
    <script>
        $(document).ready(function() {
            $('#branch_id_{{ $site->id }}').on('change', function() {
                let branchId = $(this).val();
                let assignTo = $('#assign_to_{{ $site->id }}');
                let customerId = $('#customer_id_{{ $site->id }}');

                if (branchId) {
                    assignTo.prop('disabled', false);
                    customerId.prop('disabled', false);

                    // Load Managers
                    $.ajax({
                        url: "{{ url('/branch') }}/" + branchId + "/managers",
                        type: "GET",
                        success: function(data) {
                            assignTo.empty().append(
                                '<option value="">-- Select Manager --</option>');
                            $.each(data, function(key, staff) {
                                assignTo.append('<option value="' + staff.id + '">' +
                                    staff.name + '</option>');
                            });
                        }
                    });

                    // Load Customers
                    $.ajax({
                        url: "{{ route('get.customers.by.branch') }}",
                        type: "GET",
                        data: {
                            branch_id: branchId
                        },
                        success: function(data) {
                            customerId.empty().append(
                                '<option value="">-- Select Customer --</option>');
                            $.each(data.customers, function(key, customer) {
                                customerId.append('<option value="' + customer.id +
                                    '">' + customer.name + '</option>');
                            });
                        }
                    });
                } else {
                    assignTo.prop('disabled', true).empty().append(
                        '<option value="">-- Select Manager --</option>');
                    customerId.prop('disabled', true).empty().append(
                        '<option value="">-- Select Customer --</option>');
                }
            });
        });
    </script>
@endif
