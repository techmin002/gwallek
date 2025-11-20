@extends('setting::layouts.master')

@section('title', 'Payment Details')

@section('content')
    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1>{{ $site->name ?? 'N/A' }} - Payment Details</h1>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

               @include("projectmanager::site.financesummary")

                <!-- Income History Section (Since you don't have paymentDetails) -->
                <div class="row">
                    <div class="col-12">
                        <!-- Add Income Button -->
                        <div class="mb-3">
    <a href="" class="btn btn-info" data-toggle="modal" data-target="#payAmountModal">
        <i class="fa fa-plus"></i> Add Income
    </a>
</div>

                        <!-- Income History Table -->
                        <div class="card mt-3">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-striped text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.R</th>
                                            <th>Title</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>Receipt</th>
                                            <th>Date</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $incomes = $site->incomes ?? collect();
                                        @endphp
                                        
                                        @forelse($incomes as $income)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $income->title }}</td>
                                                <td>{{ number_format($income->amount, 2) }}</td>
                                                <td>{{ ucfirst($income->payment_method) }}</td>
                                                <td>
                                                    @if($income->receipt_image)
                                                        <a href="{{ asset('uploads/receipts/' . $income->receipt_image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            View Receipt
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $income->received_date }}</td>
                                                <td>{{ $income->note ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No income records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Pay Amount Modal -->
   <!-- Pay Amount Modal -->
<div class="modal fade" id="payAmountModal" tabindex="-1" role="dialog" aria-labelledby="payAmountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Add Income</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Project (Hidden since we're on specific project page) -->
                        <input type="hidden" name="site_id" value="{{ $site->id }}">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Project <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" value="{{ $site->name }}" readonly>
                            <small class="text-muted">This income will be recorded for {{ $site->name }}</small>
                        </div>

                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Enter income title" value="{{ old('title', 'Payment Received') }}" required>
                            @error('title')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                            @error('amount')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Received Date <span class="text-danger">*</span></label>
                            <input type="date" name="received_date" class="form-control" value="{{ old('received_date', date('Y-m-d')) }}" required>
                            @error('received_date')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-control" id="payment_method" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet (eSewa, Khalti)</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cheque Number (Conditional) -->
                        <div class="col-md-6 mb-3" id="cheque_number_div" style="display:none;">
                            <label class="form-label">Cheque Number <span class="text-danger">*</span></label>
                            <input type="text" name="cheque_number" class="form-control" placeholder="Enter cheque number" value="{{ old('cheque_number') }}">
                            @error('cheque_number')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Receipt Image -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receipt Image (optional)</label>
                            <input type="file" name="receipt_image" class="form-control" accept="image/*">
                            @error('receipt_image')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Note</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Add any additional notes...">{{ old('note') }}</textarea>
                            @error('note')
                                <p style="color:red; margin-top:5px;">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Save Income
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.getElementById('payment_method');
        const chequeNumberDiv = document.getElementById('cheque_number_div');

        function togglePaymentFields() {
            const method = paymentMethod.value;
            
            // Show cheque number field only for cheque payment
            if (method === 'cheque') {
                chequeNumberDiv.style.display = 'block';
                // Make cheque number required
                document.querySelector('[name="cheque_number"]').required = true;
            } else {
                chequeNumberDiv.style.display = 'none';
                // Remove required attribute
                document.querySelector('[name="cheque_number"]').required = false;
            }
        }

        // Initial check
        togglePaymentFields();

        // On change event
        paymentMethod.addEventListener('change', togglePaymentFields);
    });
</script>
@endsection