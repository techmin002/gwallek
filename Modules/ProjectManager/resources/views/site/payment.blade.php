{{-- Payment Field --}}
<div class="col-md-12">
    <div class="card card-secondary">
        <div class="card-header bg-info">
            <h3 class="card-title">Payment Field</h3>
        </div>
        <div class="card-body">
            <div class="row">
<div class="col-md-6"> <div class="form-group"> <label for="amount">Cost Amount</label> <input type="number" name="amount" class="form-control" value="{{ old('amount') }}"> @error('amount') <p style="color:red">{{ $message }}</p> @enderror </div> </div>
                {{-- Paid Amount --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="paid_amount">Paid Amount</label>
                        <input type="number" name="paid_amount" class="form-control"
                            value="{{ old('paid_amount') }}">
                        @error('paid_amount')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque</option>
                            <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                        @error('payment_method')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
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

                {{-- Receipt Image --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="online_image">Upload Receipt</label>
                        <input type="file" name="online_image" class="form-control-file" accept="image/*">
                        @error('online_image')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Optional JS to show/hide check_number --}}
@push('scripts')
<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        let checkDiv = document.getElementById('check_number_div');
        if (this.value === 'check') {
            checkDiv.style.display = 'block';
        } else {
            checkDiv.style.display = 'none';
        }
    });
</script>
@endpush
