<!-- ✅ Edit Return Modal -->
<div class="modal fade" id="editReturnModal{{ $return->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editReturnLabel{{ $return->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg modal-advanced">
            <form action="{{ route('returns.update', $return->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="modal-header justify-content-between modal-header-advanced">
                    <h5 class="mb-0 fs-4 fw-bold text-white">
                        <i class="bi bi-pencil-square me-2"></i> Edit Return
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body modal-body-advanced">
                    <div class="row g-3">
                        <!-- Site Select -->
                        <div class="col-md-12">
                            <label class="form-label12 fw-semibold">Select Site</label>
                            <select name="site_id" class="form-control border-primary shadow-sm" required>
                                <option value="">-- Select Site --</option>
                                @foreach ($projects as $site)
                                    <option value="{{ $site->id }}"
                                        {{ $return->site_id == $site->id ? 'selected' : '' }}>
                                        {{ $site->name }} ({{ $site->branch->name ?? 'No Branch' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-12 mt-2">
                            <label class="form-label12 fw-semibold">Remarks</label>
                            <textarea name="remarks" class="form-control summernote">{{ $return->remarks }}</textarea>
                        </div>
                    </div>

                    <!-- Products -->
                    <h5 class="mt-4 mb-3 text-primary border-bottom pb-2 section-title">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </h5>
                    <div id="editReturnProductContainer{{ $return->id }}">
                        @foreach ($return->products as $index => $rp)
                            <div class="row gy-3 align-items-end item-row return-row">
                                <div class="col-md-6">
                                    <label class="form-label12 fw-semibold">Product</label>
                                    <select name="products[{{ $index }}][product_id]"
                                        class="form-control border-primary shadow-sm" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $rp->product_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label12 fw-semibold">Quantity</label>
                                    <input type="number" name="products[{{ $index }}][quantity]"
                                        class="form-control border-primary shadow-sm" min="1"
                                        value="{{ $rp->quantity }}" required>
                                </div>
                                <div class="col-md-2 d-flex">
                                    <button type="button" class="btn btn-danger remove-row">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-3"
                        id="addEditReturnProductRow{{ $return->id }}">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </button>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-advanced">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <button type="button" class="btn btn-secondary px-4 py-2 fw-bold shadow-sm" data-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Scripts -->
<script>
    $(function() {
        const productsEdit{{ $return->id }} = @json($products);
        let editIndex{{ $return->id }} = {{ $return->products->count() }};

        function createEditRow(index) {
            let options = productsEdit{{ $return->id }}.map(p =>
                `<option value="${p.id}">${p.name}</option>`).join('');
            return `
            <div class="row gy-3 mt-2 align-items-end item-row return-row">
                <div class="col-md-6">
                    <label class="form-label12 fw-semibold">Product</label>
                    <select name="products[${index}][product_id]" class="form-control border-primary shadow-sm" required>
                        <option value="">-- Select Product --</option>
                        ${options}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label12 fw-semibold">Quantity</label>
                    <input type="number" name="products[${index}][quantity]" class="form-control border-primary shadow-sm" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex">
                    <button type="button" class="btn btn-danger remove-row">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>`;
        }

        // Add row
        $("#addEditReturnProductRow{{ $return->id }}").on("click", function() {
            $("#editReturnProductContainer{{ $return->id }}").append(createEditRow(
                editIndex{{ $return->id }}++));
        });

        // Remove row
        $(document).on("click", ".remove-row", function() {
            $(this).closest(".return-row").remove();
        });
    });
</script>
