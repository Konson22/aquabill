@extends('layouts/layoutMaster')
@section('title', 'Analytics')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
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
      'resources/assets/vendor/libs/moment/moment.js',
      'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
      'resources/assets/vendor/libs/select2/select2.js',
      'resources/assets/vendor/libs/@form-validation/popular.js',
      'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
      'resources/assets/vendor/libs/@form-validation/auto-focus.js',
      'resources/assets/vendor/libs/cleavejs/cleave.js',
      'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
      'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
      ])
      @endsection

      <!-- Page Scripts -->
      @section('page-script')
      @vite(['resources/js/laravel-user-management.js'])
      @endsection

      @section('content')

      <div class="row g-6 mb-6">
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div class="me-1">
                    <p class="text-heading mb-1"><a >Billing Reports</a></p>
                    <p class="mb-1">Monthly Billing</p>
              </div>
              <div class="avatar"><a href="/reports/billing/">
                <div class="avatar-initial bg-label-primary rounded-3">
          <div class="ri-bill-line ri-26px"></div></a>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
<div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Usage Reports</p>
            <p class="mb-1">Water Usage</p>
      </div>
      <div class="avatar">
        <div class="avatar-initial bg-label-primary rounded-3">
          <div class="ri-contrast-drop-2-line ri-26px"></div>
      </div>
  </div>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1 ">Customer Reports</p>
            <p class="mb-1">Customer Status</p>
      </div>
      <div class="avatar">
        <div class="avatar-initial bg-label-primary rounded-3">
          <div class="ri-group-line ri-26px"></div>
      </div>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1 ">Financial Reports</p>
            <p class="mb-1">Revenue Statement</p>
      </div>
      <div class="avatar">
        <div class="avatar-initial bg-label-primary rounded-3">
          <div class="ri-funds-box-line ri-26px"></div>
      </div>
</div>
</div>
</div>
</div>

</div>

  </div>
  <hr class="my-6">
<div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">Billing Overview</h5>
          </div>
          <div class="d-flex align-items-center card-subtitle">
            <div class="me-2">Total 0 Bills</div>
            <div class="d-flex align-items-center text-success">
              <p class="mb-0 fw-medium">+0%</p>
              <i class="ri-arrow-up-s-line ri-20px"></i>
            </div>
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
              <h5 class="mb-0">{{ $totalBills }}</h5>
              <p class="mb-0">Total Bills</p>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <div class="avatar-initial bg-label-success rounded">
                <i class="ri-receipt-line ri-24px"></i>
              </div>
            </div>
            <div class="card-info">
              <h5 class="mb-0">{{ $paidBills }}</h5>
              <p class="mb-0">Paid Bills</p>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <div class="avatar-initial bg-label-info rounded">
                <i class="ri-hourglass-2-line ri-24px"></i>
              </div>
            </div>
            <div class="card-info">
              <h5 class="mb-0">{{ $unpaidBills }}</h5>
              <p class="mb-0">Unpaid Bills</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1">Usage Overview</h5>
        </div>
        <div class="d-flex align-items-center card-subtitle">
          <div class="me-2">Total Water Consumption</div>
          <div class="d-flex align-items-center text-success">
            <p class="mb-0 fw-medium">+0%</p>
            <i class="ri-arrow-up-s-line ri-20px"></i>
          </div>
        </div>
      </div>
      <div class="card-body d-flex justify-content-between flex-wrap gap-4">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded">
              <i class="ri-water-percent-line ri-24px"></i>
            </div>
          </div>
          <div class="card-info">
            <h5 class="mb-0">{{$totalConsumption}}</h5>
            <p class="mb-0">Consumption</p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-warning rounded">
              <i class="ri-contrast-drop-line ri-24px"></i>
            </div>
          </div>
          <div class="card-info">
            <h5 class="mb-0">0</h5>
            <p class="mb-0">Unaccounted</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
<div class="mb-6"></div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">Customers Overview</h5>
            </div>
            <div class="d-flex align-items-center card-subtitle">
              <div class="me-2">Total {{ $totalCustomers }} Customers</div>
              <div class="d-flex align-items-center text-success">
                <p class="mb-0 fw-medium">+{{ $newCustomers }}</p>
              </div>
            </div>
          </div>
          <div class="card-body d-flex justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-3">
              <div class="avatar">
                <div class="avatar-initial bg-label-primary rounded">
                  <i class="ri-user-star-line ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{ $newCustomers }}</h5>
                <p class="mb-0">New</p>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="avatar">
                <div class="avatar-initial bg-label-success rounded">
                  <i class="ri-user-follow-line ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{ $activeMeters }}</h5>
                <p class="mb-0">Active</p>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="avatar">
                <div class="avatar-initial bg-label-warning rounded">
                  <i class="ri-user-unfollow-line ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{ $inactiveMeters }}</h5>
                <p class="mb-0">Inactive</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">Financial Overview</h5>
            </div>
            <div class="d-flex align-items-center card-subtitle">
              <div class="me-2">Total Income</div>
              <div class="d-flex align-items-center text-success">
                <p class="mb-0 fw-medium">{{ $totalPayments }} SSP</p>
              </div>
            </div>
          </div>
          <div class="card-body d-flex justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-3">
              <div class="avatar">
                <div class="avatar-initial bg-label-success rounded">
                  <i class="ri-download-2-line ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{ $totalPaid }} SSP</h5>
                <p class="mb-0">Total Paid</p>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="avatar">
                <div class="avatar-initial bg-label-warning rounded">
                  <i class="ri-arrow-right-down-line ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{ $totalUnpaid }} SSP</h5>
                <p class="mb-0">Total Unpaid</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="pagination mt-5">

</div>

<div class="offcanvas-body mx-0 flex-grow-0 h-100">

</div>

@endsection