@extends('setting::layouts.master')

@section('title', 'Cash Counter')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Cash Counter</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cash Counter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Cash Counter</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title float-left">
                                {{-- <a href="{{ route('finance.cashdetails') }}" class="btn btn-info text-white">Cash
                                            Details
                                        </a> --}}
                                {{-- <a href="{{ route('expense.cashdetails') }}" class="btn btn-info text-white">
                                            Expense Details
                                        </a> --}}
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <h3 class="card-title float-right">
                                <!-- Deposit Button -->
                                {{-- <a href="{{ route('finance.depositedetails') }}" class="btn btn-info text-white">
                                    Deposit Details
                                </a> --}}
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#depositModal">
                                    Deposit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="depositModal" tabindex="-1" role="dialog"
                                    aria-labelledby="depositModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('cash.deposite') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h4 class="modal-title ">Deposit Amount</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body text-left">
                                                    <div class="form-group">
                                                        <label>Amount</label>
                                                        <input type="number" name="amount" id="amount"
                                                            class="form-control" value="{{ old('amount') }}" min="1"
                                                            max="{{ $counter->due_amount ?? '' }}" required>
                                                        <small class="text-muted">Maximum payable:
                                                            {{ $counter->due_amount ?? '' }}</small>
                                                        <p id="amount_error" style="color:red; margin-top:5px;"></p>
                                                        @error('amount')
                                                            <p style="color:red">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <!-- Payment Method -->
                                                    <!-- Branch -->
                                                    @if (auth()->user()->access_type === 'Super Admin')
                                                        <div class="form-group">
                                                            <label>Select Branch</label>
                                                            <select name="branch_id" id="branch_id" class="form-control"
                                                                required>
                                                                <option value="" selected disabled>-- Select
                                                                    Branch --</option>
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->id }}">
                                                                        {{ $branch->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="branch_id"
                                                            value="{{ auth()->user()->branch_id }}">
                                                    @endif

                                                    <!-- Bank -->
                                                    <div class="form-group">
                                                        <label>Select Bank</label>
                                                        <select name="bank_id" id="bank_id" class="form-control" required>
                                                            <option value="" selected disabled>-- Select Bank
                                                                --</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">
                                                                    {{ $bank->bank_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input type="date" name="date" class="form-control"
                                                                    required>
                                                            </div>
                                                            @error('date')
                                                                <p style="color:red">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload Receipt <small
                                                                        class="text-muted">(optional)</small></label>
                                                                <input type="file" name="image" class="form-control"
                                                                    accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Deposit</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h4>Total Opening Amount: {{ number_format($counter->opening_amount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h4>Total Reduce Amount: {{ number_format($counter->reduce_amount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h4>Total Remaining Amount: {{ number_format($counter->due_amount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h4>Today Deposit: {{ $todayCollection }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h4>Total Deposit: {{ $grandTotal }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deposits Table -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h4>Deposite Details</h4>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>S.N</th>
                                    <th>Bank Name</th>
                                    <th>Branch Name</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($data as $out)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $out->bank->bank_name ?? 'N/A' }}</td>
                                        <td>{{ $out->branch->name ?? 'N/A' }}</td>
                                        <td>{{ $out->date ?? 'N/A' }}</td>
                                        <td>{{ $out->amount ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ asset('upload/images/deposits/' . $out->image) }}"
                                                target="_blank">View Receipt</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No deposit data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th colspan="4">Grand Total</th>
                                    <th colspan="2">{{ number_format($grandTotal, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('cash-counter.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <!-- Expenses Table -->
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4>Reduce Expenses Amount From Cash Counter</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($expenses as $expense)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expense->date ?? 'N/A' }}</td>
                                        <td>{{ $expense->title ?? 'N/A' }}</td>
                                        <td>{{ $expense->category->title ?? 'N/A' }}</td>
                                        <td>{{ $expense->description ?? '-' }}</td>
                                        <td>{{ $expense->amount ?? 'N/A' }}</td>
                                        <td>
                                            @if ($expense->receipt)
                                                <a href="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}"
                                                    target="_blank">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No expense data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th colspan="5">Total Expense</th>
                                    <th colspan="2">{{ number_format($expenses->sum('amount'), 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $('#branch_id').change(function() {
            let branchId = $(this).val();
            $.ajax({
                url: '/get-banks/' + branchId,
                method: 'GET',
                success: function(data) {
                    $('#bank_id').html('<option value="" selected disabled>-- Select Bank --</option>');
                    data.forEach(function(bank) {
                        $('#bank_id').append('<option value="' + bank.id + '">' + bank
                            .bank_name + '</option>');
                    });
                }
            });
        });
    </script>
@endsection
