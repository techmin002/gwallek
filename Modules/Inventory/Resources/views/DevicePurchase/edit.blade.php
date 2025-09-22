@extends('setting::layouts.master')

@section('title', 'Edit Device Purchase')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Device Purchases Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Device Purchase</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Device Purchases</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-lg modal-advanced">
                    <div class="modal-header justify-content-center modal-header-advanced">
                        <h1 class="modal-title fs-3 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Device Purchase
                        </h1>
                    </div>

                    <form action="{{ route('device_purchases_update', $devicePurchase->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-body modal-body-advanced">
                            <!-- Device Purchase Section -->
                            <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                                <i class="bi bi-phone me-2"></i> Device Purchase
                            </h3>

                            <div class="container-fluid">
                                <div class="row gy-3">
                                    <!-- Supplier -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Supplier</label>
                                        <select class="form-control border-primary shadow-sm" name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $supplier->id == $devicePurchase->supplier_id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Branch -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Branch</label>
                                        <select class="form-control border-primary shadow-sm" name="branch_id">
                                            <option value="">Select Branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $branch->id == $devicePurchase->branch_id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Bill No -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Bill No.</label>
                                        <input type="text" class="form-control border-primary shadow-sm" name="bill_no"
                                            value="{{ $devicePurchase->bill_no }}">
                                    </div>

                                    <!-- Total Amount -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Total Amount</label>
                                        <input type="number" class="form-control border-primary shadow-sm"
                                            name="total_amount" id="total_amount" step="0.01"
                                            value="{{ $devicePurchase->total_amount }}">
                                    </div>

                                    <!-- Receipt -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Receipt</label>
                                        <input type="file" class="form-control border-primary shadow-sm" name="receipt"
                                            accept=".jpg,.jpeg,.png,.pdf">
                                        @if ($devicePurchase->receipt)
                                            <a href="{{ asset($devicePurchase->receipt) }}" target="_blank"
                                                class="d-block mt-2 text-primary">View Existing</a>
                                        @endif
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-4">
                                        <label class="form-label12 fw-semibold">Status</label>
                                        <select class="form-control border-primary shadow-sm" name="status">
                                            <option value="0" {{ $devicePurchase->status == 0 ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="1" {{ $devicePurchase->status == 1 ? 'selected' : '' }}>
                                                Completed</option>
                                        </select>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-lg-12">
                                        <label class="form-label12 fw-semibold">Description</label>
                                        <textarea class="form-control border-primary shadow-sm" name="description" rows="3">{{ $devicePurchase->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Purchase Section -->
                            <h3 class="mt-5 mb-3 text-primary border-bottom pb-2 section-title">
                                <i class="bi bi-bag-check me-2"></i> Product Purchase
                            </h3>

                            <div class="container-fluid" id="productsContainer">
                                @foreach ($purchaseproduct as $index => $prod)
                                    <div class="row gy-3 align-items-end item-row product-row"
                                        id="product-row-{{ $index }}">
                                        <!-- Product -->
                                        <div class="col-md-4">
                                            <label class="form-label12 fw-semibold">Product</label>
                                            <select class="form-control border-primary shadow-sm product-name"
                                                name="products[{{ $index }}][product_id]">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                        {{ $product->id == $prod->product_id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Qty -->
                                        <div class="col-md-2">
                                            <label class="form-label12 fw-semibold">Qty</label>
                                            <input type="number"
                                                class="form-control border-primary shadow-sm product-quantity"
                                                name="products[{{ $index }}][quantity]"
                                                value="{{ $prod->quantity }}" min="1">
                                        </div>

                                        <!-- Unit Price -->
                                        <div class="col-md-2">
                                            <label class="form-label12 fw-semibold">Unit Price</label>
                                            <input type="number" step="0.01"
                                                class="form-control border-primary shadow-sm product-price"
                                                name="products[{{ $index }}][price]"
                                                value="{{ $prod->unit_price }}">
                                        </div>

                                        <!-- Total -->
                                        <div class="col-md-2">
                                            <label class="form-label12 fw-semibold">Total</label>
                                            <input type="number" step="0.01"
                                                class="form-control border-primary shadow-sm product-total"
                                                name="products[{{ $index }}][total]" value="{{ $prod->total }}"
                                                readonly>
                                        </div>

                                        <!-- Delete -->
                                        <div class="col-md-2 d-flex">
                                            <button type="button" class="btn btn-danger remove-item"
                                                data-row="product-row-{{ $index }}">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="addProduct" class="btn btn-outline-primary mt-3">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </button>

                            <div class="row mt-3">
                                <div class="col-md-3 offset-md-9">
                                    <label class="form-label12 fw-semibold">Products Subtotal</label>
                                    <input type="number" class="form-control border-primary shadow-sm"
                                        id="products_subtotal" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer justify-content-start modal-footer-advanced">
                            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Update Device Purchase
                            </button>
                            <a href="{{ route('device-purchases.index') }}"
                                class="btn btn-danger px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-x-circle me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Styles (same as create) -->
    <style>
        .modal-advanced {
            background: linear-gradient(135deg, #f8fafc 70%, #e0f7fa 100%);
            border-radius: 24px;
            border: none;
            box-shadow: 0 8px 40px 0 rgba(8, 164, 164, 0.15);
            overflow: hidden;
        }

        .modal-header-advanced {
            background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%);
            color: #fff;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            border-bottom: 2px solid #e0f7fa;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .modal-body-advanced {
            background: linear-gradient(120deg, #f8f9fa 80%, #e0f7fa 100%);
            padding: 2rem 2.5rem;
        }

        .modal-footer-advanced {
            background: #f1f1f1;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            border-top: 2px solid #e0f7fa;
            padding-top: 1.2rem;
            padding-bottom: 1.2rem;
        }

        .form-label12 {
            font-size: 1.05rem;
            color: #222;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 0.7rem;
            font-size: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(8, 164, 164, 0.18);
            border-color: #08A4A4;
            background: #f0fdfa;
        }

        .item-row {
            background: #fff;
            border: 1px solid #e0f7fa;
            border-radius: 0.7rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
    </style>

    <!-- jQuery for products calculation -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            let productIndex = {{ count($purchaseproduct) }};

            function calculateTotals() {
                let productTotal = 0;
                $('.product-row').each(function() {
                    const qty = parseFloat($(this).find('.product-quantity').val()) || 0;
                    const price = parseFloat($(this).find('.product-price').val()) || 0;
                    const total = qty * price;
                    $(this).find('.product-total').val(total.toFixed(2));
                    productTotal += total;
                });
                $('#products_subtotal').val(productTotal.toFixed(2));
                $('#total_amount').val(productTotal.toFixed(2));
            }
            $('#addProduct').click(function() {
                const row = `
            <div class="row gy-3 align-items-end item-row product-row" id="product-row-${productIndex}">
                <div class="col-md-4">
                    <label class="form-label12 fw-semibold">Product</label>
                    <select class="form-control border-primary shadow-sm product-name" name="products[${productIndex}][product_id]">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label12 fw-semibold">Qty</label>
                    <input type="number" class="form-control border-primary shadow-sm product-quantity" name="products[${productIndex}][quantity]" value="1" min="1">
                </div>
                <div class="col-md-2">
                    <label class="form-label12 fw-semibold">Unit Price</label>
                    <input type="number" step="0.01" class="form-control border-primary shadow-sm product-price" name="products[${productIndex}][price]">
                </div>
                <div class="col-md-2">
                    <label class="form-label12 fw-semibold">Total</label>
                    <input type="number" step="0.01" class="form-control border-primary shadow-sm product-total" name="products[${productIndex}][total]" readonly>
                </div>
                <div class="col-md-2 d-flex">
                    <button type="button" class="btn btn-danger remove-item" data-row="product-row-${productIndex}">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>`;
                $('#productsContainer').append(row);
                productIndex++;
            });
            $(document).on('click', '.remove-item', function() {
                $('#' + $(this).data('row')).remove();
                calculateTotals();
            });
            $(document).on('change', '.product-name', function() {
                const price = $(this).find(':selected').data('price');
                $(this).closest('.product-row').find('.product-price').val(price).trigger('input');
            });
            $(document).on('input', '.product-quantity, .product-price', function() {
                calculateTotals();
            });
            calculateTotals();
        });
    </script>
@endsection
