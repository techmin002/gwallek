@extends('setting::layouts.master')

@section('title', 'Payment Details')

@section('content')
    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1>{{ $site->title }} - Payment Details</h1>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Top Cards: Paid & Due Amount -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h4>Total Amount: {{ $totalAmount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h4>Total Paid Amount: {{ $totalPaid }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h4>Total Due Amount: {{ $totalDue }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pay Amount Button -->
                <div class="mb-3">
                    <a href="" class="btn btn-info" data-toggle="modal" data-target="#payAmountModal">
                        <i class="fa fa-plus"></i> Pay Amount
                    </a>
                    <div class="modal fade " id="payAmountModal" tabindex="-1" role="dialog"
                        aria-labelledby="payAmountModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('paymentdetails.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="site_id" value="{{ $site->id }}">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Pay Amount</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Paid Amount --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="paid_amount">Paid Amount</label>
                                                    <input type="number" name="paid_amount" id="paid_amount"
                                                        class="form-control" value="{{ old('paid_amount') }}"
                                                        max="{{ $totalDue }}">
                                                    <small class="text-muted">Maximum payable: {{ $totalDue }}</small>
                                                    @error('paid_amount')
                                                        <p style="color:red; margin-top:5px;">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Payment Method --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="payment_method">Payment Method</label>
                                                    <select name="payment_method" id="payment_method" class="form-control">
                                                        <option value="">Select Payment Method</option>
                                                        <option value="cash"
                                                            {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                                        </option>
                                                        <option value="check"
                                                            {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque
                                                        </option>
                                                        <option value="online"
                                                            {{ old('payment_method') == 'online' ? 'selected' : '' }}>
                                                            Online</option>
                                                    </select>
                                                    @error('payment_method')
                                                        <p style="color:red; margin-top:5px;">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Payment Date --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="date" class="form-label">Payment Date</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ old('date', date('Y-m-d')) }}" required>
                                                @error('date')
                                                    <p style="color:red; margin-top:5px;">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- Check Number --}}
                                            <div class="col-md-6" id="check_number_div" style="display:none;">
                                                <div class="form-group">
                                                    <label for="check_number">Cheque Number</label>
                                                    <input type="text" name="check_number" class="form-control"
                                                        value="{{ old('check_number') }}">
                                                    @error('check_number')
                                                        <p style="color:red; margin-top:5px;">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Online Payment Image --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="online_image">Upload Receipt</label>
                                                    <input type="file" name="online_image" class="form-control-file"
                                                        required accept="image/*">
                                                    @error('online_image')
                                                        <p style="color:red; margin-top:5px;">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Pay</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Table -->
                <div class="card mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>S.R</th>
                                    <th>Paid Amount</th>
                                    <th>Payment Method</th>
                                    <th>Cheque Number</th>
                                    <th>Online Receipt</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($site->paymentDetails as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->amount }}</td>
                                        <td>{{ ucfirst($detail->payment_method) }}</td>
                                        <td>{{ $detail->check_number ?? '-' }}</td>
                                        <td>
                                            {{-- <img src="{{ asset('upload/images/Payment/' . $detail->online_image) }}"
                                                    width="80"> --}}
                                            <a href="{{ asset('upload/images/Payment/' . $detail->online_image) }}"
                                                target="_blank" alt="">View Receipt</a>
                                        </td>
                                        <td>{{ $detail->date }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No payment details found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('sites.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>

                </div>

            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentSelect = document.getElementById('payment_method');
            const checkDiv = document.getElementById('check_number_div');

            // Initial check on page load (if old value exists)
            const oldPayment = paymentSelect.value;
            checkDiv.style.display = oldPayment === 'check' ? 'block' : 'none';

            // On change
            paymentSelect.addEventListener('change', function() {
                if (this.value === 'check') {
                    checkDiv.style.display = 'block';
                    onlineDiv.style.display = 'none';
                } else {
                    checkDiv.style.display = 'none';
                    onlineDiv.style.display = 'none';
                }
            });
        });
    </script>

@endsection
