@extends('setting::layouts.master')

@section('title', 'Create Order')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Create Order</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Create Order</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
                    <form action="{{ route('orders.store') }}" method="POST">
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

                            <!-- ✅ Product Section -->
                            <h3 class="mt-5 mb-3 text-primary border-bottom pb-2 section-title">
                                <i class="bi bi-bag-check me-2"></i>
                                Products
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

        .remove-row {
            border-radius: 0.5rem;
        }
    </style>

    <script>
        let rowIndex = 0;
        const products = @json($products);

        function createRow(index) {
            let options = products.map(p =>
                `<option value="${p.id}" data-unit="${p.unit ? p.unit.name : 'N/A'}">${p.name}</option>`
            ).join('');

            return `
            <div class="row gy-3 align-items-end item-row product-row">
                <div class="col-md-4">
                    <label class="form-label12 fw-semibold">Product</label>
                    <select name="products[${index}][product_id]" class="form-control product-select border-primary shadow-sm" required>
                        <option value="">-- Select Product --</option>
                        ${options}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label12 fw-semibold">Quantity</label>
                    <input type="number" name="products[${index}][quantity]" class="form-control quantity-input border-primary shadow-sm" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label12 fw-semibold">Unit</label>
                    <input type="text" name="products[${index}][unit]" class="form-control unit-input border-primary shadow-sm" readonly>
                </div>
                <div class="col-md-2 d-flex">
                    <button type="button" class="btn btn-danger remove-row">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>`;
        }

        $(function() {
            const container = $("#productContainer");

            function addRow() {
                const html = createRow(rowIndex++);
                container.append(html);
            }

            addRow(); // initial row

            $("#addProductRow").on("click", addRow);

            $(document).on("change", ".product-select", function() {
                const selected = $(this).find(":selected");
                const unit = selected.data('unit') || '';
                $(this).closest(".product-row").find('.unit-input').val(unit);
            });

            $(document).on("click", ".remove-row", function() {
                $(this).closest(".product-row").remove();
            });
        });
    </script>
@endsection
