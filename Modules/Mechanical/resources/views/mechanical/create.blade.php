<div class="modal fade" id="createMechanicalModal" tabindex="-1" role="dialog" aria-labelledby="createMechanicalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow-xl border-0" style="border-radius: 22px; overflow: hidden;">

            <!-- Header -->
            <div class="modal-header justify-content-center text-white"
                style="background: linear-gradient(90deg, #0077b6, #00b4d8); border-bottom: 4px solid #90e0ef;">
                <h3 class="modal-title fw-bold">
                    <i class="fas fa-tools me-2"></i> Create Mechanical
                </h3>
            </div>

            <form action="{{ route('mechanicals.items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 bg-light">

                    <!-- General Info -->
                    <div class="card shadow mb-4 border-0" style="border-left: 6px solid #0077b6;">
                        <div class="card-header text-white"
                            style="background: linear-gradient(90deg, #0077b6, #0096c7);">
                            <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i> General Information</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Name</label>
                                <input type="text" name="name" class="form-control shadow-sm"
                                    placeholder="Enter name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Category</label>
                                <select name="category_id" class="form-control shadow-sm" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Branch</label>
                                @if (auth()->user()->access_type == 'Super Admin')
                                    <select name="branch_id" class="form-control shadow-sm" required>
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                    <input type="text" class="form-control shadow-sm"
                                        value="{{ auth()->user()->branch->name }}" readonly>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="fw-semibold">Image</label>
                                <input type="file" name="image" class="form-control shadow-sm" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Info -->
                    <div class="card shadow mb-4 border-0" style="border-left: 6px solid #00b4d8;">
                        <div class="card-header text-white"
                            style="background: linear-gradient(90deg, #00b4d8, #48cae4);">
                            <h5 class="fw-bold mb-0"><i class="fas fa-shopping-cart me-2"></i> Purchase Information</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Amount</label>
                                <input type="number" name="amount" step="0.01" class="form-control shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Insurance Info -->
                    <div class="card shadow mb-4 border-0" style="border-left: 6px solid #0096c7;">
                        <div class="card-header text-white"
                            style="background: linear-gradient(90deg, #0096c7, #00b4d8);">
                            <h5 class="fw-bold mb-0"><i class="fas fa-file-contract me-2"></i> Insurance Information</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Insurance Date</label>
                                <input type="date" name="insurance_date" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Insurance Document</label>
                                <input type="file" name="insurance_document" class="form-control shadow-sm"
                                    accept="application/pdf,image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Info -->
                    <div class="card shadow mb-4 border-0" style="border-left: 6px solid #023e8a;">
                        <div class="card-header text-white"
                            style="background: linear-gradient(90deg, #0096c7, #00b4d8);">
                            <h5 class="fw-bold mb-0"><i class="fas fa-car me-2"></i> Vehicle Information</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-4">
                                <label class="fw-semibold">Engine Number</label>
                                <input type="text" name="engine_number" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold">Chassis Number</label>
                                <input type="text" name="chasis_number" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold">Vehicle Number</label>
                                <input type="text" name="vehicle_number" class="form-control shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Service Info -->
                    <div class="card shadow mb-4 border-0" style="border-left: 6px solid #03045e;">
                        <div class="card-header text-white"
                            style="background: linear-gradient(90deg, #0096c7, #00b4d8);">
                            <h5 class="fw-bold mb-0"><i class="fas fa-wrench me-2"></i> Service Information</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Service Date</label>
                                <input type="date" name="service_date" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Description</label>
                                <textarea name="description" class="summernote form-control shadow-sm" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mt-3">
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

                <!-- Footer -->
                <div class="modal-footer float-left bg-light">
                    <button type="button" class="btn btn-outline-danger px-4" data-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i> Save Mechanical
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
