<div class="modal fade" id="createExpenseModal" tabindex="-1" role="dialog" aria-labelledby="createExpenseLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 20px;">
            <div class="modal-header justify-content-center bg-gradient-info text-white">
                <h3 class="modal-title fw-bold">Create Mechanical Expense</h3>
            </div>
            <form action="{{ route('mechanicals.expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">

                    <!-- Expense Info -->
                    <h5 class="fw-bold mb-3 text-primary">Expense Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label>Mechanical</label>
                            <select name="mechanical_id" class="form-control" required>
                                <option value="">Select Mechanical</option>
                                @foreach ($mechanicals as $mech)
                                    {{-- yahan branch_id attribute pass karna zaruri hai --}}
                                    <option value="{{ $mech->id }}" data-branch="{{ $mech->branch_id }}">
                                        {{ $mech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Payment Method</label>
                            <select name="payment_method" id="payment-method" class="form-control" required>
                                <option value="">Select Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Online">Online</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Receipt</label>
                            <input type="file" name="receipt" class="form-control" accept="image/*,application/pdf">
                        </div>

                        <!-- Hidden fields by default -->
                        <div class="col-md-6 mt-3 d-none" id="bank-field">
                            <label>Select Bank</label>
                            <select name="bank_id" id="bank-select" class="form-control">
                                <option value="">Select Bank</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" data-branch="{{ $bank->branch_id }}">
                                        {{ $bank->bank_name ?? 'Not Display' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-3 d-none" id="cheque-field">
                            <label>Cheque Number</label>
                            <input type="text" name="cheque_number" class="form-control">
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>Description</label>
                            <textarea name="description" class="summernote form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Products Section -->
                    <h5 class="fw-bold mb-3 text-primary">Products</h5>
                    <div id="products-wrapper">
                        <div class="row g-3 mb-3 product-item">
                            <div class="col-md-3">
                                <input type="text" name="products[0][name]" class="form-control"
                                    placeholder="Product Name">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="products[0][title]" class="form-control"
                                    placeholder="Title">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="products[0][amount]" class="form-control"
                                    placeholder="Amount">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="products[0][quantity]" class="form-control"
                                    placeholder="Qty">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="products[0][total]" class="form-control" placeholder="Total"
                                    readonly>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-product"><i
                                        class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-product" class="btn btn-secondary btn-sm mb-3">
                        <i class="fa fa-plus"></i> Add Product
                    </button>

                    <!-- Grand Total -->
                    <div class="row">
                        <div class="col-md-4 offset-md-8">
                            <h5 class="fw-bold text-left">Grand Total:
                                <span id="grand-total">0</span>
                            </h5>
                            <!-- Hidden input for backend -->
                            <input type="hidden" id="expense-amount" name="amount" value="0">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success px-5">Save Expense</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let productIndex = 1;

    // Add Product
    document.getElementById('add-product').addEventListener('click', function() {
        let wrapper = document.getElementById('products-wrapper');
        let html = `
        <div class="row g-3 mb-3 product-item">
            <div class="col-md-3">
                <input type="text" name="products[${productIndex}][name]" class="form-control" placeholder="Product Name">
            </div>
            <div class="col-md-2">
                <input type="text" name="products[${productIndex}][title]" class="form-control" placeholder="Title">
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${productIndex}][amount]" class="form-control" placeholder="Amount">
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${productIndex}][quantity]" class="form-control" placeholder="Qty">
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${productIndex}][total]" class="form-control" placeholder="Total" readonly>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-product"><i class="fa fa-trash"></i></button>
            </div>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        productIndex++;
    });

    // Remove Product
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-product')) {
            e.target.closest('.product-item').remove();
            updateGrandTotal();
        }
    });

    // Auto calculate total & grand total
    document.addEventListener('input', function(e) {
        if (e.target.name.includes('[amount]') || e.target.name.includes('[quantity]')) {
            let row = e.target.closest('.product-item');
            let amount = parseFloat(row.querySelector('input[name*="[amount]"]').value) || 0;
            let qty = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
            row.querySelector('input[name*="[total]"]').value = amount * qty;
            updateGrandTotal();
        }
    });

    // Update Grand Total
    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('#products-wrapper .product-item input[name*="[total]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('grand-total').innerText = total.toFixed(2);
        document.getElementById('expense-amount').value = total.toFixed(2); // set top Amount
    }

    // Payment Method Show/Hide
    document.getElementById('payment-method').addEventListener('change', function() {
        let method = this.value;
        let bankField = document.getElementById('bank-field');
        let chequeField = document.getElementById('cheque-field');

        bankField.classList.add('d-none');
        chequeField.classList.add('d-none');

        if (method === 'Online' || method === 'Cheque') {
            bankField.classList.remove('d-none');
        }
        if (method === 'Cheque') {
            chequeField.classList.remove('d-none');
        }
    });

    // Bank filter by Mechanical branch
    document.querySelector('select[name="mechanical_id"]').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let branchId = selectedOption.getAttribute('data-branch');

        let bankSelect = document.getElementById('bank-select');
        Array.from(bankSelect.options).forEach(option => {
            if (!option.value) return;
            if (option.getAttribute('data-branch') === branchId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // reset selected bank
        bankSelect.value = '';
    });
</script>
