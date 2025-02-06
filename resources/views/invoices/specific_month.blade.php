@php
  use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Invoices')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/jquery/jquery.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
])
@endsection
<style>
  .dataTables_filter input{
    width: 300px !important;
  }
 
  .customers-card{
    position: relative;
  }
  .customers-card-title{
    position: absolute !important;
    left: 20px;
    top: 35px;
  }
</style>
<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/laravel-user-management.js'])
@endsection

@section('content')
  @foreach($invoices as $paid)
    @include('modals.edit-payment-modal', ['payment' => $paid])
    @include('modals.view-payment-modal', ['payment' => $paid])
  @endforeach

  <div class="d-flex align-items-center justify-content-between mb-4">
    <span class="h3">Invoices ({{ $totalInvoices }})</span>
    <div class="d-flex align-items-center">
      <label for="scheckAll" class="btn btn-secondary mx-4 d-flex align-items-center">
        <input type="checkbox" id="scheckAll" class="mr-2" />
        Select All
      </label>
      <button class="btn btn-primary text-white" id="sendSelected" 
        @if (Auth::user()->role == 'Admin') @else disabled @endif
      >
        print Selected
      </button>
    </div>
  </div>

  
  <div class="card">
    <div class="card-body customers-card">
      <div class="d-flex justify-content-between p-4">
        <h4>Date Range</h4>
        <form method="GET" action="{{ route('invoices.specific_month') }}">
          @csrf
         
          <div class="form-floating form-floating-outline">
            <input 
              class="form-control" 
              type="date" 
              placeholder="start_date" 
              name="start_date" id="start_date"  
            />
            <label for="start_date">Start date</label>
          </div>
          <div class="form-floating form-floating-outline mx-2">
            <input 
              class="form-control" 
              type="date" 
              placeholder="end_date" 
              name="end_date" id="end_date"  
            />
            <label for="end_date">End date</label>
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
      <table class="table invoice-table" id='example'>
        <thead>
          <tr>
            <th class="">Name</th>
            <th>Usage (M³)</th>
            <th>Amount</th>
            <th>Outstanding</th>
            <th>Billing Date</th>
            <th>Serial</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoices as $payment)
            <tr data-id="{{$payment->id}}">
              <td>
                <input type="checkbox" class="row-checkbox" />
                {{ $payment->customer->first_name }} {{ $payment->customer->last_name }}
              </td>
              <td>{{ $payment->reading->value - $payment->reading->previous }} M³</td>
              <td>{{ $payment->amount }} SSP</td>
              <td>{{ $payment->remaining }} SSP</td>
              <td>{{ date("d/m/Y", strtotime($payment->date)) ?? '-----' }}</td>
              <td>{{ date("dm", strtotime($payment->date)) }}{{ $payment->id }}</td>
              <td>
                <a href="{{ route('payments.show', $payment->id) }}" title="View" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->id }}">
                  <i class="ri-fullscreen-line"></i>
                </a> 
                @if (Auth::user()->role == 'Admin')
                  |
                  <a href="#" title="Pay" data-bs-toggle="modal" 
                    data-bs-target="#editPaymentModal{{ $payment->id }}">
                    <i class="ri-hand-coin-line"></i>
                  </a> 
                @endif |
                <a href="/invoices/print/{{$payment->id }}" title="Print" target="_blank">
                  <i class="ri-file-pdf-2-line"></i>
                </a> 
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection

<script>

  document.addEventListener('DOMContentLoaded', () => {

    const selectAllCheckbox = document.getElementById("scheckAll");
    const rowCheckboxes = document.querySelectorAll(".row-checkbox");
    const sendSelectedButton = document.getElementById("sendSelected");

    // Function to get selected IDs
    const getSelectedIds = () => {
      const selectedIds = [];
      rowCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          const row = checkbox.closest("tr");
          selectedIds.push(row.dataset.id); // Get ID from the row's data-id attribute
        }
      });
      return selectedIds;
    };

    // Master Checkbox: Select/Deselect all rows
    selectAllCheckbox && selectAllCheckbox.addEventListener("change", (e) => {
      rowCheckboxes.forEach((checkbox) => {
        checkbox.checked = e.target.checked;
      });
    });

    sendSelectedButton.addEventListener("click", () => {
      const selectedIds = getSelectedIds();

      if (selectedIds.length === 0) {
        alert("No rows selected.");
        return;
      }

      // Create a form dynamically and submit it
      const form = document.createElement("form");
      form.method = "POST";
      form.action = "/invoices/multiple_invoices"; 
      form.target = '_blank'

      // Add CSRF token for Laravel
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      const csrfInput = document.createElement("input");
      csrfInput.type = "hidden";
      csrfInput.name = "_token";
      csrfInput.value = csrfToken;
      form.appendChild(csrfInput);

      // Add selected IDs as a hidden input
      const idsInput = document.createElement("input");
      idsInput.type = "hidden";
      idsInput.name = "selected_ids"; // This will be an array in Laravel
      idsInput.value = JSON.stringify(selectedIds);
      form.appendChild(idsInput);

      // Append and submit the form
      document.body.appendChild(form);
      form.submit();
    });



    $('.invoice-table').DataTable({
      dom: 'frtipB', 
      buttons: [
        'excel', 
        // 'print'
      ],
      initComplete: function () {
        $('div.dataTables_filter input').attr('placeholder', 'Search by name, contract no, meter no');
      },
      responsive: true,
    });

  });

</script>