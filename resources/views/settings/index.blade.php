@php
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Storage;
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
    <!-- Page Scripts -->
    @section('page-script')
    @vite(['resources/js/laravel-user-management.js'])
@endsection

@section('content')
@foreach($users as $user)
    @include('modals.edit-user', ['user' => $user])
@endforeach
@foreach($departments as $department)
    @include('modals.edit-department-modal', ['department' => $department])
@endforeach



@if (Auth::user()->role == 'Admin')

<div class="d-flex align-items-center justify-content-between">
  <div class="">
    <h3 class="m-0">Users Management</h3>
  </div>
  <div class="d-flex">
    <button type="button" class="btn btn-primary mx-3" data-bs-toggle="offcanvas" data-bs-target="#newUserModal" aria-controls="newUserModal">
      create user 
    </button>
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" 
    data-bs-target="#createRoleModal">
      create new role
    </button> --}}
  </div>
</div>
<hr class="my-6" />
  <div class="card m-4">
    <div class="card-body">
      <div class="card-header">
        <h4 class="">Users </h4>
      </div>
      <div class="card-datatable table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                  <th colspan="2">User Name</th>
                  <th>Department</th>
                  <th>Role</th>
                  <th>E-mail</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr class="">
                  <td class="">
                    <div class="avatar">
                      <img class="rounded-circle" src="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : asset('assets/img/avatars/4.png') }}" alt="Profile Image"></td>
                    </div>
                  </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->department}}</td>
                  <td>{{$user->role}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end">
                      <a href="#" class="btn btn-sm btn-secondary mx-1"
                        title="Edit" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="ri-hand-coin-line"></i>
                      </a>
                      <form class="p-0 m-0" action="{{ route('settings.deleteUser', $user->id) }}" 
                        method="DELETE">
                        <button class="btn btn-sm btn-danger">delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row p-0 m-0">
    <div class="col-8">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="text-heading mb-1">Departments</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Department name</th>
                <th>Role</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                    <tr class="">
                        <td>{{$department->name}}</td>
                        <td>{{$department->role}}</td>
                        <td class="d-flex justify-content-end">
                          <a href="#" class="btn btn-sm btn-secondary mx-1"
                            title="Edit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editDepartmentModal{{ $department->id }}"
                          >
                            <i class="ri-hand-coin-line"></i>
                          </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
      </div>
    </div>
    {{-- <div class="col-4">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="text-heading mb-1">Roles</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <tbody>
              @foreach($roles as $role)
                <tr class="">
                  <td>{{$role->name}}</td>
                  <td class="d-flex justify-content-end">
                    <form class="p-0 m-0" action="{{ route('settings.deleteRole', $role->id) }}" 
                      method="DELETE">
                      <button class="btn btn-sm px-2 y-1 border border-danger">X</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div> --}}
  </div>
@else
  <div class="">
    <h3>Your are not admin</h3>
  </div> 
@endif

<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="createRoleModalLabel">Create new role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="role name">
            <label for="username">Role name</label>
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
    
@endsection
<div class="offcanvas offcanvas-end" tabindex="-1" id="newUserModal" aria-labelledby="newUserModalLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasBottomLabel" class="offcanvas-title">Create new User</h5>
    </div>
    <div class="offcanvas-body">
        <form id="formAuthentication" class="mb-5" action="{{ route('settings.store') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" required class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="johndoe" autofocus value="{{ old('name') }}">
              <label for="username">Username</label>
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
              @enderror
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" required class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
              <label for="email">Email</label>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
              @enderror
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <select id="department" required name="department" class="form-select form-select-sm" aria-label="Choose User Department">
                <option selected value="">Choose Department</option>
                @foreach($departments as $department)
                  <option value="{{ $department->department_name }}">{{ $department->name }}</option>
                @endforeach
              </select>
              <label for="department">Department</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" id="role" required class="form-control @error('role') is-invalid @enderror" name="role" placeholder="Enter user role" aria-describedby="role" />
              <label for="role">Role</label>
            </div>
              <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" required class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
              </div>
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
              @enderror
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" required id="password-confirm" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password-confirm">Confirm Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
              </div>
            </div>
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mb-5">
              <div class="form-check mt-2 @error('terms') is-invalid @enderror">
                  <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" />
                <label class="form-check-label" for="terms">
                  I agree to
                  <a href="{{ route('policy.show') }}" target="_blank">privacy policy</a> &
                  <a href="{{ route('terms.show') }}" target="_blank">terms</a>
                </label>
              </div>
              @error('terms')
                <div class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </div>
              @enderror
            </div>
            @endif
            <button type="submit" class="btn btn-primary d-grid w-100">Create</button>
          </form>
    </div>
</div>