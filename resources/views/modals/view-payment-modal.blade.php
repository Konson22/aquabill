<div class="modal fade" id="viewPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="viewPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewPaymentModalLabel{{ $payment->id }}">Serial No: <span class="text-danger">
          #{{ date("dm", strtotime($payment->date)) }}{{ $payment->id }}</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-sm">
          <tr>
            <td>Customer name:</td>
            <td>{{$payment->customer->first_name}} {{$payment->customer->last_name}}</td>
          </tr>
          <tr>
            <td>Previous Reading:</td>
            <td>{{$payment->reading->previous}}</td>
          </tr>
          <tr>
            <td>Current Reading:</td>
            <td>{{$payment->reading->value}}</td>
          </tr>
          <tr>
            <td>Consumtion:</td>
            <td>{{$payment->reading->value - $payment->reading->previous}} M³</td>
          </tr>
          <tr>
            <td>Volumetric Charges:</td>
            <td>{{($payment->reading->value - $payment->reading->previous) * $payment->tariff}} SSP</td>
          </tr>
          <tr>
            <td>Charges:</td>
            <td>{{ $payment->charges ?? 'No data' }} SSP</td>
          </tr>
          <tr>
            <td>Total bill:</td>
            <td>{{ $payment->amount + $payment->charges ?? 'No data' }} SSP</td>
          </tr>
          <tr>
            <td>Amount paid:</td>
            <td>{{ $payment->paid ?? 'No data' }} SSP</td>
          </tr>
        
        </table>
        {{-- <div class="row g-4">
         
         
        </div>
        <div class="row g-4">
          <div class="col mb-2">
            <label for="paid" class="form-label"><b>Amount Paid</b></label>
            <div class="form-control-plaintext">{{ $payment->paid ?? 'No data' }}</div>
          </div>
          <div class="col mb-2">
            <label for="remaining" class="form-label"><b>Remaining</b></label>
            <div class="form-control-plaintext">{{ $payment->remaining ?? 'No data' }}</div>
          </div>
          <!-- Charges -->
          <div class="col mb-2">
            <label for="charges" class="form-label"><b>Charges</b></label>
            <div class="form-control-plaintext"></div>
          </div>
        </div>
        <div class="row g-4">
          <div class="col mb-2">
            <label for="method" class="form-label"><b>Current Reading</b></label>
            <div class="form-control-plaintext">{{ $payment->reading->value ?? 'No data' }}</div>
          </div>
          <div class="col mb-2">
            <label for="tariff" class="form-label"><b>Previous Reading</b></label>
            <div class="form-control-plaintext">{{ $payment->reading->previous ?? 'No data' }}</div>
          </div>
          <div class="col mb-2">
            <label for="date" class="form-label"><b>Reading Date</b></label>
            <div class="form-control-plaintext">
              {{ $payment->reading ? date("F d, Y", strtotime($payment->reading->date)) : 'No data' }}</div>
            </div>
          </div>
          <div class="row g-4">
            <div class="col mb-2">
              <label for="method" class="form-label"><b>Method</b></label>
              <div class="form-control-plaintext">{{ $payment->method ?? 'No data' }}</div>
            </div>

            <div class="col mb-2">
              <label for="tariff" class="form-label"><b>Tariff</b></label>
              <div class="form-control-plaintext">{{ $payment->tariff ?? 'No data' }}</div>
            </div>
            <div class="col mb-2">
              <label for="date" class="form-label"><b>Invoice Date</b></label>
              <div class="form-control-plaintext">{{ date("F d, Y", strtotime($payment->date)) ?? 'No data' }}</div>
            </div>
          </div>
        </div> --}}
      </div>
      </div>
    </div>
  </div>