<div class="modal fade" id="editExpenseModal{{ $expense->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editExpenseLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 20px;">
            <div class="modal-header justify-content-center bg-gradient-warning text-white">
                <h3 class="modal-title fw-bold">Edit Mechanical Expense</h3>
            </div>
            <form action="{{ route('mechanicals.expenses.update', $expense->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">

                    <!-- Expense Info -->
                    <h5 class="fw-bold mb-3 text-primary">Expense Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label>Mechanical</label>
                            <select name="mechanical_id" class="form-control" required>
                                <option value="">Select Mechanical</option>
                                @foreach ($mechanicals as $mech)
                                    <option value="{{ $mech->id }}" data-branch="{{ $mech->branch_id }}"
                                        {{ $expense->mechanical_id == $mech->id ? 'selected' : '' }}>
                                        {{ $mech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $expense->title }}"
                                required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $expense->date }}">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Payment Method</label>
                            <select name="payment_method" id="payment-method-{{ $expense->id }}" class="form-control"
                                required>
                                <option value="">Select Method</option>
                                <option value="Cash" {{ $expense->payment_method == 'Cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="Online" {{ $expense->payment_method == 'Online' ? 'selected' : '' }}>
                                    Online</option>
                                <option value="Cheque" {{ $expense->payment_method == 'Cheque' ? 'selected' : '' }}>
                                    Cheque</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3 {{ in_array($expense->payment_method, ['Online', 'Cheque']) ? '' : 'd-none' }}"
                            id="bank-field-{{ $expense->id }}">
                            <label>Select Bank</label>
                            <select name="bank_id" id="bank-select-{{ $expense->id }}" class="form-control">
                                <option value="">Select Bank</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" data-branch="{{ $bank->branch_id }}"
                                        {{ $expense->bank_id == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-3 {{ $expense->payment_method == 'Cheque' ? '' : 'd-none' }}"
                            id="cheque-field-{{ $expense->id }}">
                            <label>Cheque Number</label>
                            <input type="text" name="cheque_number" class="form-control"
                                value="{{ $expense->cheque_number }}">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Receipt</label>
                            <input type="file" name="receipt" class="form-control" accept="image/*,application/pdf">
                            @if ($expense->receipt)
                                <img src="{{ asset('upload/images/mechanical_expenses/receipts/' . $expense->receipt) }}"
                                    alt="Expense Receipt" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>Description</label>
                            <textarea name="description" class="summernote form-control" rows="3">{{ $expense->description }}</textarea>
                        </div>
                    </div>

                    <!-- Products Section -->
                    <h5 class="fw-bold mb-3 text-primary">Products</h5>
                    <div id="products-wrapper-{{ $expense->id }}">
                        @foreach ($expense->products as $index => $product)
                            <div class="row g-3 mb-3 product-item">
                                <div class="col-md-3">
                                    <input type="text" name="products[{{ $index }}][name]"
                                        value="{{ $product->name }}" class="form-control" placeholder="Product Name">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="products[{{ $index }}][title]"
                                        value="{{ $product->title }}" class="form-control" placeholder="Title">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="products[{{ $index }}][amount]"
                                        value="{{ $product->amount }}" class="form-control" placeholder="Amount">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="products[{{ $index }}][quantity]"
                                        value="{{ $product->quantity }}" class="form-control" placeholder="Qty">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="products[{{ $index }}][total]"
                                        value="{{ $product->total }}" class="form-control" placeholder="Total"
                                        readonly>
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-product"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-product-{{ $expense->id }}"
                        class="btn btn-secondary btn-sm mb-3">
                        <i class="fa fa-plus"></i> Add Product
                    </button>

                    <!-- Grand Total -->
                    <div class="row">
                        <div class="col-md-4 offset-md-8">
                            <h5 class="fw-bold text-left">Grand Total:
                                <span id="grand-total-{{ $expense->id }}">{{ $expense->amount }}</span>
                            </h5>
                            <input type="hidden" id="expense-amount-{{ $expense->id }}" name="amount"
                                value="{{ $expense->amount }}">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success px-5">Update Expense</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    (function() {
        let expenseId = "{{ $expense->id }}";
        let productIndex = {{ count($expense->products) }};

        // Add Product
        document.getElementById('add-product-' + expenseId).addEventListener('click', function() {
            let wrapper = document.getElementById('products-wrapper-' + expenseId);
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

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('#products-wrapper-' + expenseId + ' .product-item input[name*="[total]"]')
                .forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
            document.getElementById('grand-total-' + expenseId).innerText = total.toFixed(2);
            document.getElementById('expense-amount-' + expenseId).value = total.toFixed(2);
        }

        // Payment Method Show/Hide
        document.getElementById('payment-method-' + expenseId).addEventListener('change', function() {
            let method = this.value;
            let bankField = document.getElementById('bank-field-' + expenseId);
            let chequeField = document.getElementById('cheque-field-' + expenseId);

            bankField.classList.add('d-none');
            chequeField.classList.add('d-none');

            if (method === 'Online' || method === 'Cheque') {
                bankField.classList.remove('d-none');
            }
            if (method === 'Cheque') {
                chequeField.classList.remove('d-none');
            }
        });

        // --- Bank filter by Mechanical branch ---
        function filterBanks() {
            let mechSelect = document.querySelector('#editExpenseModal' + expenseId +
                ' select[name="mechanical_id"]');
            let selectedOption = mechSelect.options[mechSelect.selectedIndex];
            let branchId = selectedOption.getAttribute('data-branch');

            let bankSelect = document.getElementById('bank-select-' + expenseId);
            Array.from(bankSelect.options).forEach(option => {
                if (!option.value) return;
                if (option.getAttribute('data-branch') === branchId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });

            // Agar selected bank same branch ka nahi hai to reset karo
            if (bankSelect.selectedOptions.length && bankSelect.selectedOptions[0].getAttribute('data-branch') !==
                branchId) {
                bankSelect.value = '';
            }
        }

        // Run once on modal load
        filterBanks();

        // Re-run on mechanical change
        document.querySelector('#editExpenseModal' + expenseId + ' select[name="mechanical_id"]').addEventListener(
            'change', filterBanks);

    })();
</script>
