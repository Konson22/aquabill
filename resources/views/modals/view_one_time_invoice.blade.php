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
              <td>Description:</td>
              <td>{{ $payment->description ?? 'No data' }}</td>
            </tr>
            <tr>
              <td>Total Bill:</td>
              <td>{{ $payment->amount ?? 'No data' }} SSP</td>
            </tr>
            <tr>
              <td>Issue Date:</td>
              <td>{{ $payment->date ?? 'No data' }} SSP</td>
            </tr>
           
          </table>
         
        </div>
        </div>
      </div>
    </div>