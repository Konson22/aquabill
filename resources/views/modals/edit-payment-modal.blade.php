<div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Make Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <span id="" class="error-card mx-5 mt-2"></span>
      <div class="modal-body">
        <!-- Payments Update -->
        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
          @csrf
          @method('PUT')
          <!-- Hidden fields -->
          <input type="hidden" name="customer_id" value="{{ $payment->customer_id }}">
          <input type="hidden" name="reading_id" value="{{ $payment->reading_id }}">

          <!-- Status -->
          <div class="col mb-2 form-check ">
            <input class="form-check-input" type="checkbox" id="status" name="status" value="Paid" {{ $payment->status == 'Paid' ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Paid</label>
          </div>
          <div class="row g-4">
            <!-- Method -->
            <div class="col mb-2">
              <label for="method" class="form-label">Method</label>
              <select class="form-select" id="method" name="method" required>
                <option value="cash" {{ $payment->method == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="credit_card" {{ $payment->method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                <option value="bank_transfer" {{ $payment->method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="mobile_payment" {{ $payment->method == 'mobile_payment' ? 'selected' : '' }}>Mobile Payment</option>
                <option value="check" {{ $payment->method == 'check' ? 'selected' : '' }}>Check</option>
              </select>
            </div>

            <!-- Tariff -->
            <div class="col mb-2">
              <label for="tariff" class="form-label">Tariff</label>
              <input type="number" class="form-control" id="tariff" name="tariff" value="{{ $payment->tariff }}" readonly>
            </div>
             <!-- Charges -->
             <div class="col mb-2">
              <label for="charges" class="form-label">Charges</label>
              <input type="number" class="form-control" id="charges" name="charges" value="{{ $payment->charges }}" required>
            </div>
          </div>
          <div class="row g-4">
            <!-- Paid -->
            <div class="col mb-2">
              <label for="paid" class="form-label">Paid</label>
              <input type="number" class="form-control paid" id="paid" name="paid" required>
            </div>
            <!-- Remaining -->
            <div class="col mb-2">
              <label for="remaining" class="form-label">Remaining</label>
              <input type="text" hidden class="form-control oldBalance" id="oldBalance" value="{{ $payment->remaining }}" readonly>
              <input type="text" class="form-control remaining" id="remaining" name="remaining" value="{{ $payment->remaining }}" readonly>
            </div>
            <!-- Date -->
            <div class="col mb-2">
              <label for="date" class="form-label">Reading Date</label>
              <input type="date" class="form-control" id="date" name="date" value="{{ $payment->date }}" required>
            </div>
          </div>
         
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    
    const paidInput = document.querySelector('.paid')
    const oldBalance = document.querySelector('.oldBalance')
    const remainingInput = document.querySelector('.remaining')
    const errorCard = document.querySelector('.error-card')
  
    paidInput.addEventListener('input', (e) => {
      const paid = parseInt(e.target.value)
      const balance = parseInt(oldBalance.value)
      const newBalance = balance - paid

      if(isNaN(paid)){
        remainingInput.value = balance
        return
      }
      if(paid > balance){
        errorCard.textContent = 'paid must be greater then balance'
        errorCard.classList.add('text-danger')
        return 
      }
      errorCard.textContent = null
      console.log('gooood')
      remainingInput.value = newBalance
    })

    
  })
  </script>