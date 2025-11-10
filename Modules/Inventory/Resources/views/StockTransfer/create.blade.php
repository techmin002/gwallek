<div class="modal fade" id="createStockTransfer" tabindex="-1" role="dialog" aria-labelledby="createStockTransferTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1100px;">
        <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center modal-header-advanced">
                <h1 class="modal-title fs-3 fw-bold text-info" id="staticBackdropLabel">
                    <i class="bi bi-truck me-2"></i>
                    Create Stock Transfer
                </h1>
            </div>
            <form action="{{ route('stock-transfers.store') }}" method="post" class="needs-validation" novalidate
                id="stockTransferForm">
                @csrf
                <div class="modal-body modal-body-advanced">

                    {{-- Transfer Information --}}
                    <div class="transfer-details-card p-4 mb-4">
                        <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                            <i class="bi bi-card-checklist me-2"></i>
                            Transfer Information
                        </h3>
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">From Branch</label>

                                 @if (auth()->user()->access_type == 'Super Admin')
                                    <!-- ✅ Super Admin: Dropdown -->
                                    <select class="form-control border-primary shadow-sm" id="fromBranch"
                                        name="from_branch_id" required>
                                        <option value="" selected disabled>Select Source Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <!-- ✅ Normal User: Readonly (not editable) -->
                                    <input type="hidden" id="fromBranch" name="from_branch_id"
                                        value="{{ auth()->user()->branch_id }}">
                                    <input type="text" class="form-control border-primary shadow-sm"
                                        value="{{ optional(auth()->user()->branch)->name }}" readonly>
                                @endif
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">To Branch</label>
                                <select class="form-control border-primary shadow-sm" id="toBranch" name="to_branch_id"
                                    required>
                                    <option value="" selected disabled>Select Destination Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Transfer Date</label>
                                <input type="date" class="form-control border-primary shadow-sm" name="transfer_date"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12 fw-semibold">Remarks</label>
                                <textarea name="remarks" class="form-control border-primary shadow-sm" rows="2" placeholder="Transfer remarks"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Product Transfer --}}
                    <div class="product-transfer-card p-4">
                        <h3 class="mb-3 text-success border-bottom pb-2 section-title">
                            <i class="bi bi-box-seam me-2"></i>
                            Product Transfer
                        </h3>
                        <div id="productContainer"></div>
                        <button type="button" id="addProduct" class="btn btn-success mt-3">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>
                        <div id="productError" class="text-danger mt-2 d-none">At least one product is required</div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start modal-footer-advanced">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" id="submitBtn">
                        <i class="bi bi-check-circle me-2"></i>Create Transfer
                    </button>
                    <button type="button" data-dismiss="modal"
                        class="btn btn-outline-secondary px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let productIndex = 0;

        // ✅ Disable same branch in To Branch
        function disableSameBranch() {
            const fromBranch = $('#fromBranch').val();
            $('#toBranch option').prop('disabled', false); // enable all first
            if (fromBranch) {
                $('#toBranch option[value="' + fromBranch + '"]').prop('disabled', true);
                // If currently selected toBranch == fromBranch => reset
                if ($('#toBranch').val() === fromBranch) {
                    $('#toBranch').val('');
                }
            }
        }

        // Super Admin -> On From change
        $('#fromBranch').on('change', disableSameBranch);

        // Normal User -> Fixed from branch, disable on load
        disableSameBranch();

        // ✅ Add Product Row
        $('#addProduct').on('click', function() {
            productIndex++;
            const row = `
            <div class="row gy-3 item-row product-row" id="product-row-${productIndex}">
                <div class="col-lg-4">
                    <label class="form-label12 fw-semibold">Product</label>
                    <select class="form-control border-success shadow-sm" name="products[${productIndex}][product_id]" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a product</div>
                </div>
                <div class="col-lg-2">
                    <label class="form-label12 fw-semibold">Quantity</label>
                    <input class="form-control border-success shadow-sm"
                           name="products[${productIndex}][quantity]"
                           type="number"
                           value="1"
                           min="1"
                           required>
                    <div class="invalid-feedback">Enter quantity</div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label12 fw-semibold">Serial Numbers</label>
                    <input class="form-control border-success shadow-sm"
                           name="products[${productIndex}][serial_numbers]"
                           type="text"
                           placeholder="Optional serial numbers">
                </div>
                <div class="col-lg-2">
                    <label class="form-label12 fw-semibold">Condition</label>
                    <select class="form-control border-success shadow-sm" name="products[${productIndex}][condition]" required>
                        <option value="new">New</option>
                        <option value="used">Used</option>
                        <option value="refurbished">Refurbished</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
                <div class="col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item" data-row="product-row-${productIndex}">
                         Remove
                    </button>
                </div>
            </div>`;
            $('#productContainer').append(row);
            $('#productError').addClass('d-none');
        });

        // ✅ Remove Row
        $(document).on('click', '.remove-item', function() {
            const rowId = $(this).data('row');
            $(`#${rowId}`).remove();
            validateProductCount();
        });

        // ✅ Form submit validation
        $('#stockTransferForm').on('submit', function(e) {
            const fromBranch = $('#fromBranch').val();
            const toBranch = $('#toBranch').val();

            if (fromBranch && toBranch && fromBranch === toBranch) {
                e.preventDefault();
                alert("You cannot transfer stock to the same branch!");
                return false;
            }

            if ($('.product-row').length === 0) {
                e.preventDefault();
                $('#productError').removeClass('d-none');
            }
        });

        function validateProductCount() {
            if ($('.product-row').length === 0) {
                $('#productError').removeClass('d-none');
            } else {
                $('#productError').addClass('d-none');
            }
        }

        // ✅ First product row by default
        $('#addProduct').trigger('click');
    });
</script>
