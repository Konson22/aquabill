@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payments')

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
                  <h4 class="mb-0">{{ $totalTariffs }}</h4>
                  <p class="mb-0">Total Tariffs</p>
              </div>
              <div class="avatar me-sm-6">
                  <span class="avatar-initial rounded-3 bg-label-secondary">
                    <i class="ri-price-tag-line text-heading ri-26px"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none me-6">
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
        <div>
          <h4 class="mb-0">{{ $totalCategories }}</h4>
          <p class="mb-0">Total Categories</p>
      </div>
      <div class="avatar me-lg-6">
          <span class="avatar-initial rounded-3 bg-label-secondary">
            <i class="ri-building-line text-heading ri-26px"></i>
        </span>
    </div>
</div>
<hr class="d-none d-sm-block d-lg-none">
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
    <div>
      <h4 class="mb-0">{{ $totalCustomers }}</h4>
      <p class="mb-0">Customers</p>
  </div>
  <div class="avatar me-sm-6">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-user-search-line text-heading ri-26px"></i>
    </span>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h4 class="mb-0">{{ 0 }}</h4>
      <p class="mb-0">Payments</p>
  </div>
  <div class="avatar">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-bank-card-line text-heading ri-26px"></i>
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
          <div class="modal-footer mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaltariff">
                    Add New Tariff
                </button>
            </div>
            <div class="card mb-2">
              <h5 class="card-header">Tariffs History</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Amount</th>
                      <th>Date</th>

                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($tariffs as $tariff)
                <tr>
                    <td>{{ $tariff->name }}</td>
                    <td>{{ $tariff->amount }}</td>
                    <td>{{ $tariff->date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
        </div>
        <div class="col-6">
            <div class="modal-footer mb-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategory">
                    Add New Category
                </button>
            </div>
            <div class="card mb-2">
              <h5 class="card-header">Customer Categories</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Discount Percentage</th>
                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->discount_percentage }}</td>
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
        <div class="modal fade" id="modaltariff" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="modalCenterTitle">Add New Tariff</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('tariffs.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col mb-2">
                              <div class="form-floating form-floating-outline">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Type a name ..">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="amount" name="amount" class="form-control" placeholder="Write the amount ..">
                            <label for="amount">Amount</label>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col mb-2">
                      <div class="form-floating form-floating-outline">
                        <input type="date" id="date" name="date" class="form-control">
                        <label for="date">Date</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
      </div>
  </form>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="modalCategory" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="modalCenterTitle">Add New Category</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col mb-2">
                              <div class="form-floating form-floating-outline">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Type a name ..">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="discount_percentage" name="discount_percentage" class="form-control" placeholder="Write the discount percentage ..">
                            <label for="discount_percentage">Discount Percentage</label>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
      </div>
  </form>
</div>
</div>
</div>
</div>
</div>

@endsection