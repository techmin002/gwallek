@extends('setting::layouts.master')

@section('title', 'Edit Stock Transfer')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0 bg-light rounded shadow-sm px-3 py-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('stock-transfers.index') }}">Stock Transfer</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper bg-white rounded shadow-sm p-3">
        <section class="content-header mb-3">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="font-weight-bold text-primary">
                            <i class="bi bi-truck me-2"></i>Edit Stock Transfer
                        </h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('stock-transfers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Error & Success Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <h5><i class="icon fas fa-ban"></i> Validation Errors!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                {{ session('error') }}
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('stock-transfers.update', $stockTransfer->id) }}" method="POST" id="stockTransferForm">
            @csrf
            @method('PUT')

            {{-- Transfer Information --}}
            <div class="transfer-details-card p-4 mb-4 shadow-sm rounded border">
                <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                    <i class="bi bi-card-checklist me-2"></i>Transfer Information
                </h3>
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">From Branch</label>
                        @if (auth()->user()->access_type === 'Super Admin')
                            <select class="form-control border-primary shadow-sm" id="fromBranch" name="from_branch_id"
                                required>
                                <option value="" disabled>Select Source Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ $stockTransfer->from_branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="from_branch_id" value="{{ auth()->user()->branch_id }}">
                            <input type="text" class="form-control border-primary shadow-sm"
                                value="{{ optional(auth()->user()->branch)->name }}" readonly>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">To Branch</label>
                        <select class="form-control border-primary shadow-sm" id="toBranch" name="to_branch_id" required>
                            <option value="" disabled>Select Destination Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ $stockTransfer->to_branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">Transfer Date</label>
                        <input type="date" class="form-control border-primary shadow-sm" name="transfer_date"
                            value="{{ $stockTransfer->transfer_date }}" required>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control border-primary shadow-sm" rows="2">{{ $stockTransfer->remarks }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Product Transfer --}}
            <div class="product-transfer-card p-4 shadow-sm rounded border">
                <h3 class="mb-3 text-success border-bottom pb-2 section-title">
                    <i class="bi bi-box-seam me-2"></i>Product Transfer
                </h3>
                <div id="productContainer">
                    @foreach ($stockTransfer->products as $index => $product)
                        <div class="row gy-3 product-row" id="product-row-{{ $index }}">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">Product</label>
                                <select class="form-control border-success shadow-sm"
                                    name="products[{{ $index }}][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $p->id == $product->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control border-success shadow-sm"
                                    name="products[{{ $index }}][quantity]" value="{{ $product->pivot->quantity }}"
                                    min="1" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">Serial Numbers</label>
                                <input type="text" class="form-control border-success shadow-sm"
                                    name="products[{{ $index }}][serial_numbers]"
                                    value="{{ $product->pivot->serial_numbers }}">
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">Condition</label>
                                <select class="form-control border-success shadow-sm"
                                    name="products[{{ $index }}][condition]" required>
                                    <option value="new" {{ $product->pivot->condition == 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="used" {{ $product->pivot->condition == 'used' ? 'selected' : '' }}>
                                        Used</option>
                                    <option value="refurbished"
                                        {{ $product->pivot->condition == 'refurbished' ? 'selected' : '' }}>Refurbished
                                    </option>
                                    <option value="damaged"
                                        {{ $product->pivot->condition == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                            </div>
                            <div class="col-lg-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger remove-item"
                                    data-row="product-row-{{ $index }}">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addProduct" class="btn btn-success mt-3">
                    <i class="bi bi-plus-circle"></i> Add Product
                </button>
                <div id="productError" class="text-danger mt-2 d-none">At least one product is required</div>
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                    <i class="bi bi-check-circle me-2"></i>Update Transfer
                </button>
                <a href="{{ route('stock-transfers.index') }}" class="btn btn-outline-secondary px-5 py-2 fw-bold">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            let productIndex = {{ $stockTransfer->products->count() }};

            // ✅ Disable same branch in To Branch
            function disableSameBranch() {
                const fromBranch = $('#fromBranch').val();
                $('#toBranch option').prop('disabled', false);
                if (fromBranch) {
                    $('#toBranch option[value="' + fromBranch + '"]').prop('disabled', true);
                    if ($('#toBranch').val() === fromBranch) {
                        $('#toBranch').val('');
                    }
                }
            }
            $('#fromBranch').on('change', disableSameBranch);
            disableSameBranch();

            // ✅ Add Product Row
            $('#addProduct').on('click', function() {
                productIndex++;
                const row = `
            <div class="row gy-3 product-row" id="product-row-${productIndex}">
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Product</label>
                    <select class="form-control border-success shadow-sm" name="products[${productIndex}][product_id]" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a product</div>
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Quantity</label>
                    <input class="form-control border-success shadow-sm"
                           name="products[${productIndex}][quantity]"
                           type="number"
                           value="1"
                           min="1"
                           required>
                    <div class="invalid-feedback">Enter quantity</div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Serial Numbers</label>
                    <input class="form-control border-success shadow-sm"
                           name="products[${productIndex}][serial_numbers]"
                           type="text"
                           placeholder="Optional serial numbers">
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Condition</label>
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

            // ✅ Validate at least one product
            function validateProductCount() {
                if ($('.product-row').length === 0) {
                    $('#productError').removeClass('d-none');
                } else {
                    $('#productError').addClass('d-none');
                }
            }

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
        });
    </script>

@endsection
