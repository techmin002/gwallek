<form action="{{ route('payments.create') }}" method="GET" id="itemsForm">
    <input type="hidden" name="project_id" value="{{ $project->id }}">

    <div class="card">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Purchase Items</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool text-white" id="selectAll">
                    Select All
                </button>
            </div>
        </div>
        <div class="card-body">
            @if ($purchaseItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50px">
                                    <input type="checkbox" id="selectAllCheckbox">
                                </th>
                                <th>Item Title</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Paid Amount</th>
                                <th>Remaining Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseItems as $item)
                                @php
                                    // Use the accessor methods from PurchaseItem model
                                    $paidAmount = $item->paid_amount; // This uses getPaidAmountAttribute()
                                    $remainingAmount = $item->remaining_amount; // This uses getRemainingAmountAttribute()
                                    $paymentStatus = $item->payment_status; // This uses getPaymentStatusAttribute()
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="purchase_items[]" value="{{ $item->id }}"
                                            class="item-checkbox"
                                            data-amount="{{ $remainingAmount }}"
                                            {{ $remainingAmount <= 0 ? 'disabled' : '' }}>
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->purchased_qty }}</td>
                                    <td>₹{{ number_format($item->per_unit_price, 2) }}</td>
                                    <td>₹{{ number_format($item->total_price, 2) }}</td>
                                    <td class="{{ $paidAmount > 0 ? 'text-success' : 'text-muted' }}">
                                        ₹{{ number_format($paidAmount, 2) }}
                                    </td>
                                    <td class="{{ $remainingAmount > 0 ? 'text-warning' : 'text-muted' }}">
                                        ₹{{ number_format($remainingAmount, 2) }}
                                    </td>
                                    <td>
                                        @if ($paymentStatus == 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @elseif ($paymentStatus == 'partial')
                                            <span class="badge badge-warning">Partial</span>
                                        @else
                                            <span class="badge badge-secondary">Unpaid</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <td colspan="4" class="text-right"><strong>Totals:</strong></td>
                                <td><strong>₹{{ number_format($purchaseItems->sum('total_price'), 2) }}</strong></td>
                                <td><strong>₹{{ number_format($purchaseItems->sum('paid_amount'), 2) }}</strong></td>
                                <td><strong>₹{{ number_format($purchaseItems->sum('remaining_amount'), 2) }}</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <h6>Selection Summary:</h6>
                            <div id="selectionSummary">
                                No items selected
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-success btn-lg" id="proceedBtn" disabled>
                            <i class="fa fa-credit-card"></i> Proceed to Payment
                        </button>
                        <a href="{{ route('payments.select-project') }}" class="btn btn-secondary btn-lg">
                            <i class="fa fa-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <h5>No purchase items found for this project.</h5>
                    <p>Please make sure there are orders associated with this project.</p>
                    <a href="{{ route('payments.select-project') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Back to Projects
                    </a>
                </div>
            @endif
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox:not(:disabled)');
        const proceedBtn = document.getElementById('proceedBtn');
        const selectionSummary = document.getElementById('selectionSummary');

        function updateSelectionSummary() {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked:not(:disabled)');
            let totalRemaining = 0;
            let selectedCount = selectedItems.length;

            selectedItems.forEach(checkbox => {
                totalRemaining += parseFloat(checkbox.dataset.amount);
            });

            if (selectedCount > 0) {
                selectionSummary.innerHTML = `
                    <strong>Selected Items:</strong> ${selectedCount}<br>
                    <strong>Total Remaining Amount:</strong> ₹${totalRemaining.toFixed(2)}
                `;
                proceedBtn.disabled = false;
            } else {
                selectionSummary.innerHTML = 'No items selected';
                proceedBtn.disabled = true;
            }
        }

        // Select All functionality (only enabled items)
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = selectAllCheckbox.checked;
                }
            });
            updateSelectionSummary();
        });

        // Individual checkbox change
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectionSummary);
        });

        // Update select all checkbox state
        function updateSelectAllCheckbox() {
            const enabledCheckboxes = document.querySelectorAll('.item-checkbox:not(:disabled)');
            const checkedEnabledCheckboxes = document.querySelectorAll('.item-checkbox:checked:not(:disabled)');
            
            selectAllCheckbox.checked = enabledCheckboxes.length > 0 && 
                                      checkedEnabledCheckboxes.length === enabledCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedEnabledCheckboxes.length > 0 && 
                                            checkedEnabledCheckboxes.length < enabledCheckboxes.length;
        }

        // Initial summary update
        updateSelectionSummary();
        updateSelectAllCheckbox();
    });
</script>