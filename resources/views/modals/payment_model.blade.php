<div class="modal fade" id="paymentModal{{ $reading->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $payment->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel{{ $reading->id }}">Make Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <span id="" class="error-card mx-5 mt-2"></span>
        <div class="modal-body">
       
          <form action="{{ route('readings.update', $reading->id) }}" method="POST">
            @csrf
            @method('PUT')
           
           
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