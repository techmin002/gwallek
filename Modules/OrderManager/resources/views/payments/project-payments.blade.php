@extends('setting::layouts.master')

@section('title', 'Select Purchase Items for Payment')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payments.select-project') }}">Select Project</a></li>
        <li class="breadcrumb-item active">Select Items</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Select Purchase Items</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('payments.select-project') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Project Info -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Project Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Project Name:</strong> {{ $project->name }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Customer:</strong> {{ $project->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Location:</strong> {{ $project->location ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('payments.create') }}" method="GET" id="itemsForm">
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title">Purchase Items</h3>
                                    <div class="card-tools">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light" id="selectAllBtn">
                                                <i class="fa fa-check-square"></i> Select All
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light" id="deselectAllBtn">
                                                <i class="fa fa-square"></i> Deselect All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($purchaseItems->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" id="itemsTable">
                                                <thead>
                                                    <tr>
                                                        <th width="60px">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="selectAllCheckbox">
                                                                <label class="form-check-label" for="selectAllCheckbox">All</label>
                                                            </div>
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
                                                    @foreach($purchaseItems as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" 
                                                                           name="purchase_items[]" 
                                                                           value="{{ $item->id }}"
                                                                           class="form-check-input item-checkbox"
                                                                           id="item_{{ $item->id }}"
                                                                           data-amount="{{ $item->payment ? $item->payment->remaining_amount : $item->total_price }}"
                                                                           data-item-name="{{ $item->title }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="item_{{ $item->id }}" class="mb-0 cursor-pointer">
                                                                    {{ $item->title }}
                                                                </label>
                                                            </td>
                                                            <td>{{ $item->purchased_qty }}</td>
                                                            <td>₹{{ number_format($item->per_unit_price, 2) }}</td>
                                                            <td>₹{{ number_format($item->total_price, 2) }}</td>
                                                            <td class="{{ $item->payment ? 'text-success' : 'text-muted' }}">
                                                                ₹{{ number_format($item->payment ? $item->payment->paid_amount : 0, 2) }}
                                                            </td>
                                                            <td class="{{ $item->payment && $item->payment->remaining_amount > 0 ? 'text-warning' : 'text-muted' }}">
                                                                ₹{{ number_format($item->payment ? $item->payment->remaining_amount : $item->total_price, 2) }}
                                                            </td>
                                                            <td>
                                                                @if($item->payment)
                                                                    <span class="badge badge-{{ $item->payment->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                                        {{ ucfirst($item->payment->payment_status) }}
                                                                    </span>
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
                                                        <td><strong>₹{{ number_format($purchaseItems->sum(function($item) { return $item->payment ? $item->payment->paid_amount : 0; }), 2) }}</strong></td>
                                                        <td><strong>₹{{ number_format($purchaseItems->sum(function($item) { return $item->payment ? $item->payment->remaining_amount : $item->total_price; }), 2) }}</strong></td>
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
                                                    <i class="fa fa-arrow-left"></i> Cancel
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
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .form-check {
        margin-bottom: 0;
    }
    .form-check-input {
        margin-top: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const deselectAllBtn = document.getElementById('deselectAllBtn');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const proceedBtn = document.getElementById('proceedBtn');
        const selectionSummary = document.getElementById('selectionSummary');
        const itemsForm = document.getElementById('itemsForm');

        // Function to update selection summary
        function updateSelectionSummary() {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked');
            let totalRemaining = 0;
            let selectedCount = selectedItems.length;
            let selectedItemsList = [];

            selectedItems.forEach(checkbox => {
                totalRemaining += parseFloat(checkbox.dataset.amount);
                selectedItemsList.push(checkbox.dataset.itemName);
            });

            if (selectedCount > 0) {
                selectionSummary.innerHTML = `
                    <strong>Selected Items:</strong> ${selectedCount}<br>
                    <strong>Total Remaining Amount:</strong> ₹${totalRemaining.toFixed(2)}
                    ${selectedCount <= 5 ? `<br><small class="text-muted">${selectedItemsList.join(', ')}</small>` : ''}
                `;
                proceedBtn.disabled = false;
                
                // Update select all checkbox state
                selectAllCheckbox.checked = selectedCount === itemCheckboxes.length;
                selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < itemCheckboxes.length;
            } else {
                selectionSummary.innerHTML = 'No items selected';
                proceedBtn.disabled = true;
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        }

        // Select All checkbox functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateSelectionSummary();
        });

        // Select All button functionality
        selectAllBtn.addEventListener('click', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
            updateSelectionSummary();
        });

        // Deselect All button functionality
        deselectAllBtn.addEventListener('click', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
            updateSelectionSummary();
        });

        // Individual checkbox change
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectionSummary);
            
            // Also make the entire row clickable
            const row = checkbox.closest('tr');
            if (row) {
                row.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        checkbox.checked = !checkbox.checked;
                        updateSelectionSummary();
                    }
                });
                
                // Add hover effect
                row.style.cursor = 'pointer';
            }
        });

        // Form submission validation
        itemsForm.addEventListener('submit', function(e) {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked');
            if (selectedItems.length === 0) {
                e.preventDefault();
                alert('Please select at least one item to proceed with payment.');
                return false;
            }
        });

        // Initial summary update
        updateSelectionSummary();

        // Add some visual feedback
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                if (this.checked) {
                    row.classList.add('table-success');
                } else {
                    row.classList.remove('table-success');
                }
            });
        });
    });
</script>
@endpush