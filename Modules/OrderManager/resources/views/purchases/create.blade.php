@php
    // Check if any approved item still has remaining quantity
    $hasRemainingItems = $approvedItems->some(function ($item) {
        $purchasedQty = $item->purchases->sum('purchased_qty') ?? 0;
        return $item->quantity - $purchasedQty > 0;
    });
@endphp

@if ($hasRemainingItems)
    <form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data" id="purchaseForm">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        @csrf
        <div class="card">
            <div class="card-header bg-success text-white">
                Purchase Approved Items
            </div>
            <div class="card-body">

                @foreach ($approvedItems as $index => $item)
                    @php
                        $purchasedQty = $item->purchases->sum('purchased_qty') ?? 0;
                        $remainingQty = $item->quantity - $purchasedQty;
                    @endphp

                    @if ($remainingQty > 0)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    {{ $item->product_name }} —
                                    Approved: {{ $item->quantity }},
                                    Purchased: {{ $purchasedQty }},
                                    Remaining: <strong>{{ $remainingQty }}</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="products[{{ $index }}][id]"
                                    value="{{ $item->id }}">
                                <div id="purchaseRows{{ $index }}" class="purchase-rows-container"></div>
                                <button type="button" class="btn btn-outline-primary add-purchase mt-2"
                                    data-index="{{ $index }}">
                                    <i class="fa fa-plus"></i> Add Brand/Qty/Image
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ $item->product_name }} - Fully Purchased
                        </div>
                    @endif
                @endforeach

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-save"></i> Save Purchase
                    </button>
                </div>
            </div>
        </div>
    </form>
@else
    <div class="alert alert-success text-center">
        All approved items have been fully purchased.
        <br>
        <a href="{{ route('purchases.index') }}" class="btn btn-primary mt-2">
            Back to Orders
        </a>
    </div>
@endif

{{-- JS for Dynamic Purchase Rows --}}
<script>
    function createPurchaseRow(productIndex, rowIndex) {
        return `
        <div class="row mb-2 purchase-row border rounded p-2 bg-light">
            <div class="col-md-3">
                <label>Brand Name</label>
                <input type="text" name="products[${productIndex}][images][${rowIndex}][brand]" 
                       class="form-control form-control-sm brand-input" placeholder="Enter brand">
            </div>
            <div class="col-md-2">
                <label>Quantity</label>
                <input type="number" name="products[${productIndex}][images][${rowIndex}][quantity]" 
                       class="form-control form-control-sm quantity-input" min="1" placeholder="Qty">
            </div>
            <div class="col-md-3">
                <label>Image</label>
                <input type="file" name="products[${productIndex}][images][${rowIndex}][file]" 
                       class="form-control form-control-sm file-input" accept="image/*">
            </div>
            <div class="col-md-2">
                <label>Price</label>
                <input type="number" step="0.01" name="products[${productIndex}][images][${rowIndex}][price]" 
                       class="form-control form-control-sm price-input" placeholder="0.00">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-purchase">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
        </div>
    `;
    }

    $(document).ready(function() {
        // Add purchase row
        $('.add-purchase').click(function() {
            const index = $(this).data('index');
            const container = $('#purchaseRows' + index);
            const rowIndex = container.children('.purchase-row').length;
            container.append(createPurchaseRow(index, rowIndex));
        });

        // Remove purchase row
        $(document).on('click', '.remove-purchase', function() {
            $(this).closest('.purchase-row').remove();
        });

        // Auto-add first row for each product
        $('.add-purchase').each(function() {
            $(this).click(); // Auto-click to add first row
        });
    });
</script>
