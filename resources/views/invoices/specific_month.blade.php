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
  .font{
    font-size: 13px !important;
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

@if(Auth::user()->role == 'Admin' OR Auth::user()->department == 'Meters')
  @foreach($invoices as $paid)
    @include('modals.edit-payment-modal', ['payment' => $paid])
    @include('modals.view-payment-modal', ['payment' => $paid])
  @endforeach

<div class="row mb-5">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1">Billing Overview</h5>
        </div>
      </div>
      <div class="card-body d-flex justify-content-between flex-wra gap-4">
        <div class="d-flex align-items-center gap-3">
          <div class="card-info">
            <h5 class="mb-0">{{ $totalPaidCount }}</h5>
            <p class="mb-0">Total Bills</p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <div class="card-info">
            <h5 class="mb-0">{{ $totalBills }}</h5>
            <p class="mb-0">Paid Bills</p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <div class="card-info">
            <h5 class="mb-0">{{ $totalunPaidCount }}</h5>
            <p class="mb-0">Unpaid Bills</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1">Financial Overview</h5>
        </div>
      </div>
      <div class="card-body d-flex justify-content-between flex-wrap gap-4">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded">
              <i class="ri-file-paper-2-line ri-24px"></i>
            </div>
          </div>
          <div class="card-info">
            <h5 class="mb-0">{{ $totalRevenue }} SSP</h5>
            <p class="mb-0">Total Income</p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded">
              <i class="ri-file-paper-2-line ri-24px"></i>
            </div>
          </div>
          <div class="card-info">
            <h5 class="mb-0">{{ $totalPaid }} SSP</h5>
            <p class="mb-0">Total Amount Paid</p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-info rounded">
              <i class="ri-hourglass-2-line ri-24px"></i>
            </div>
          </div>
          <div class="card-info">
            <h5 class="mb-0">{{ $totalRemaining }} SSP</h5>
            <p class="mb-0">Unpaid Bills</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
  
  <div class="card">
    <div class="card-body customers-card">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <span class="h3">
          Bill for {{ $monthTitle }}
          @if ($year)
            - {{$year}}
          @endif
        </span>
        <div class="d-flex align-items-center">
          <label for="scheckAll" class="btn btn-secondary mx-4 d-flex align-items-center">
            <input type="checkbox" id="scheckAll" class="mr-2" />
            Select All
          </label>
          <button class="btn btn-primary text-white" id="sendSelected" 
            @if (Auth::user()->role == 'Admin' OR Auth::user()->role == 'invoices') @else disabled @endif
          >
            print Selected
          </button>
        </div>
      </div>
      <table class="table invoice-table font" id='example'>
        <thead>
          <tr>
            <th class="font">Serial</th>
            <th class="font">Name</th>
            <th class="font">Prev/Bal</th>
            <th class="font">Amount</th>
            <th class="font">Total Bill</th>
            <th class="font">Cur/Bal</th>
            <th class="font">Bill Date</th>
            <th class="font no-export">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoices as $payment)
            <tr data-id="{{$payment->id}}">
              <td>
                <input type="checkbox" class="row-checkbox" />
                {{ date("dm", strtotime($payment->date)) }}{{ $payment->id }}
              </td>
              <td>
                {{ $payment->customer->first_name }}
              </td>
              <td>{{ $payment->previous_balance }}</td>
              <td>{{ $payment->amount }} SSP</td>
              <td>{{ $payment->amount + $payment->previous_balance }} SSP</td>
              <td>{{ $payment->remaining }} SSP</td>
              <td>{{ date("d/m/Y", strtotime($payment->date)) ?? '-----' }}</td>
              <td class="no-export">
                <a class="no-export" href="{{ route('payments.show', $payment->id) }}" title="View" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->id }}">
                  <i class="ri-fullscreen-line"></i>
                </a> 
                <a class="no-export" href="/invoices/print/{{$payment->id }}" title="Print" target="_blank">
                  <i class="ri-file-pdf-2-line"></i>
                </a> 
                @if (Auth::user()->role == 'Admin' AND $payment->status != 'Paid')
                |
                <a class="no-export" href="#" title="Pay" data-bs-toggle="modal" 
                  data-bs-target="#editPaymentModal{{ $payment->id }}">
                  <i class="ri-hand-coin-line"></i>
                </a>  |
              @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
            <td>Total</td>
            <td>---</td>
            <td>---</td>
            <td>{{ $totalRevenue }}</td>
            <td>{{ $totalPaid }}</td>
            <td>{{ $totalRemaining }}</td>
            <td>---</td>
            <td>---</td>
          </tfoot>
      </table>
    </div>
  </div>

  @else
  <h5>This Section is for Authorized uses!</h5>
@endif


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
    {
      extend: 'excel',
      text: 'Export to Excel',
      exportOptions: {
        columns: ':not(.no-export)'  // Exclude columns with 'no-export' class
      }
    }
  ],
      initComplete: function () {
        $('div.dataTables_filter input').attr('placeholder', 'Search by name, contract no, meter no');
      },
      responsive: true,
    });

  });

</script>
