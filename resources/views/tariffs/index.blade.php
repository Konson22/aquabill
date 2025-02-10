@php
  use Illuminate\Support\Facades\Auth;
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tariffs')

@section('content')
@foreach($categories as $category)
@include('modals.editCategory', ['category' => $category])
@endforeach

<!-- Cards with separator -->
<div class="col-12">
    <div class="card">
      <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
          <div class="row gy-4 gy-sm-1">
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                <div>
                  <h4 class="mb-0">0</h4>
                  <p class="mb-0">0</p>
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
          <h4 class="mb-0"><span>0</span></h4>
          <p class="mb-0">0</p>
      </div>
      <div class="avatar me-lg-6">
          <span class="avatar-initial rounded-3 bg-label-secondary">
            <i class="ri-calendar-event-line text-heading ri-26px"></i>
        </span>
    </div>
</div>
<hr class="d-none d-sm-block d-lg-none">
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
    <div>
      <h4 class="mb-0">{{ $totalTariffs }}</h4>
      <p class="mb-0">Charges</p>
  </div>
  <div class="avatar me-sm-6">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-price-tag-2-line text-heading ri-26px"></i>
    </span>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h4 class="mb-0">{{ $totalCategories }}</h4>
      <p class="mb-0">Categories</p>
  </div>
  <div class="avatar">
      <span class="avatar-initial rounded-3 bg-label-secondary">
        <i class="ri-contrast-drop-line text-heading ri-26px"></i>
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
        <div class="col-7">
          @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'tatiff')
            <div class="modal-footer mb-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategory">
                Add New Category
              </button>
            </div>
          @endif
            <div class="card mb-2">
              <h5 class="card-header">List of Customer Categories</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Tariff</th>
                      <th>Charges</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->tariff }}</td>
                    <td>
                      <ul>
                          @foreach($category->tariffs as $tariff)
                          <li>{{ $tariff->name }} - {{ $tariff->amount }}</li>
                          @endforeach
                      </ul>
                    </td>
                    <td>
                      @if (Auth::user()->role == 'Admin')
                        <a href="#" title="Edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}"><i class="ri-hand-coin-line"></i></a>
                      @endif 
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</div>
<div class="col-5">
        @if (Auth::user()->role == 'Admin' OR Auth::user()->department == 'tatiff')
          <div class="modal-footer mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaltariff">
              Add New Charge
            </button>
          </div>
        @endif
            <div class="card mb-2">
              <h5 class="card-header">List of Monthly Charges</h5>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Amount</th>
                      <th>Category</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($tariffs as $tariff)
                <tr>
                  <td>{{ $tariff->name }}</td>
                  <td>{{ $tariff->amount }}</td>
                  <td>{{ $tariff->category->name }}</td>
                  @if (Auth::user()->role == 'Admin')
                    <td>
                      <form action="{{ route('tariffs.destroy', $tariff->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="#" class="btn btn-sm btn-danger" onclick="this.closest('form').submit(); return false;">x</a>
                      </form>
                    </td>
                  @endif
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
                      <h4 class="modal-title" id="modalCenterTitle">Add New Charge</h4>
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

             <div class="col mb-2">
            <div class="form-floating form-floating-outline">
                <select id="category_id" name="category_id" class="form-select">
                    <option value="" selected disabled>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="category_id">Category</label>
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
                                <input type="text" id="name" name="name" class="form-control" placeholder="Type a name like residential ..">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                          <div class="form-floating form-floating-outline">
                            <input type="number" id="tariff" name="tariff" class="form-control" placeholder="Specify the cubic meter tariff ..">
                            <label for="tariff">Tariff</label>
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
