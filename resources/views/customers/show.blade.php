@php
  use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'AquaBill - Customers')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/tagify/tagify.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/tagify/tagify.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])

<script>
  function toggleNewNeighborhoodInput() {
    const neighborhoodSelect = document.getElementById('neighborhood_id');
    const newNeighborhoodRow = document.getElementById('new-neighborhood-row');

    if (neighborhoodSelect.value === 'new') {
      newNeighborhoodRow.classList.remove('d-none');
    } else {
      newNeighborhoodRow.classList.add('d-none');
    }
  }

  const currentInput = document.getElementById('current_input');
  const previousInput = document.getElementById('previous_nput');
  const readingSubmitBtn = document.getElementById('reading_submit_btn');
  const errorCard = document.getElementById('add_error_card');

  currentInput.addEventListener('input', (e)=> {
    const currentReadingVal = parseInt(e.target.value)
    const previouseValue = parseInt(previousInput.value)

    if(currentReadingVal < previouseValue){
      errorCard.className = 'text-danger mb-4'
      errorCard.innerText = `Reading Value Must be Greater then Previouse Reading`
      readingSubmitBtn.disabled = true
    }else{
      errorCard.className = ''
      errorCard.innerText = ``
      readingSubmitBtn.disabled = false
    }
  })
</script>
@endsection
  @section('page-script')
  @vite([
    'resources/assets/js/modal-edit-user.js',
    'resources/assets/js/app-ecommerce-customer-detail.js',
    'resources/assets/js/app-ecommerce-customer-detail-overview.js'
  ])
@endsection

@section('content')
  @foreach($payments as $payment)
    @include('modals.edit-payment-modal', ['payment' => $payment])
    @include('modals.view-payment-modal', ['payment' => $payment])
  @endforeach

  @foreach($readings as $reading)
    @include('modals.edit-reading-modal', ['reading' => $reading])
  @endforeach

  {{-- THE START OF HEADING SECTION --}}
  <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
      <h4 class="mb-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/customers">Customers</a>
            </li>
            <li class="breadcrumb-item active">#{{ $customer->id }}</li>
          </ol>
        </nav>
      </h4>
    </div>
    @if($customer->meter_id)
      <div class="ms-auto">
        <a href="/invoices/summary/{{$customer->id}}" target="_blank" class="btn btn-primary">Summary</a>
          @if (Auth::user()->role == 'Admin')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invoiceModal">Add One-time Invoice</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" 
            data-bs-target="#readingsModal">Add Reading</button>
          @endif
      </div>
      @endif
  </div>
  {{-- THE END OF HEADING SECTION --}}

  {{-- THE START OF BODY SECTION --}}
  <div class="row">
    <!-- THE START OF SIDEBAR -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <div class="card mb-6">
        <div class="card-header header-elements">
          <span class="badge badge-center bg-label-primary">{{ $customer->id }}</span>
          <div class="card-header-elements ms-auto">
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:;" data-bs-target="#modalEditDetails" data-bs-toggle="modal"><i class="ri-pencil-line me-1"></i> Edit</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-2">
          <div class="customer-avatar-section">
            <div class="d-flex align-items-center flex-column">
              <div class="customer-info text-center mb-6">
                <h5 class="mb-0">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                <span>{{ $customer->category->name ?? 'No Category'}}</span>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-around flex-wrap mb-6 gap-4 gap-md-3 gap-lg-4">
            <div class="d-flex align-items-center gap-4 me-5">
              <div class="avatar">
                <div class="avatar-initial rounded-3 bg-label-primary"><i class='ri-money-dollar-circle-line ri-24px'></i>
                </div>
              </div>
              <div>
                <h5 class="mb-0">{{ $customer->credit }} SSP</h5>
                <span>Total Outstanding</span>
              </div>
            </div>
          </div>
          <div class="info-container">
            <h5 class="border-bottom text-capitalize pb-4 mt-6 mb-4">Details</h5>
            <ul class="border-bottom list-unstyled mb-6">
              <li class="mb-2">
                <span class="h6 me-1">Contract No:</span>
                <span>{{ $customer->contract ?? 'No data' }}</span>
              </li>
              <li class="mb-2">
                <span class="h6 me-1">Contract Date:</span>
                <span>{{ $customer->date ?? 'No data' }}</span>
              </li>
              <li class="mb-2">
                <span class="h6 me-1">Email:</span>
                <span>{{ $customer->email }}</span>
              </li>
              <li class="mb-2">
                <span class="h6 me-1">Contact:</span>
                <span>{{ $customer->phone }}</span>
              </li>
            </ul>
            <h5 class="border-bottom text-capitalize pb-4 mt-6 mb-4">Statistics</h5>
            <ul class="border-bottom list-unstyled mb-6">
              <li class="mb-2">
                <span class="h6 me-1">Last Consomption:</span>
                <span>{{ $usage ?? 'No data'}} m³</span>
              </li>
              <li class="mb-2">
                <span class="h6 me-1">Tariff per Cubic Meter:</span>
                <span>{{ $customer->category->tariff ?? 'No data'}} SSP</span>
              </li>
            </ul>
            <h5 class="border-bottom text-capitalize pb-4 mt-6 mb-4">Charges</h5>
            <ul class="border-bottom list-unstyled mb-6">
              @if($customer->category)
              @foreach($customer->category->tariffs as $tariff)
              <li class="mb-2">
                <span class="h6 me-1">{{ $tariff->name }}:</span>
                <span>{{ $tariff->amount }} SSP</span>
              </li>
              @endforeach
              @else
              <p>No Category</p>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalEditDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
          <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
              <div class="text-center mb-6">
                <h4 class="mb-2">Edit Customer Information</h4>
              </div>
              <form class="row g-5" method="POST" action="{{ route('customers.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $customer->first_name }}" placeholder="Type the name .." />
                    <label for="first_name">First Name</label>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $customer->last_name }}" placeholder="Type last name .." />
                    <label for="last_name">Last Name</label>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">SS (+211)</span>
                    <div class="form-floating form-floating-outline">
                      <input type="number" id="phone" name="phone" class="form-control" value="{{ $customer->phone }}" placeholder="Enter phone number" />
                      <label for="phone">Phone Number</label>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="email" name="email" class="form-control" value="{{ $customer->email }}" placeholder="xx@xx.xx" />
                    <label for="email">Email</label>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input class="form-control" type="text" placeholder="Select a contract" name="contract" id="contract" value="{{ $customer->contract }}" />
                    <label for="contract">Contract Number</label>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input class="form-control" type="date" placeholder="Select a date" name="date" id="date" value="{{ $customer->date }}" />
                    <label for="date">Contract Date</label>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline">
                    <select id="category_id" name="category_id" class="form-select form-select-sm" aria-label="Choose Category">
                      <option selected>Choose category</option>
                      @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ $customer->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                    <label for="category_id">Category</label>
                  </div>
                </div>
                <div class="col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="card mb-6">
        <div class="card-header header-elements">
          <span class="card-header-title me-2">Address Information</span>
          <div class="card-header-elements ms-auto">
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:;" data-bs-target="#modalUpdateLocation" data-bs-toggle="modal"><i class="ri-pencil-line me-1"></i> Update Details</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-start text-lg-start text-xl-start text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
            <div class="card-header-elements ms-auto">
            </div>
            <span class="h6 me-1">House No.:</span>
            <span>
              {{ $customer->location->number ?? 'No data' }}
            </span>
            <span class="h6 me-1"> - Area:</span>
            <span>{{ $customer->location->address ?? 'No data' }}</span>
            <br>
            <span class="h6 me-1">Neighborhood:</span>
            <span>{{ $customer->location->neighborhood->name ?? 'No data' }}</span>
            <br>
            <span class="h6 me-1">Address:</span>
            <span>{{ $customer->location->name ?? 'No data' }}</span>
            <br>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="mt-4">
              <div class="modal fade" id="modalLocation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="modalCenterTitle">Add Location</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('locations.store') }}">
                      @csrf
                      <div class="modal-body">
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="row">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="number" name="number" placeholder="Write house number">
                              <label for="number">House Number</label>
                            </div>
                          </div>
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="name" name="name" placeholder="Write street name ..">
                              <label for="name">Street Name</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="address" name="address" placeholder="Write the area ..">
                              <label for="address">Area</label>
                            </div>
                          </div>
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <select name="neighborhood_id" id="neighborhood_id" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="toggleNewNeighborhoodInput()">
                                <option value="">Select Neighborhood</option>
                                @foreach($neighborhoods as $neighborhood)
                                <option value="{{ $neighborhood->id }}">{{ $neighborhood->name }}</option>
                                @endforeach
                                <option value="new">Add New Neighborhood</option>
                              </select>
                              <label for="neighborhood_id">Neighborhood</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4 d-none" id="new-neighborhood-row">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="new_neighborhood" name="new_neighborhood" placeholder="New Neighborhood">
                              <label for="new_neighborhood">Enter New Neighborhood</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4">
                          <div class="col mb-2">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="xx.xxxx">
                          </div>
                          <div class="col mb-2">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="xx.xxxx">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Location</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="mt-4">
              <div class="modal fade" id="modalUpdateLocation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="modalCenterTitle">Update Location</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ isset($location) ? route('locations.update', ['location' => $location->id]) : route('locations.store') }}">
                      @csrf
                      @if(isset($location))
                      @method('PUT')
                      <input type="hidden" name="location_id" value="{{ $location->id }}">
                      @endif
                      <div class="modal-body">
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="row">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="number" name="number" placeholder="Write house number" value="{{ $location->number ?? '' }}">
                              <label for="number">House Number</label>
                            </div>
                          </div>
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="name" name="name" placeholder="Write street name .." value="{{ $location->name ?? '' }}">
                              <label for="name">Street Name</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="address" name="address" placeholder="Write the area .." value="{{ $location->address ?? '' }}">
                              <label for="address">Area</label>
                            </div>
                          </div>
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <select name="neighborhood_id" id="neighborhood_id" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="toggleNewNeighborhoodInput()">
                                <option value="">Select Neighborhood</option>
                                @foreach($neighborhoods as $neighborhood)
                                <option value="{{ $neighborhood->id ?? '' }}" {{ isset($location) && $location->neighborhood_id == $neighborhood->id ? 'selected' : '' }}>
                                  {{ $neighborhood->name ?? '' }}
                                </option>
                                @endforeach
                                <option value="new">Add New Neighborhood</option>
                              </select>
                              <label for="neighborhood_id">Neighborhood</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4 d-none" id="new-neighborhood-row">
                          <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="new_neighborhood" name="new_neighborhood" placeholder="New Neighborhood">
                              <label for="new_neighborhood">Enter New Neighborhood</label>
                            </div>
                          </div>
                        </div>
                        <div class="row g-4">
                          <div class="col mb-2">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="xx.xxxx" value="{{ $location->latitude ?? '' }}">
                          </div>
                          <div class="col mb-2">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="xx.xxxx" value="{{ $location->longitude ?? '' }}">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Location</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'Customers')
            @if(!$customer->location)
              <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalLocation">
                Add Location
              </button>
            @endif
          @endif
        </div>
      </div>
    </div>
    <!-- THE START OF RIGHT CONTENT WRAPER -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <div class="row text-nowrap">
        <div class="card mb-3">
          <div class="card-header">
            <div class="nav-align-top">
              <ul class="nav nav-tabs" role="tablist">
                @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'Invoices')
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#invoices" aria-controls="invoices" aria-selected="true">Invoices</button>
                  </li>
                @endif
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#readings" aria-controls="readings" aria-selected="false">Readings</button>
                </li>
                @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'Invoices')
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#onetimeinvoices" aria-controls="onetimeinvoices" aria-selected="false">One-Time Invoices</button>
                  </li>
                @endif
              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content p-0">
              @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'Invoices')
                <div class="tab-pane fade show active" id="invoices" role="tabpanel">
                  <div class="table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Amount</th>
                          <th>Paid</th>
                          <th>Remain</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @forelse ($payments as $payment)
                        <tr>
                          <td>{{ $payment->id }}</td>
                          <td>{{ $payment->amount }}</td>
                          <td>{{ $payment->paid }}</td>
                          <td>{{ $payment->remaining }}</td>
                          <td>{{ $payment->status }}</td>
                          <td>
                            <a href="{{ route('payments.show', $payment->id) }}" title="View" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->id }}">
                              <i class="ri-fullscreen-line"></i>
                            </a>
                            | @if($customer->location) 
                            <a href="/invoices/print/{{$payment->id }}" title="Print" target="_blank">
                              <i class="ri-file-pdf-2-line"></i>
                            </a> 
                            @endif 
                            @if (Auth::user()->role == 'Admin')
                              |
                              <a href="#" title="Pay" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}"><i class="ri-hand-coin-line"></i></a>
                            @endif 
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4">No invoices found for this customer.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              @endif
              <div class="tab-pane fade" id="readings" role="tabpanel">
                <div class="table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Meter No.</th>
                        <th>Current</th>
                        <th>Previous</th>
                        <th>M³</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @forelse($readings as $reading)
                      <tr>
                        <td>{{ $reading->meter->serial }}</td>
                        <td>{{ $reading->value }}</td>
                        <td>{{ $reading->previous }}</td>
                        <td>{{ $reading->value - $reading->previous }}</td>
                        <td>{{ date("d.m.Y", strtotime($reading->date)) }}</td>
                        <td>
                          <a href="#" title="Edit" data-bs-toggle="modal" data-bs-target="#editReadingModal{{ $reading->id }}" class='btn btn-sm btn-primary'>
                            Edit
                          </a>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4">No meter found for this customer. Please add a meter first.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="onetimeinvoices" role="tabpanel">
                <div class="table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Remain</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @forelse ($paymentsonetime as $payment)
                      <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->paid }}</td>
                        <td>{{ $payment->remaining }}</td>
                        <td>{{ $payment->status }}</td>
                        <td>
                          @if($customer->location) 
                          <a href="/invoices/print-one-time-invoice/{{$payment->id }}" title="Print" target="_blank">
                            <i class="ri-file-pdf-2-line"></i>
                          </a> 
                          @endif
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4">No invoices found for this customer.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{ $payments->links() }}
      </div>
      {{-- THE START OF METER INFO --}}
      <div class="col-xl-12 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="card mb-2">
          <div class="card-header header-elements">
            <div class="nav-align-top col-lg-7 col-md-1">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <button type="button" class="card-header-title nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#meter-details" aria-controls="meter-details" aria-selected="true">Meter Details</button>
                </li>
                <li class="nav-item">
                  <button type="button" class="card-header-title nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#meter-history" aria-controls="meter-history" aria-selected="false">History</button>
                </li>
              </ul>
            </div>
            @if (Auth::user()->role == 'Admin')
              <div class="card-header-elements ms-auto">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" data-bs-target="#modalUpdateMeter" data-bs-toggle="modal"><i class="ri-pencil-line me-1"></i> Update Meter</a>
                    <a class="dropdown-item" href="javascript:;" data-bs-target="#modalMeter" data-bs-toggle="modal"><i class="ri-pencil-line me-1"></i> Replace Meter</a>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <div class="card-body">
            <div class="tab-content p-0">
              <div class="tab-pane fade show active" id="meter-details" role="tabpanel">
                <table class="table">
                  @foreach($customer->meters as $meter)
                    <tr>
                      <th><b>Size</b></th>
                      <td>{{ optional($meter)->type->size ?? 'No data' }}</td>
                      <th><b>Model</b></th>
                      <td>{{ optional($meter)->type->model ?? 'No data' }}</td>
                    </tr>
                    <tr>
                      <th><b>Manufactured</b></th>
                      <td>{{ optional(optional($meter)->type)->date ? date("M Y", strtotime(optional($meter)->type->date)) : 'No data' }}</td>
                      <th><b>Date</b></th>
                      <td>{{ $meter ? date("F d, Y", strtotime($meter->created_at)) : 'No data' }}</td>
                    </tr>
                  @endforeach
                </table>
                @if(!$customer->meter_id)
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalMeter">
                  Add Meter
                </button>
                @endif
              </div>
              <div class="tab-pane fade" id="meter-history" role="tabpanel">
                <div class="text-white">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th>Old Meter</th>
                        <th>New Meter</th>
                        <th>Changed at</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($meterLogs as $log)
                      <tr>
                        <td>{{ $log->oldMeter->serial ?? 'N/A' }}</td>
                        <td>{{ $log->newMeter->serial }}</td>
                        <td>{{ date("F d, Y H:m", strtotime($log->changed_at)) }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="mt-4">
            <div class="modal fade" id="modalMeter" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Add or Replace Meter</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" action="{{ route('meters.store') }}">
                    @csrf
                    <div class="modal-body">
                      <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                      <div class="row">
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="serial" name="serial" placeholder="Serial Number">
                            <label for="serial">Serial Number</label>
                          </div>
                        </div>
                      </div>
                      <div class="row g-4">
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                              <option value="Maintenance">Maintenance</option>
                              <option value="Damaged">Damaged</option>
                            </select>
                            <label for="status">Status</label>
                          </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <select name="type_id" id="type_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                              @foreach($types as $type)
                              <option value="{{ $type->id }}">{{ $type->size }} {{ $type->model }}</option>
                              @endforeach
                            </select>
                            <label for="type_id">Meter Size & Model</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="mt-4">
            <div class="modal fade" id="modalUpdateMeter" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Meter</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" action="{{ $customer->meter_id ? route('meters.update', $customer->meter_id) : route('meters.store') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                      <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                      <div class="row">
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="serial" name="serial" value="{{ $meter->serial ?? '' }}" placeholder="Serial Number">
                            <label for="serial">Serial Number</label>
                          </div>
                        </div>
                      </div>
                      <div class="row g-4">
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                              <option value="Active" {{ optional(optional($customer->meter)->status)->is('Active') ? 'selected' : '' }}>Active</option>
                              <option value="Inactive" {{ optional(optional($customer->meter)->status)->is('Inactive') ? 'selected' : '' }}>Inactive</option>
                              <option value="Maintenance" {{ optional(optional($customer->meter)->status)->is('Maintenance') ? 'selected' : '' }}>Maintenance</option>
                              <option value="Damaged" {{ optional(optional($customer->meter)->status)->is('Damaged') ? 'selected' : '' }}>Damaged</option>
                            </select>
                            <label for="status">Status</label>
                          </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <select name="type_id" id="type_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                              @foreach($types as $type)
                              <option value="{{ $type->id }}" {{ optional(optional($customer->meter)->type_id)->is($type->id) ? 'selected' : '' }}>{{ $type->size }}</option>
                              @endforeach
                            </select>
                            <label for="type_id">Meter Size & Model</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update Meter</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- THE START OF METER INFO --}}

    </div>
  {{-- THE END OF BODY SECTION --}}

 <!-- Modal for creating a new one-time invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('payments.store_one_time_invoice') }}">
        @csrf
        <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
        <input type="hidden" name="meter_id" id="meter_id" value="{{ $customer->meter_id }}">
        <input type="hidden" name="source" id="source" value="web">
        <div class="modal-header">
          <h5 class="modal-title" id="createInvoiceModalLabel">Create One Time Invoice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-4">
            <div class="col mb-2">
              <input class="form-check-input" type="checkbox" id="status" name="status" value="Paid" {{ isset($payment) && $payment->status == 'Paid' ? 'checked' : '' }}>
              <label class="form-check-label" for="status">Paid</label>
            </div>
          </div>
          <div class="row g-4">
            <div class="col mb-2">
              <label for="amount" class="form-label">Amount</label>
              <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="col mb-2">
              <label for="method" class="form-label">Payment Method</label>
              <select class="form-control" id="method" name="method" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="mobile_payment">Mobile Payment</option>
                <option value="check">Check</option>
              </select>
            </div>
          </div>
          <div class="row g-4">
            <div class="col mb-2">
              <label for="paid" class="form-label">Paid</label>
              <input type="number" class="form-control" id="paid" name="paid" required>
            </div>
            <div class="col mb-2">
              <label for="date" class="form-label">Date</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>
          </div>
          <div class="row g-4">
            <div class="col mb-2">
              <label for="charges" class="form-label">Other charges</label>
              <input type="number" class="form-control" id="charges" name="charges" required>
            </div>
            <div class="col mb-2">
              <label for="remaining" class="form-label">Remaining</label>
              <input type="number" class="form-control" id="remaining" name="remaining" required>
            </div>
            <div class="row g-4">
              <div class="col mb-2">
                <label for="description" class="form-label">Description</label>
                <select class="form-control" id="description" name="description">
                  <option value="new_connection">New Connection</option>
                  <option value="re_connection">Re-Connection</option>
                  <option value="meter_installation">Meter Installation</option>
                  <option value="contract_fee">Contract Fee</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Invoice</button>
        </div>
      </form>
    </div>
  </div>
</div>
    
{{-- ADD READING MODAL --}}
<div class="modal fade" id="readingsModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('readings.store') }}" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Add Meter Reading</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meter_id" id="meter_id" value="{{ $customer->meter_id }}">
        <input type="hidden" name="tariff" id="tariff" value="{{ $customer->category->tariff ?? 0}}">
        <input type="hidden" name="method" id="method" value="Cash">
        <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
        <input type="hidden" name="paid" id="paid" value="0">
        <input type="hidden" name="status" id="status" value="Not Paid">
        <input type="hidden" name="source" id="source" value="web">
        <div id="add_error_card"></div>
        <div class="row g-4">
          <div class="col mb-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="current_input" name="value" class="form-control" placeholder="123 xxx xxx xxx">
              <label for="value">Reading Value</label>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="previous_nput" name="previous" class="form-control" placeholder="123 xxx xxx xxx" value="{{ $current ?? 0 }}" readonly>
              <label for="previous">Previous Reading</label>
            </div>
          </div>
        </div>
        <div class="row g-4">
          <div class="col mb-2">
            <div class="form-floating form-floating-outline">
              <input type="date" id="date" name="date" class="form-control" value="{{ $today }}">
              <label for="date">Reading Date</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="reading_submit_btn" class="btn btn-primary" disabled>Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
