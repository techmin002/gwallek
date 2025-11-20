 <div class="col-sm-6 text-right">
                        @if($payment->invoice)
                            <a href="{{ route('payments.download-bill', $payment->invoice->id) }}" class="btn btn-success">
                                <i class="fa fa-download"></i> Download Bill
                            </a>
                        @else
                            <button type="button" class="btn btn-warning generate-bill-btn" data-payment-id="{{ $payment->id }}">
                                <i class="fa fa-file-invoice"></i> Generate Bill
                            </button>
                        @endif
                        <a href="{{ route('payments.select-project') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Back to Payments
                        </a>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate bill button click
        document.querySelectorAll('.generate-bill-btn').forEach(button => {
            button.addEventListener('click', function() {
                const paymentId = this.dataset.paymentId;
                generateBill(paymentId);
            });
        });

        function generateBill(paymentId) {
            Swal.fire({
                title: 'Generate Bill?',
                text: 'Do you want to generate a bill for this payment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Generate Bill',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/payments/${paymentId}/generate-bill`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Bill generated successfully!',
                        icon: 'success',
                        confirmButtonText: 'Download Bill'
                    }).then(() => {
                        // Redirect to download the bill
                        window.location.href = `/payments/bill/${result.value.invoice_id}/download`;
                    });
                }
            });
        }
    });
</script>