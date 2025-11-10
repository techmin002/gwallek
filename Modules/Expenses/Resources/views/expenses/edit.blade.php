<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #fff;">
                <h1 class="modal-title fs-5">Edit Expenses</h1>
            </div>

            <form action="{{ route('expenses.update', $exp->id) }}" id="expenseForm{{ $exp->id }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            {{-- Title --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" type="text" name="title" value="{{ $exp->title }}"
                                    placeholder="Enter Title">
                            </div>

                            {{-- Expense Type --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Expense Type</label>
                                <select class="form-control" name="categoryId" required>
                                    <option value="" disabled>Select Expense Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $exp->expense_category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Branch --}}
                            @if (auth()->user()->access_type === 'Super Admin')
                                <div class="mt-3 col-lg-6">
                                    <label class="form-label12">Select Branch</label>
                                    <select class="form-control branchSelect" name="branchId" required>
                                        <option value="" disabled>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ $exp->branch_id == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
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
                                @if ($exp->receipt)
                                    <img src="{{ asset('upload/images/expenses-receipt/' . $exp->receipt) }}"
                                        style="width: 100px; margin-top: 5px;">
                                @endif
                            </div>

                            {{-- Mode of Payment --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control paymentMode" name="mode" required>
                                    <option value="" disabled>Select Payment Mode</option>
                                    <option value="cash" {{ $exp->mode == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ $exp->mode == 'online' ? 'selected' : '' }}>Online
                                    </option>
                                    <option value="cheque" {{ $exp->mode == 'cheque' ? 'selected' : '' }}>Cheque
                                    </option>
                                </select>
                            </div>

                            {{-- Bank Dropdown --}}
                            <div class="mt-3 col-lg-6 bankDiv" style="display: none;">
                                <label class="form-label12">Select Bank</label>
                                <select class="form-control bankSelect" name="bank_id">
                                    <option value="" disabled>Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" data-closing="{{ $bank->closing_amount }}"
                                            {{ $exp->bank_id == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->bank_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Amount --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Amount (NPR)</label>
                                <input class="form-control expenseAmount" type="number" name="amount"
                                    value="{{ $exp->amount }}" min="0" required>
                                <small class="text-muted d-block mt-1 maxAmountText">Maximum amount: -</small>
                            </div>

                            {{-- Date --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date" value="{{ $exp->date }}">
                            </div>

                            {{-- Description --}}
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control">{{ $exp->description }}</textarea>
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
        const modal = $('#editCategory{{ $exp->id }}');
        const branchSelect = modal.find('.branchSelect');
        const bankSelect = modal.find('.bankSelect');
        const paymentMode = modal.find('.paymentMode');
        const bankDiv = modal.find('.bankDiv');
        const amountInput = modal.find('.expenseAmount');
        const maxAmountText = modal.find('.maxAmountText');

        // Populate banks in dropdown
        function populateBanks(data, selectedBankId = null) {
            bankSelect.html('<option value="" disabled>Select Bank</option>');
            $.each(data, function(i, bank) {
                let selected = bank.id == selectedBankId ? 'selected' : '';
                bankSelect.append('<option value="' + bank.id + '" data-closing="' + (bank
                        .closing_amount ?? 0) + '" ' + selected + '>' + bank.bank_name +
                    '</option>');
            });
            updateMaxAmount();
        }

        // Load banks via AJAX
        function loadBanks(branchId, selectedBankId = null) {
            $.ajax({
                url: "{{ url('/get-banks') }}/" + branchId,
                method: 'GET',
                success: function(data) {
                    populateBanks(data, selectedBankId);
                },
                error: function() {
                    alert('Could not load banks for selected branch.');
                }
            });
        }

        // Update max amount based on selected bank
        function updateMaxAmount() {
            if (paymentMode.val() === 'online' || paymentMode.val() === 'cheque') {
                const closing = parseFloat(bankSelect.find(':selected').data('closing')) || 0;
                amountInput.attr('max', closing);
                maxAmountText.text('Maximum amount: ' + closing);
            }
        }

        // Toggle bank div and max amount
        function toggleBankDiv() {
            const mode = paymentMode.val();

            if (mode === 'online' || mode === 'cheque') {
                bankDiv.show();
                @if (auth()->user()->access_type === 'Super Admin')
                    const branchId = branchSelect.val();
                    if (branchId) loadBanks(branchId, '{{ $exp->bank_id }}');
                @else
                    loadBanks('{{ auth()->user()->branch_id }}', '{{ $exp->bank_id }}');
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
                    },
                    error: function() {
                        maxAmountText.text('Maximum amount: -');
                    }
                });
            } else {
                bankDiv.hide();
                amountInput.removeAttr('max');
                maxAmountText.text('Maximum amount: -');
            }
        }

        // Event listeners
        paymentMode.change(toggleBankDiv);
        branchSelect.change(function() {
            if (paymentMode.val() === 'online' || paymentMode.val() === 'cheque') {
                loadBanks($(this).val());
            }
        });
        bankSelect.change(updateMaxAmount);

        // Initial load
        toggleBankDiv();
    });
</script>
