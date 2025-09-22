<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1100px;">
        <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center modal-header-advanced">
                <h1 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">
                    <i class="bi bi-plus-circle-dotted me-2"></i>
                    Create Device Purchase
                </h1>
            </div>
            <form action="" id="devicePurchaseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body modal-body-advanced">
                    <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                        <i class="bi bi-phone me-2"></i>
                        Device Purchase
                    </h3>
                    <div class="container-fluid">
                        <div class="row gy-3">
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Supplier</label>
                                <select class="form-control border-primary shadow-sm" name="supplier_id">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Branch</label>

                                @if (auth()->user()->name === 'Super Admin')
                                    <!-- Super Admin: Dropdown -->
                                    <select class="form-control border-primary shadow-sm" name="branch_id">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <!-- Normal User: Readonly Branch -->
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                    <input type="text" class="form-control border-primary shadow-sm"
                                        value="{{ optional(auth()->user()->branch)->name }}" readonly>
                                @endif
                            </div>

                            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Bill No.</label>
                                <input class="form-control border-primary shadow-sm" placeholder="Enter bill number"
                                    type="text" name="bill_no" id="bill_no">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Total Amount</label>
                                <input class="form-control border-primary shadow-sm" placeholder="Enter total amount"
                                    type="number" step="0.01" name="total_amount" id="total_amount" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Receipt</label>
                                <input class="form-control border-primary shadow-sm" type="file" name="receipt"
                                    id="receipt" accept="image/*,application/pdf">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Status</label>
                                <select class="form-control border-primary shadow-sm" name="status">
                                    <option value="" selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label12 fw-semibold">Description</label>
                                <textarea name="description" class="form-control border-primary shadow-sm" id="description" rows="3"
                                    placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Product Purchase Section -->
                    <h3 class="mt-5 mb-3 text-primary border-bottom pb-2 section-title">
                        <i class="bi bi-bag-check me-2"></i>
                        Product Purchase
                    </h3>
                    <div class="container-fluid">
                        <div id="productContainer"></div>
                        <button type="button" id="addProduct" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>

                        <div class="row mt-3">
                            <div class="col-md-3 offset-md-9">
                                <label class="form-label12 fw-semibold">Products Subtotal</label>
                                <input class="form-control border-primary shadow-sm" type="number" step="0.01"
                                    name="products_subtotal" id="products_subtotal" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start modal-footer-advanced">
                    <button type="submit" name="submit" id="btnSubmit"
                        class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i>Save Device Purchase
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
        box-shadow: 0 2px 8px 0 rgba(8, 164, 164, 0.08);
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
        transition: box-shadow 0.2s, border-color 0.2s;
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

    .item-row .form-control {
        height: 42px;
        font-size: 1rem;
    }


    .item-row label {
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }

    .remove-item {
        border-radius: 0.5rem;
    }
</style>

<script>
    $(document).ready(function() {
        let productIndex = 0;

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
            productIndex++;
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
                        <input class="form-control border-primary shadow-sm product-quantity"
                            name="products[${productIndex}][quantity]" type="number" value="1" min="1">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label12 fw-semibold">Unit Price</label>
                        <input class="form-control border-primary shadow-sm product-price"
                            name="products[${productIndex}][price]" type="number" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label12 fw-semibold">Total</label>
                        <input class="form-control border-primary shadow-sm product-total"
                            name="products[${productIndex}][total]" type="number" step="0.01" readonly>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="button" class="btn btn-danger remove-item" data-row="product-row-${productIndex}">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>`;

            $('#productContainer').append(row);

            $(`#product-row-${productIndex} .product-name`).change(function() {
                const price = $(this).find(':selected').data('price');
                $(this).closest('.product-row').find('.product-price').val(price).trigger(
                    'input');
            });
        });

        $(document).on('click', '.remove-item', function() {
            const rowId = $(this).data('row');
            $(`#${rowId}`).remove();
            calculateTotals();
        });

        $(document).on('input', '.product-quantity, .product-price', function() {
            calculateTotals();
        });

        $('#addProduct').trigger('click');
    });
</script>
