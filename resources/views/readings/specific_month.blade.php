@php
  use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Readings')

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
      width: 350px !important;
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

@section('page-script')
@vite(['resources/js/laravel-user-management.js'])
@endsection

@section('content')

@if(Auth::user()->role == 'Admin' OR Auth::user()->department == 'Meters')
  
  <div class="row mb-8">
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded">
                <i class="ri-file-paper-2-line ri-24px"></i>
              </div>
            </div>
            <div class="card-info">
              <h4 class="mb-0">{{ $totalReadings }}</h4>
              <p class="mb-0">Total Readings</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded">
                <span class="avatar-initial rounded-3 bg-label-primary">
                  <i class="ri-drop-line ri-24px"></i>
                </span>
              </div>
            </div>
            <div class="card-info">
              <h4 class="mb-0">{{ $totalConsumption }} M³</h4>
              <p class="mb-0">Consumption</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <div class="avatar-initial bg-label-info rounded">
                <i class="ri-hourglass-2-line ri-24px"></i>
              </div>
            </div>
            <div class="card-info">
              <h4 class="mb-0">55 </h4>
              <p class="mb-0">Unaccounted</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body customers-card">
      <div class="d-flex justify-content-between mt-2">
          <div class="">
            <span class="h4">
              List of Readings for {{ $monthName }}
              @if ($year)
                - {{$year}}
              @endif
            </span>
          </div>
          <form id="departmentForm" class="d-flex" action="{{ route('readings.specific_month') }}" method="GET">
            <select id="department" name="month" class="form-select form-select-sm bg-white" aria-label="Choose User Department">
              <option selected value="">Choose Month</option>
              @foreach($months as $month)
                <option value="{{ $month }}">{{ $month }}</option>
              @endforeach
            </select>
            <select id="year" name="year" class="form-select form-select-sm  bg-white mx-2" aria-label="Choose Year">
              <option selected value="">Choose Year</option>
              @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
              @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Find</button>
          </form>
      </div>

      <table class="table table-sm invoice-table font" id='reading_table'>
          <thead>
          <tr>
              <th class="font">Cus name</th>
              <th class="font">M/ID</th>
              <th>Status</th>
              <th>Prev/Reading</th>
              <th>Cur/Reading</th>
              <th>Usage</th>
              <th>Bill Officer</th>
              <th>Collection Date</th>
          </tr>
          </thead>
          <tbody>
          @foreach($readings as $reading)
              <tr data-id="{{$reading->id}}">
                  <td>{{ $reading->customer->first_name }}</td>
                  <td>{{ $reading->meter->serial }}</td>
                  <td>{{ $reading->meter->status }}</td>
                  <td>{{ $reading->reading->previous }}</td>
                  <td>{{ $reading->reading->value }}</td>
                  <td>{{ $reading->reading->value - $reading->reading->previous }}</td>
                  <td>{{ $reading->reading->billing_officer }}</td>
                  <td>{{ date("d-m-Y", strtotime($reading->reading->date)) }}</td>
              </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>

  @else
  <h5>This Section is for Authorized uses!</h5>
@endif


@endsection

<script>

  document.addEventListener('DOMContentLoaded', () => {

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
