@extends('layouts/layoutMaster')
@section('title', 'Billing Reports')

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
                        <p class="text-heading mb-1">Billing Reports</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2"></h4>
                            <p class="mb-1">Create a report</p>
                        </div>
                    </div>
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <div class="ri-sticky-note-add-line ri-26px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add more cards as needed -->
</div>

<div class="card">
    <div class="card-header pb-0">
        <div class="row">
            <div class="col">
                <h5 class="card-title mb-2">List of Billing Reports</h5>
            </div>
            <div class="col">
                <form method="GET" action="{{ route('reports.billing.index') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Name, Phone, or Contract Number" value="{{ request()->query('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-datatable table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Contract Number</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $bill)
                <tr>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ $bill->phone }}</td>
                    <td>{{ $bill->contract_number }}</td>
                    <td>{{ $bill->amount }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination mt-5">
        {{ $bills->links() }}
    </div>
</div>

@endsection