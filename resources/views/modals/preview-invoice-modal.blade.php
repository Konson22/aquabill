<div class="modal fade" id="previewInvoice{{ $payment->id }}" tabindex="-1" aria-labelledby="previewInvoiceLabel{{ $payment->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="previewInvoiceLabel{{ $payment->id }}">Invoice #{{ $payment->id ?? 'No data'}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         
        </div>
      </div>
    </div>