<div class="modal fade" id="createBankModal" tabindex="-1" role="dialog" aria-labelledby="createBankModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center"
                style="background: linear-gradient(90deg, #1E90FF 60%, #0056b3 100%); color:#fff;">
                <h3 class="modal-title fw-bold">Create Bank</h3>
            </div>

            <form action="{{ route('banks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row gy-3">

                        <!-- Bank Name -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Enter bank name"
                                required>
                        </div>

                        <!-- Bank Holder Name -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Bank Holder Name</label>
                            <input type="text" name="bank_holder_name" class="form-control"
                                placeholder="Enter account holder name" required>
                        </div>

                        <!-- Account Number -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Account Number</label>
                            <input type="text" name="account_number" class="form-control"
                                placeholder="Enter account number" required>
                        </div>

                        <!-- Branch -->
                        <!-- Branch -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Branch</label>

                            @if (auth()->user()->access_type === 'Super Admin')
                                {{-- Super Admin ko dropdown milega --}}
                                <select name="branch_id" class="form-control">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                {{-- Normal user ke liye uska branch fix hoga --}}
                                <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                <input type="text" class="form-control"
                                    value="{{ auth()->user()->branch->name ?? 'N/A' }}" disabled>
                            @endif
                        </div>



                        <!-- Mobile No -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Mobile Number</label>
                            <input type="text" name="mobile_no" class="form-control"
                                placeholder="Enter mobile number">
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter bank address">
                        </div>

                        <!-- Opening Amount -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Opening Amount</label>
                            <input type="number" step="0.01" name="opening_amount" class="form-control"
                                placeholder="Enter opening balance" required>
                        </div>

                        <!-- Closing Amount -->
                        {{-- <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Closing Amount</label>
                            <input type="number" step="0.01" name="closing_amount" class="form-control"
                                placeholder="Enter closing balance" required>
                        </div> --}}

                        <!-- Status -->
                        <div class="col-md-12 mt-3">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Status</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="status" value="on">
                                    <input type="checkbox" name="status" value="on" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success px-5">Save Bank</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
