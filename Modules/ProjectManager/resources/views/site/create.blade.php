<!-- Create Site Modal -->
<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #fff;">
                <h4 class="modal-title fs-5">Create Site</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('sites.store') }}" class="needs-validation" novalidate method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">

                        <!-- Site Details Header -->
                        <div class="row bg-secondary mb-2">
                            <div class="col-md-12">
                                <h5>Site Details</h5>
                            </div>
                        </div>

                        <!-- Site Name & Amount -->
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Site Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter site name" required>
                                <div class="invalid-feedback">Please enter site name!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                    placeholder="Enter amount" required>
                                <div class="invalid-feedback">Please enter amount!</div>
                            </div>
                        </div>

                        <!-- Start Date & End Date -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                                <div class="invalid-feedback">Please select start date!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date">
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="image">Site Image <small>(Optional)</small></label>
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/*">
                            </div>

                            <div class="col-lg-6">
                                <label for="contract_image">Contract Paper <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="contract_image" id="contract_image"
                                    accept="image/*" required>
                            </div>
                        </div>

                        <!-- Branch, Staff & Customer -->
                        <div class="row mt-2">
                            @if (auth()->user()->access_type == 'Super Admin')
                                <!-- Branch Select -->
                                <div class="col-lg-6">
                                    <label for="branch_id">Select Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">-- Select Branch --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a branch!</div>
                                </div>

                                <!-- Staff Select -->
                                <div class="col-lg-6">
                                    <label for="assign_to">Assign To <span class="text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to" class="form-control" required disabled>
                                        <option value="">-- Select Manager --</option>
                                    </select>
                                    <div class="invalid-feedback">Please assign to manager!</div>
                                </div>

                                <!-- Customer Select -->
                                <div class="col-lg-6 mt-2">
                                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" id="customer_id" class="form-control" required disabled>
                                        <option value="">-- Select Customer --</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a customer!</div>
                                </div>
                            @else
                                <!-- Normal User: branch hidden -->
                                <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                <!-- Staff Select -->
                                <div class="col-lg-6">
                                    <label for="assign_to">Assign To <span class="text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to" class="form-control" required>
                                        <option value="">-- Select Manager --</option>
                                        @foreach ($staff as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please assign to a user!</div>
                                </div>

                                <!-- Customer Select -->
                                <div class="col-lg-6">
                                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                        <option value="">-- Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a customer!</div>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="description">Description <small>(Optional)</small></label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"></textarea>
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
                                        <input type="checkbox" name="status" value="on" checked
                                            data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-start d-flex">
                    <button type="submit" class="btn btn-primary w-25">Save</button>
                    <button type="reset" class="btn btn-danger w-25">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap validation -->
<script>
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

@if (auth()->user()->access_type == 'Super Admin')
    <script>
        $(document).ready(function() {
            $('#branch_id').on('change', function() {
                let branchId = $(this).val();

                if (branchId) {
                    $('#assign_to, #customer_id').prop('disabled', false);

                    // Load Managers for selected branch
                    $.ajax({
                        url: "{{ url('/branch') }}/" + branchId + "/managers",
                        type: "GET",
                        success: function(data) {
                            $('#assign_to').empty().append(
                                '<option value="">-- Select Staff --</option>');
                            $.each(data, function(key, staff) {
                                $('#assign_to').append('<option value="' + staff.id +
                                    '">' + staff.name + '</option>');
                            });
                        }
                    });

                    // Load Customers for selected branch
                    $.ajax({
                        url: "{{ route('get.customers.by.branch') }}",
                        type: "GET",
                        data: {
                            branch_id: branchId
                        },
                        success: function(data) {
                            $('#customer_id').empty().append(
                                '<option value="">-- Select Customer --</option>');
                            $.each(data.customers, function(key, customer) {
                                $('#customer_id').append('<option value="' + customer
                                    .id + '">' + customer.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#assign_to, #customer_id').prop('disabled', true)
                        .empty().append('<option value="">-- Select --</option>');
                }
            });
        });
    </script>
@endif
