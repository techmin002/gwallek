<form action="{{ route('payments.store') }}" method="POST" id="paymentForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input type="hidden" name="total_amount" id="total_amount" value="{{ $totals['total_remaining'] }}">
    <input type="hidden" name="paid_by" value="{{ auth()->id() }}">

    <!-- Debug Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <h4>Validation Errors:</h4>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Selected Items Table -->
    <div class="row mb-4">
        <div class="col-12">
            <h5>Selected Purchase Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="table-secondary">
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Already Paid</th>
                            <th>Remaining</th>
                            <th>Pay Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseItems as $item)
                            @php
                                $paidAmount = $item->paid_amount; // Using accessor
                                $remainingAmount = $item->remaining_amount; // Using accessor
                                $maxAllowed = $remainingAmount; // Maximum amount that can be paid
                            @endphp
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->purchased_qty }}</td>
                                <td>₹{{ number_format($item->per_unit_price, 2) }}</td>
                                <td>₹{{ number_format($item->total_price, 2) }}</td>
                                <td class="text-success">
                                    ₹{{ number_format($paidAmount, 2) }}
                                </td>
                                <td class="text-warning">
                                    ₹{{ number_format($remainingAmount, 2) }}
                                </td>
                                <td>
                                    @if($remainingAmount > 0)
                                        <input type="number" 
                                               name="paid_amounts[{{ $item->id }}]"
                                               class="form-control form-control-sm paid-amount-input"
                                               data-max="{{ $remainingAmount }}"
                                               data-item-id="{{ $item->id }}" 
                                               step="0.01" 
                                               min="0"
                                               max="{{ $remainingAmount }}"
                                               value="0"
                                               placeholder="0.00">
                                    @else
                                        <input type="number" 
                                               class="form-control form-control-sm bg-light"
                                               value="0"
                                               disabled
                                               title="This item is fully paid">
                                        <input type="hidden" name="paid_amounts[{{ $item->id }}]" value="0">
                                    @endif
                                    <!-- Add hidden field for purchase_item_id -->
                                    <input type="hidden" name="purchase_item_ids[]" value="{{ $item->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <td colspan="3" class="text-right"><strong>Totals:</strong></td>
                            <td><strong>₹{{ number_format($totals['total_amount'], 2) }}</strong></td>
                            <td><strong>₹{{ number_format($totals['total_paid'], 2) }}</strong></td>
                            <td><strong>₹{{ number_format($totals['total_remaining'], 2) }}</strong></td>
                            <td><strong id="totalPayAmount">₹0.00</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Details -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="payment_type">Payment Type *</label>
                <select name="payment_type" id="payment_type" class="form-control" required>
                    <option value="">Select Payment Type</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                    <option value="online">Online</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="receipt_number">Receipt Number</label>
                <input type="text" name="receipt_number" id="receipt_number" class="form-control"
                    placeholder="Enter receipt number (optional)">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_by_display">Paid By *</label>
                <input type="text" id="paid_by_display" class="form-control bg-light" 
                    value="{{ auth()->user()->name }} (You)" readonly>
                <small class="form-text text-muted">Payment will be recorded under your account</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_at">Payment Date *</label>
                <input type="datetime-local" name="paid_at" id="paid_at" class="form-control" required
                       value="{{ now()->format('Y-m-d\TH:i') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Total Payment Amount</label>
                <div class="form-control bg-light" id="displayTotalAmount">₹0.00</div>
                <input type="hidden" name="total_paid_amount" id="total_paid_amount" value="0">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="attachment">Attachment (Optional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control-file"
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <small class="form-text text-muted">
                    Supported formats: JPG, PNG, PDF, DOC (Max: 5MB)
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="remark">Remarks (Optional)</label>
                <textarea name="remark" id="remark" class="form-control" rows="3"
                    placeholder="Add any additional notes about this payment"></textarea>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="button" id="payAllRemaining" class="btn btn-outline-success">
                            <i class="fa fa-money-bill-wave"></i> Pay All Remaining
                        </button>
                        <button type="button" id="payHalfRemaining" class="btn btn-outline-primary">
                            <i class="fa fa-percentage"></i> Pay 50% of Remaining
                        </button>
                        <button type="button" id="clearAll" class="btn btn-outline-danger">
                            <i class="fa fa-trash"></i> Clear All Amounts
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Payment Summary</h3>
                </div>
                <div class="card-body">
                    <div id="paymentSummary">
                        <p class="text-muted">Enter payment amounts to see summary</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
            <i class="fa fa-credit-card"></i> Process Payment
        </button>
        <a href="{{ route('payments.project-items') }}?project_id={{ $project->id }}" class="btn btn-secondary btn-lg">
            <i class="fa fa-arrow-left"></i> Back to Items
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paidAmountInputs = document.querySelectorAll('.paid-amount-input');
    const totalPayAmount = document.getElementById('totalPayAmount');
    const displayTotalAmount = document.getElementById('displayTotalAmount');
    const totalPaidAmountInput = document.getElementById('total_paid_amount');
    const paymentSummary = document.getElementById('paymentSummary');
    const submitBtn = document.getElementById('submitBtn');
    const paymentForm = document.getElementById('paymentForm');

    // Update totals and summary
    function updateTotals() {
        let totalPay = 0;
        let summaryHTML = '<table class="table table-sm mb-0">';
        let hasValidPayment = false;
        let itemCount = 0;

        paidAmountInputs.forEach(input => {
            const paidAmount = parseFloat(input.value) || 0;
            const maxAmount = parseFloat(input.dataset.max);
            totalPay += paidAmount;

            if (paidAmount > 0) {
                hasValidPayment = true;
                itemCount++;
                const itemName = input.closest('tr').querySelector('td:first-child').textContent.trim();
                summaryHTML += `
                    <tr>
                        <td>${itemName}</td>
                        <td class="text-right">₹${paidAmount.toFixed(2)}</td>
                    </tr>
                `;
            }
        });

        if (!hasValidPayment) {
            summaryHTML = '<p class="text-muted">Enter payment amounts to see summary</p>';
        } else {
            summaryHTML += `
                <tr class="table-success">
                    <td><strong>Total (${itemCount} items):</strong></td>
                    <td class="text-right"><strong>₹${totalPay.toFixed(2)}</strong></td>
                </tr>
            </table>`;
        }

        totalPayAmount.textContent = '₹' + totalPay.toFixed(2);
        displayTotalAmount.textContent = '₹' + totalPay.toFixed(2);
        totalPaidAmountInput.value = totalPay;
        paymentSummary.innerHTML = summaryHTML;

        // Enable/disable submit button
        submitBtn.disabled = !hasValidPayment;
        
        // Update button text
        if (hasValidPayment) {
            submitBtn.innerHTML = '<i class="fa fa-credit-card"></i> Process Payment - ₹' + totalPay.toFixed(2);
        } else {
            submitBtn.innerHTML = '<i class="fa fa-credit-card"></i> Process Payment';
        }
    }

    // Quick action buttons
    document.getElementById('payAllRemaining').addEventListener('click', function() {
        paidAmountInputs.forEach(input => {
            const maxAmount = parseFloat(input.dataset.max);
            input.value = maxAmount.toFixed(2);
        });
        updateTotals();
    });

    document.getElementById('payHalfRemaining').addEventListener('click', function() {
        paidAmountInputs.forEach(input => {
            const maxAmount = parseFloat(input.dataset.max);
            const halfAmount = maxAmount / 2;
            input.value = halfAmount.toFixed(2);
        });
        updateTotals();
    });

    document.getElementById('clearAll').addEventListener('click', function() {
        paidAmountInputs.forEach(input => {
            input.value = '0';
        });
        updateTotals();
    });

    // Event listeners for amount inputs
    paidAmountInputs.forEach(input => {
        input.addEventListener('input', function() {
            const maxAmount = parseFloat(this.dataset.max);
            const currentValue = parseFloat(this.value) || 0;
            
            if (currentValue > maxAmount) {
                this.value = maxAmount.toFixed(2);
                alert('Payment amount cannot exceed remaining amount: ₹' + maxAmount.toFixed(2));
            }
            
            if (currentValue < 0) {
                this.value = '0';
            }
            
            updateTotals();
        });

        input.addEventListener('change', function() {
            const currentValue = parseFloat(this.value) || 0;
            if (currentValue < 0) {
                this.value = '0';
            }
            updateTotals();
        });
    });

    // Form submission validation
    paymentForm.addEventListener('submit', function(e) {
        let hasValidPayment = false;

        paidAmountInputs.forEach(input => {
            const paidAmount = parseFloat(input.value) || 0;
            if (paidAmount > 0) {
                hasValidPayment = true;
            }
        });

        if (!hasValidPayment) {
            e.preventDefault();
            alert('Please enter payment amounts for at least one item.');
            return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    });

    // Set current datetime as default if not already set
    if (!document.getElementById('paid_at').value) {
        document.getElementById('paid_at').value = new Date().toISOString().slice(0, 16);
    }

    // Initial update
    updateTotals();
});
</script>