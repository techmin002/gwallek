<div class="modal fade" data-backdrop="static" id="editCustomerModal{{ $customer->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #fff;">
                <h4 class="modal-title fs-5" id="editCustomerModalLabel{{ $customer->id }}">Edit Customer</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('customers.update', $customer->id) }}" class="needs-validation" novalidate
                method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">

                        <div class="row bg-secondary mb-2">
                            <div class="col-md-12">
                                <h5>Customer Detail's</h5>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Customer Name --}}
                            <div class="col-lg-6">
                                <label class="form-label12" for="name">Customer Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $customer->name }}" required>
                                <div class="invalid-feedback">Please enter customer name!</div>
                            </div>

                            {{-- Phone --}}
                            <div class="col-lg-6">
                                <label class="form-label12" for="phone">Contact Number <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="phone" id="phone"
                                    value="{{ $customer->phone }}" minlength="10" maxlength="10" required>
                                <div class="invalid-feedback">Please enter valid contact number!</div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            {{-- Email --}}
                            <div class="col-lg-6">
                                <label class="form-label12" for="email">Email <small>(Optional)</small></label>
                                <input class="form-control" type="email" name="email" id="email"
                                    value="{{ $customer->email }}">
                            </div>

                            {{-- Address --}}
                            <div class="col-lg-6">
                                <label class="form-label12" for="address">Address <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="address" id="address"
                                    value="{{ $customer->address }}" required>
                                <div class="invalid-feedback">Please enter address!</div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label12" for="image">Customer Image
                                    <small>(Optional)</small></label>
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*">
                                @if ($customer->image)
                                    <img src="{{ asset('upload/images/customers/' . $customer->image) }}"
                                        alt="Customer Image" class="mt-2" width="100">
                                @endif
                                <div class="invalid-feedback">Please select a valid image file!</div>
                            </div>

                            <div class="col-lg-6">
                                @if (auth()->user()->access_type == 'Super Admin')
                                    <label for="branch_id">Select Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">-- Select Branch --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ $branch->id == $customer->branch_id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a branch!</div>
                                @else
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="card-body">
                                        {{-- <input type="checkbox" name="status" data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success"
                                            {{ $customer->status == 'on' ? 'checked' : '' }}> --}}
                                        <input type="checkbox" name="status"
                                            {{ $customer->status === 'on' ? 'checked' : '' }} data-bootstrap-switch
                                            data-on-color="success" data-off-color="danger">
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

<script>
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
