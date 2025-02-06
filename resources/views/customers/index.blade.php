@php
  use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Customers')

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

      <div class="row g-6 mb-6">
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div class="me-1">
                    <p class="text-heading mb-1">Customers</p>
                    <div class="d-flex align-items-center">
                      <h4 class="mb-1 me-2">{{ $totalCustomers }}</h4>
                      <p class="text-primary mb-1">(Registered)</p>
                  </div>
              </div>
              <div class="avatar">
                <div class="avatar-initial bg-label-primary rounded-3">
                  <div class="ri-user-line ri-26px"></div>
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
            <p class="text-heading mb-1">Inactive Customers</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{ $inactivecustomers }}</h4>
              <p class="text-warning mb-1">(Not Active)</p>
          </div>
      </div>
      <div class="avatar">
        <div class="avatar-initial bg-label-warning rounded-3">
          <div class="ri-user-unfollow-line ri-26px"></div>
      </div>
  </div>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-xl-3">

</div>
@if(Auth::user()->role == 'Admin' OR Auth::user()->department == 'Customers')
<div class="col-sm-6 col-xl-3">
  <div class="card">
    <div class="card-body" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
      <div class="d-flex justify-content-between">
        <div class="me-1">
          <p class="text-heading mb-1 ">Add Customer</p>
          <div class="d-flex align-items-center">
            <h4 class="mb-1 me-1">+</h4>
            <p class="text-success mb-1">(Create new)</p>
          </div>
        </div>
        <div class="avatar">
          <div class="avatar-initial bg-label-success rounded-3">
            <div class="ri-user-add-line ri-26px"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif


  </div>
  <hr class="my-6">
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasBottomLabel" class="offcanvas-title">Add Customer</h5>
  </div>
  <div class="offcanvas-body">

    <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="text" required placeholder="Write the first name .." name="first_name" id="first_name" />
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="text" required placeholder="Write the last name .." name="last_name" id="last_name" />
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="text" required placeholder="Write Phone number .." name="phone" id="phone" />
                        <label for="phone">Phone</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="text" required placeholder="Write email address .." name="email" id="email" />
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
        <select id="category_id" required name="category_id" class="form-select form-select-sm" aria-label="Choose Category">
            <option selected>Choose category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="number" required placeholder="Write the contract no." name="contract" id="contract" />
                        <label for="contract">Contract no.</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="date" required placeholder="Select a date" name="date" id="date" />
                        <label for="date">Contract Date</label>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Create Customer</button>
                </form>
  </div>
</div>
<!-- Search Form -->

<!-- Users List Table -->
<div class="card customers-card">
  <h4 class="customers-card-title">Customers</h4>
  <div class="card-datatable table-responsive p-4">
    <table class="table" id='customers_table'>
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Contract No.</th>
          {{-- <th>House No.</th> --}}
          <th>Payam</th>
          @if (Auth::user()->role == 'Admin')
          <th>Action</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($customers as $customer)
          <tr>
            <td>{{ $customer->id }}</td>
            <td>
              <a href="{{ route('customers.show', $customer->id) }}">{{ $customer->first_name }} {{ $customer->last_name }}</a>
            </td>
            <td>+211{{ $customer->phone ?? '' }}</td>
            <td>{{ $customer->contract ?? '' }}</td>
            {{-- <td>{{ $customer->credit ?? '' }}</td> --}}
            {{-- <td>{{ $customer->location->number ?? 'No Address' }}</td> --}}
            <td>{{ $customer->location->neighborhood->name ?? 'No Area'}}</td>
            @if (Auth::user()->role == 'Admin')
              <td>
                <form method="POST" action="{{ route('customers.destroy', $customer->id) }}" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

<div class="pagination mt-5">
  {{ $customers->appends(request()->query())->links() }}
</div>

<div class="offcanvas-body mx-0 flex-grow-0 h-100">

</div>

@endsection

<script>

  document.addEventListener('DOMContentLoaded', () => {
    $('#customers_table').DataTable({
      dom: 'frtipB', 
      buttons: [
        'excel', 
        'print'
      ],
      initComplete: function () {
        $('div.dataTables_filter input').attr('placeholder', 'Search by name, contract no, meter no');
      },
      responsive: true,
    });
  })
</script>
