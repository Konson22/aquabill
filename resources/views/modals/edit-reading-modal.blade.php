<div class="modal fade" id="editReadingModal{{ $reading->id }}" tabindex="-1" aria-labelledby="editReadingModalLabel{{ $reading->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editReadingModalLabel{{ $reading->id }}">Edit Meter Reading</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('reading.update', $reading->id) }}" method="POST">
          @csrf
          <div class="error_container"></div>
          <div class="row g-4">
            <div class="col mb-2">
              <label for="value" class="form-label">Current Reading</label>
              <input type="number" class="form-control value" id="value" name="value" value="{{ $reading->value }}" required>
            </div>
            <div class="col mb-2">
              <label for="previous" class="form-label">Previous Reading</label>
              <input type="text" class="input form-control previous" id="previous" name="previous" value="{{ $reading->previous }}" required>
            </div>
          </div>
          <div class="mb-2">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="input form-control" id="date" name="date" value="{{ $reading->date }}">
          </div>
          <div class="modal-footer mt-4">
            <button type="button" class="btn-secondary btn" data-bs-dismiss="modal" aria-label="Close">
              Close
            </button>
            <button type="submit" id="" class="addReadingButton btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
  document.addEventListener('DOMContentLoaded', () => {
    const previousVal2 = document.querySelector('.previous');
    const currentValue = document.querySelector('.value');
    const addReadingButton = document.querySelector('.addReadingButton');
    const errorContainer = document.querySelector('.error_container');
  
    previousVal2.addEventListener('input', (e) => {    
      const previousReading = parseInt(e.target.value)
      const currentReading = parseInt(currentValue.value)
      validateInputs(currentReading < previousReading)
      validateInputs(currentReading < previousReading)
    });
  
    currentValue.addEventListener('input', (e) => {    
      const currentReading = parseInt(e.target.value)
      const previousReading = parseInt(previous.value)
      validateInputs(currentReading < previousReading)
    });
  
    const  validateInputs = (isTrue) =>{
      if(isTrue){
        errorContainer.className = 'text-danger'
        errorContainer.innerText = `Current Reading Must be Greater then Previouse Reading`
        addReadingButton.disabled = true
      }else{
        errorContainer.className = ''
        errorContainer.innerText = ``
        addReadingButton.disabled = false
      }
    }
  })
</script>