@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Meters')

@section('content')

<!-- Cards with separator -->
<div class="col-12">
    <div class="card">
      <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
          <div class="row gy-4 gy-sm-1">
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                <div>
                  <h4 class="mb-0">{{ $totalTypes }}</h4>
                  <p class="mb-0">Total Models</p>
              </div>
              <div class="avatar me-sm-6">
                  <span class="avatar-initial rounded-3 bg-label-secondary">
                    <i class="ri-gradienter-line text-heading ri-26px"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none me-6">
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
        <div>
          <h4 class="mb-0">{{ $totalMeters }}</h4>
          <p class="mb-0">Total Meters</p>
      </div>
      <div class="avatar me-lg-6">
          <span class="avatar-initial rounded-3 bg-label-secondary">
            <i class="ri-dashboard-2-line text-heading ri-26px"></i>
        </span>
    </div>
</div>
<hr class="d-none d-sm-block d-lg-none">
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
    <div>
      <h4 class="mb-0">{{ $consumption }}</h4>
      <p class="mb-0">Consumption</p>
  </div>
  <div class="avatar me-sm-6">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-water-percent-line text-heading ri-26px"></i>
    </span>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h4 class="mb-0">{{ $inactiveMeters }}</h4>
      <p class="mb-0">Inactive Meters</p>
  </div>
  <div class="avatar">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-timer-flash-line text-heading ri-26px"></i>
    </span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<hr class="my-6">
<div class="col-12">
    <div class="row">
        <div class="col-6">
          <div class="modal-footer mb-12">

            </div>
            <div class="card mb-2">
              <h5 class="card-header">Meters list</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Serial</th>
                      <th>Status</th>
                      <th>Size</th>
                      <th>Customer</th>
                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @if($customers)
    @foreach($customers as $customer)
        @foreach($customer->meters as $meter)
            <tr>
                <td>{{ $meter->serial }}</td>
                <td>{{ $meter->status }}</td>
                <td>{{ $meter->type->size }}</td>
                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
            </tr>
        @endforeach
    @endforeach
@endif
@if($meters)
    @foreach($meters as $meter)
        <tr>
            <td>{{ $meter->serial }}</td>
            <td>{{ $meter->status }}</td>
            <td>{{ $meter->type->size }}</td>
            <td>N/A</td>
        </tr>
    @endforeach
@endif

            </tbody>
        </table>
    </div>
</div>
        </div>
        <div class="col-6">
            <div class="modal-footer mb-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMeter">
                    Add meter model
                </button>
            </div>
            <div class="card mb-2">
              <h5 class="card-header">Meter Models</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Size</th>
                      <th>Model</th>
                      <th>Manufacturer</th>
                      <th>Made Date</th>
                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($types as $model)
                <tr>
                    <td>{{ $model->size }}</td>
                    <td>{{ $model->model }}</td>
                    <td>{{ $model->manufactory }}</td>
                    <td>{{ date("M Y", strtotime($model->date)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</div>
</div>
</div>
<hr class="my-6">

<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="modalMeter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="modalCenterTitle">Add Meter Modal</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('types.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col mb-2">
                              <div class="form-floating form-floating-outline">
                                <input type="text" id="size" name="size" class="form-control" placeholder="Type a size like 1/2, 3/4 ..">
                                <label for="size">Meter Size</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="model" name="model" class="form-control" placeholder="Write the model ..">
                            <label for="model">Meter Model</label>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="manufactory" name="manufactory" class="form-control" placeholder="Write the manufacturer ..">
                            <label for="manufactory">Meter Manufacturer</label>
                        </div>
                    </div>
                    <div class="col mb-2">
                      <div class="form-floating form-floating-outline">
                        <input type="date" id="date" name="date" class="form-control">
                        <label for="date">Made Date</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Model</button>
      </div>
  </form>
</div>
</div>
</div>
</div>
</div>

@endsection