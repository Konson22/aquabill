@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
<div class="card mb-4" id="btn-dropdown-demo">
  <h5 class="card-header">Quick Actions</h5>
  <div class="card-body">
    <div class="row gy-3">

      <div class="col-lg-3 col-sm-6 col-12">

        <div class="demo-inline-spacing">
          <div class="btn-group">
            <a href="/customers" class="btn btn-primary dropdown-toggle hide-arrow">Customer Management</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-12">
        <div class="demo-inline-spacing">
          <div class="btn-group">
            <a href="/tariffs" class="btn btn-primary dropdown-toggle hide-arrow">Tariff Management</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-12">
        <div class="demo-inline-spacing">
          <div class="btn-group">
            <a href="/analytics" class="btn btn-primary dropdown-toggle hide-arrow">Reports and Analytics</a>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<hr class="my-6">
<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-drop-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $activeMeters }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Active Water Connections</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">{{ $newActive }}</span>
          <small class="text-muted">this month</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-warning"><i class='ri-blur-off-line ri-24px'></i></span>
          </div>
          <h4 class="mb-0">{{ $maintenance }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Meters on Maintenance</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">{{ $newMaintenance }}</span>
          <small class="text-muted">this month</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-danger"><i class='ri-blur-off-line ri-24px'></i></span>
          </div>
          <h4 class="mb-0">{{ $damaged }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Damaged Meters</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">{{ $newDamaged }}</span>
          <small class="text-muted">this month</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-info h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-info"><i class='ri-time-line ri-24px'></i></span>
          </div>
          <h4 class="mb-0">{{ $inactiveMeters }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Inactive Meters</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">0</span>
          <small class="text-muted">this month</small>
        </p>
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
              <p class="mb-0">Total Consumption</p>
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
              <p class="mb-0">Unaccounted Water</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mb-6"></div>
    <div class="row m-0 p-0">
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
  </div>

@endsection
