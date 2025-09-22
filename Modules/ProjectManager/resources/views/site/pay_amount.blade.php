@extends('setting::layouts.master')

@section('title', 'Pay Amount')

@section('content')
    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid mb-3">
                <h1 class="h3">Pay Amount for: <strong>{{ $site->title }}</strong></h1>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h4 class="card-title mb-0">Enter Payment Details</h4>
                            </div>

                            <form action="{{ route('paymentdetails.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="site_id" value="{{ $site->id }}">
                                {{-- Payment Field --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="paid_amount">Paid Amount</label>
                                                <input type="number" name="paid_amount" id="paid_amount"
                                                    class="form-control" value="{{ old('paid_amount') }}"
                                                    max="{{ $totalDue }}">
                                                <small class="text-muted">Maximum payable: {{ $totalDue }}</small>
                                                <p id="paid_amount_error" style="color:red; margin-top:5px;"></p>
                                                @error('paid_amount')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_method">Payment Method</label>
                                                <select name="payment_method" id="payment_method" class="form-control">
                                                    <option value="">Select Payment Method</option>
                                                    <option value="cash"
                                                        {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                                                        Cash</option>
                                                    <option value="check"
                                                        {{ old('payment_method') == 'check' ? 'selected' : '' }}>
                                                        Cheque</option>
                                                    <option value="online"
                                                        {{ old('payment_method') == 'online' ? 'selected' : '' }}>
                                                        Online</option>
                                                </select>
                                                @error('payment_method')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Payment Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">Payment Date</label>
                                            <input type="date" name="date" class="form-control"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        {{-- Check Number --}}
                                        <div class="col-md-6" id="check_number_div" style="display:none;">
                                            <div class="form-group">
                                                <label for="check_number">Cheque Number</label>
                                                <input type="text" name="check_number" class="form-control"
                                                    value="{{ old('check_number') }}">
                                                @error('check_number')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Online Payment Image --}}
                                        <div class="col-md-6" id="online_image_div" style="display:none;">
                                            <div class="form-group">
                                                <label for="online_image">Upload Online Payment
                                                    Proof</label>
                                                <input type="file" name="online_image" class="form-control-file"
                                                    accept="image/*">
                                                @error('online_image')
                                                    <p style="color:red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Pay</button>
                                    <a href="{{ route('paymentdetails.index', $site->id) }}"
                                        class="btn btn-secondary">Back</a>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
        $(document).ready(function() {
            var totalDue = {{ $totalDue }};

            $('#paid_amount').on('input', function() {
                var val = parseFloat($(this).val());
                var errorField = $('#paid_amount_error');

                if (val > totalDue) {
                    errorField.text('Paid amount cannot exceed total due: ' + totalDue);
                    $(this).val(totalDue);
                } else if (val < 0) {
                    $(this).val(0);
                    errorField.text('');
                } else {
                    errorField.text('');
                }
            });

            function togglePaymentFields() {
                var method = $('#payment_method').val();
                if (method === 'check') {
                    $('#check_number_div').show();
                    $('#online_image_div').hide();
                } else if (method === 'online') {
                    $('#online_image_div').show();
                    $('#check_number_div').hide();
                } else {
                    $('#check_number_div').hide();
                    $('#online_image_div').hide();
                }
            }

            $('#payment_method').change(togglePaymentFields);
            togglePaymentFields();
        });
    </script>


@endsection
