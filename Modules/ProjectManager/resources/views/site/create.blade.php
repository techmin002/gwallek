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

                            {{-- <div class="col-lg-6">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                    placeholder="Enter amount" required>
                                <div class="invalid-feedback">Please enter amount!</div>
                            </div> --}}
                            <div class="col-lg-6">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date">
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
                                <label for="contract_image">Contract Paper <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="contract_image" id="contract_image"
                                    accept="image/*" required>
                            </div>

                        </div>

                        <!-- Images -->
                        {{-- <div class="row mt-2">



                        </div> --}}

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
                            <div class="col-lg-6">
                                <label for="image">Site Image <small>(Optional)</small></label>
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/*">
                            </div>
                        </div>

                        <!-- Site Extra Details -->
                        <div class="row bg-secondary mt-3 mb-2">
                            <div class="col-md-12">
                                <h5>Additional Site Information</h5>
                            </div>
                        </div>

                        <!-- Location & Progress Status -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="location" id="location"
                                    placeholder="Enter site location" required>
                                <div class="invalid-feedback">Please enter location!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="progress_status">Progress Status <span
                                        class="text-danger">*</span></label>
                                <select name="progress_status" id="progress_status" class="form-control" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <div class="invalid-feedback">Please select progress status!</div>
                            </div>
                        </div>

                        <!-- Project Area & Contract ID -->
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label for="project_area">Project Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="project_area" id="project_area"
                                    placeholder="Enter project area" required>
                                <div class="invalid-feedback">Please enter project area!</div>
                            </div>

                            <div class="col-lg-6">
                                <label for="contract_id">Contract ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_id" id="contract_id"
                                    placeholder="Enter contract ID" required>
                                <div class="invalid-feedback">Please enter contract ID!</div>
                            </div>
                        </div>

                        <!-- Overview -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="overview">Overview <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="overview" id="overview" rows="3" placeholder="Enter overview" required></textarea>
                                <div class="invalid-feedback">Please enter overview!</div>
                            </div>
                        </div>

                        <!-- Key Features -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="key_features">Key Features</label>
                                <textarea class="form-control" name="key_features" id="key_features" rows="3"
                                    placeholder="Enter key features"></textarea>
                            </div>
                        </div>

                        <!-- Technical Specifications -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="technical_specifications">Technical Specifications</label>
                                <textarea class="form-control" name="technical_specifications" id="technical_specifications" rows="3"
                                    placeholder="Enter technical specifications"></textarea>
                            </div>
                        </div>

                        <!-- Environmental Impact -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="environmental_impact">Environmental Impact</label>
                                <textarea class="form-control" name="environmental_impact" id="environmental_impact" rows="3"
                                    placeholder="Enter environmental impact"></textarea>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="description">Description <small>(Optional)</small></label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"></textarea>
                            </div>
                        </div>

                        {{-- Payment Field --}}
                        @include("projectmanager::site.payment")
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
<script>
    $(document).ready(function() {
        // Summernote init
        $('#overview, #key_features, #technical_specifications, #environmental_impact, #description')
            .summernote({
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
                fontNamesIgnoreCheck: ['Merriweather', 'Roboto', 'Trirong'],
            });

        // Fix: summernote content sync before submit
        $('form').on('submit', function() {
            $('#overview').val($('#overview').summernote('code'));
            $('#key_features').val($('#key_features').summernote('code'));
            $('#technical_specifications').val($('#technical_specifications').summernote('code'));
            $('#environmental_impact').val($('#environmental_impact').summernote('code'));
            $('#description').val($('#description').summernote('code'));
        });
    });
</script>

<script>
    $(document).ready(function() {
        function togglePaymentFields() {
            var method = $('#payment_method').val();
            if (method === 'check') {
                $('#check_number_div').show();
            } else if (method === 'online') {
                $('#check_number_div').hide();
            } else {
                $('#check_number_div').hide();
            }
        }

        $('#payment_method').change(togglePaymentFields);
        togglePaymentFields(); // Initialize on page load
    });
</script>
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
