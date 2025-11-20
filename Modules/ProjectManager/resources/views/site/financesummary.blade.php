 <!-- Financial Summary Cards -->
                <div class="row mb-3">
                    <!-- Project Cost -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h5>Project Cost</h5>
                                <h3>{{ number_format($totalCost, 2) }}</h3>
                                <small>From Sites Table</small>
                            </div>
                        </div>
                    </div>

                    <!-- Total Income -->
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h5>Total Income</h5>
                                <h3>{{ number_format($totalIncome, 2) }}</h3>
                                <small>From Incomes Table</small>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Cost -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body text-center">
                                <h5>Purchase Cost</h5>
                                <h3>{{ number_format($totalPurchaseCost, 2) }}</h3>
                                <small>From Purchase Items</small>
                            </div>
                        </div>
                    </div>

                    <!-- Total Payments -->
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h5>Total Payments</h5>
                                <h3>{{ number_format($totalPayments, 2) }}</h3>
                                <small>From Payments Table</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Summary -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card {{ $totalCost == $totalIncome ? 'bg-success' : 'bg-danger' }} text-white">
                            <div class="card-body text-center">
                                <h5>Project Balance</h5>
                                <h3>{{ number_format($totalCost - $totalIncome, 2) }}</h3>
                                <p>
                                    @if($totalCost == $totalIncome)
                                        ✅ Balanced: Cost = Income
                                    @else
                                        ⚠️ Unbalanced: Cost ≠ Income
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card {{ $totalPurchaseCost == $totalPayments ? 'bg-success' : 'bg-danger' }} text-white">
                            <div class="card-body text-center">
                                <h5>Purchase Balance</h5>
                                <h3>{{ number_format($totalPurchaseCost - $totalPayments, 2) }}</h3>
                                <p>
                                    @if($totalPurchaseCost == $totalPayments)
                                        ✅ Balanced: Purchase Cost = Payments
                                    @else
                                        ⚠️ Unbalanced: Purchase Cost ≠ Payments
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>