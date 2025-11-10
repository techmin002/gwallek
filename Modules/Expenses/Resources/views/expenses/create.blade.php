<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5">Add Expenses </h1>
            </div>

            <form action="{{ route('expenses.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title" type="text" name="title"
                                    id="title">
                            </div>

                            {{-- Expense Type --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Expense Type</label>
                                <select class="form-control" name="categoryId" required>
                                    <option value="" selected disabled>Select Expense Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Branch Selection --}}
                            @if (auth()->user()->access_type === 'Super Admin')
                                <div class="mt-3 col-lg-6">
                                    <label class="form-label12">Select Branch</label>
                                    <select class="form-control" name="branchId" id="branchSelect" required>
                                        <option value="" selected disabled>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="branchId" value="{{ auth()->user()->branch_id }}">
                            @endif

                            {{-- Receipt --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Receipt <small>(Optional)</small></label>
                                <input type="file" class="form-control" name="receipt">
                            </div>


                            {{-- Mode of Payment --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control" name="mode" id="paymentMode" required>
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>


                            {{-- Bank Dropdown (hidden initially) --}}
                            <div class="mt-3 col-lg-6" id="bankDiv" style="display: none;">
                                <label class="form-label12">Select Bank</label>
                                <select class="form-control" name="bank_id" id="bankSelect">
                                    <option value="" selected disabled>Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>

                            </div>


                            {{-- Amount Field --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Amount (NPR)</label>
                                <input class="form-control" placeholder="Enter Amount" type="number" name="amount"
                                    id="expenseAmount" required min="0">
                                <small id="maxAmountText" class="text-muted d-block mt-1">Maximum amount: -</small>
                            </div>

                             <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date">
                            </div>

                            {{-- Description --}}
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Save Item</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const branchSelect = $('#branchSelect');
        const bankSelect = $('#bankSelect');
        const paymentMode = $('#paymentMode');
        const bankDiv = $('#bankDiv');
        const amountInput = $('#expenseAmount');
        const maxAmountText = $('#maxAmountText');

        // Banks ko populate karna
        function populateBanks(data) {
            bankSelect.html('<option value="" selected disabled>Select Bank</option>');
            $.each(data, function(i, bank) {
                bankSelect.append(
                    '<option value="' + bank.id + '" data-closing="' + (bank.closing_amount ?? 0) +
                    '">' +
                    bank.bank_name +
                    '</option>'
                );
            });
            amountInput.val('');
            amountInput.removeAttr('max');
            maxAmountText.text('Maximum amount: -');
        }

        // ✅ Branch select hone par banks load karo (Super Admin only)
        branchSelect.change(function() {
            let branchId = $(this).val();
            if (branchId) {
                $.ajax({
                    url: "{{ url('/get-banks') }}/" + branchId,
                    method: 'GET',
                    success: function(data) {
                        populateBanks(data);
                    },
                    error: function() {
                        alert('Could not load banks for selected branch.');
                    }
                });
            }
        });

        // ✅ Payment mode change hone par
        paymentMode.change(function() {
            const mode = $(this).val();

            if (mode === 'online' || mode === 'cheque') {
                bankDiv.show();

                // Agar Super Admin hai to branch select check karo
                @if (auth()->user()->access_type === 'Super Admin')
                    let branchId = branchSelect.val();
                    if (branchId) {
                        $.ajax({
                            url: "{{ url('/get-banks') }}/" + branchId,
                            method: 'GET',
                            success: function(data) {
                                populateBanks(data);
                            },
                            error: function() {
                                alert('Could not load banks for selected branch.');
                            }
                        });
                    }
                @endif

            } else if (mode === 'cash') {
                bankDiv.hide();
                $.ajax({
                    url: "{{ url('/get-cash-counter') }}",
                    method: 'GET',
                    success: function(data) {
                        const due = data.due_amount ?? 0;
                        amountInput.attr('max', due);
                        maxAmountText.text('Maximum amount: ' + due);
                        amountInput.val('');
                    }
                });
            } else {
                bankDiv.hide();
                amountInput.removeAttr('max');
                maxAmountText.text('Maximum amount: -');
            }
        });

        // ✅ Bank select hone par max closing amount set karo
        bankSelect.change(function() {
            const closingAmount = parseFloat($(this).find(':selected').data('closing')) || 0;
            amountInput.attr('max', closingAmount);
            maxAmountText.text('Maximum amount: ' + closingAmount);
            amountInput.val('');
        });

        // ✅ Normal user ke liye banks auto-load
        @if (auth()->user()->access_type !== 'Super Admin')
            $.ajax({
                url: "{{ url('/get-banks') }}/{{ auth()->user()->branch_id }}",
                method: 'GET',
                success: function(data) {
                    populateBanks(data);
                }
            });
        @endif
    });
</script>
