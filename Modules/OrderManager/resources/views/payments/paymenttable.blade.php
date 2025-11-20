 <!-- Selected Items -->
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
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->purchased_qty }}</td>
                            <td>₹{{ number_format($item->per_unit_price, 2) }}</td>
                            <td>₹{{ number_format($item->total_price, 2) }}</td>
                            <td class="text-success">
                                ₹{{ number_format($item->payment ? $item->payment->paid_amount : 0, 2) }}</td>
                            <td class="text-warning">
                                ₹{{ number_format($item->payment ? $item->payment->remaining_amount : $item->total_price, 2) }}
                            </td>
                            <td>
                                <input type="number" 
                                       name="paid_amounts[{{ $item->id }}]"
                                       class="form-control form-control-sm paid-amount-input"
                                       data-max="{{ $item->payment ? $item->payment->remaining_amount : $item->total_price }}"
                                       data-item-id="{{ $item->id }}" 
                                       step="0.01" 
                                       min="0"
                                       max="{{ $item->payment ? $item->payment->remaining_amount : $item->total_price }}"
                                       value="0">
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

