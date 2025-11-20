@extends('setting::layouts.master')

@section('title', 'Create Order')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Create Order</li>
    </ol>
@endsection

@section('content')
@php
    // check role (adjust field name based on your user table)
    $isPurchaseTeam = ($userRole === 'purchase');
@endphp

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Create Order</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
                <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header justify-content-center modal-header-advanced">
                        <h5 class="mb-0 fs-3 fw-bold text-white">
                            <i class="bi bi-plus-circle-dotted me-2"></i> Order Details
                        </h5>
                    </div>

                    <div class="modal-body modal-body-advanced">
                        <div class="container-fluid">
                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <label class="form-label12 fw-semibold">Select Project</label>
                                    <select name="project_id" class="form-control border-primary shadow-sm" required>
                                        <option value="">-- Select Project --</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-5 mb-3 text-primary border-bottom pb-2 section-title">
                            <i class="bi bi-bag-check me-2"></i>
                            Products {{ $isPurchaseTeam ? '& Images' : '' }}
                        </h3>

                        <div class="container-fluid">
                            <div id="productContainer"></div>
                            <button type="button" class="btn btn-outline-primary mt-3" id="addProductRow">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-start modal-footer-advanced">
                        <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                            <i class="bi bi-save me-2"></i> Save Order
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-danger px-5 py-2 fw-bold shadow-sm">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .modal-advanced {
        background: linear-gradient(135deg, #f8fafc 70%, #e0f7fa 100%);
        border-radius: 24px;
        box-shadow: 0 8px 40px rgba(8, 164, 164, 0.15);
    }

    .modal-header-advanced {
        background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%);
        color: #fff;
        border-top-left-radius: 24px;
        border-top-right-radius: 24px;
        border-bottom: 2px solid #e0f7fa;
        padding: 1.2rem 1.5rem;
    }

    .modal-body-advanced {
        background: linear-gradient(120deg, #f8f9fa 80%, #e0f7fa 100%);
        padding: 2rem;
    }

    .modal-footer-advanced {
        background: #f1f1f1;
        border-bottom-left-radius: 24px;
        border-bottom-right-radius: 24px;
        border-top: 2px solid #e0f7fa;
        padding: 1rem 1.5rem;
    }

    .form-label12 {
        font-size: 1rem;
        font-weight: 600;
        color: #222;
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

    .product-block {
        background: #ffffff;
        border: 1px solid #d1f3f3;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
    }

    .image-row {
        background: #f8f9fa;
        border: 1px dashed #b2ebf2;
        border-radius: 0.5rem;
        padding: 0.8rem;
    }

    .remove-row, .remove-product-row {
        border-radius: 0.5rem;
    }
</style>
<script>
    const isPurchaseTeam = @json($isPurchaseTeam);
    let productIndex = 0;

    function createProductRow(index) {
        return `
        <div class="item-row product-block mb-4 p-3 border rounded">
            <div class="row gy-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="products[${index}][product_name]" class="form-control border-primary shadow-sm" placeholder="Product Name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[${index}][quantity]" class="form-control border-primary shadow-sm quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="products[${index}][unit]" class="form-control border-primary shadow-sm" placeholder="Unit" required>
                </div>

                ${isPurchaseTeam ? `
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-success add-image-row" data-index="${index}">
                        <i class="bi bi-plus-circle"></i> Add Image
                    </button>
                </div>` : ''}

                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-danger remove-product-row" title="Remove Product">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>

            ${isPurchaseTeam ? `<div class="image-price-container mt-3" data-product-index="${index}"></div>` : ''}
        </div>`;
    }

    function createImageRow(productIndex, imageIndex) {
        return `
        <div class="row gy-3 align-items-center image-row mb-2">
            <div class="col-md-4">
                <input type="file" name="products[${productIndex}][images][${imageIndex}][file]" class="form-control border-primary shadow-sm" accept="image/*" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="products[${productIndex}][images][${imageIndex}][title]" class="form-control border-primary shadow-sm" placeholder="Image Title" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="products[${productIndex}][images][${imageIndex}][price]" class="form-control border-primary shadow-sm" placeholder="Price" required>
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-outline-danger remove-image-row">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        </div>`;
    }

    $(function() {
        const container = $("#productContainer");

        $("#addProductRow").on("click", function() {
            container.append(createProductRow(productIndex++));
        });

        $(document).on("click", ".remove-product-row", function() {
            $(this).closest(".product-block").remove();
        });

        $(document).on("click", ".add-image-row", function() {
            const productIndex = $(this).data("index");
            const imageContainer = $(`.image-price-container[data-product-index="${productIndex}"]`);
            const imageIndex = imageContainer.find(".image-row").length;
            imageContainer.append(createImageRow(productIndex, imageIndex));
        });

        $(document).on("click", ".remove-image-row", function() {
            $(this).closest(".image-row").remove();
        });

        $("#addProductRow").trigger("click");
    });
</script>
@endsection
