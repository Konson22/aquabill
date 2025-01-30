@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Customer')

@section('content')

<h4>Create Customer</h4>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                Create New Customer
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="form-floating form-floating-outline mb-1">
                        <input class="form-control" type="text" placeholder="Write the first name .." name="first_name" id="first_name" />
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-1">
                        <input class="form-control" type="text" placeholder="Write the last name .." name="last_name" id="last_name" />
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-1">
                        <input class="form-control" type="text" placeholder="Write Phone number .." name="phone" id="phone" />
                        <label for="phone">Phone</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-1">
                        <input class="form-control" type="text" placeholder="Write email address .." name="email" id="email" />
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-1">
                        <input class="form-control" type="date" placeholder="Select a date" name="date" id="date" />
                        <label for="date">Registration Date</label>
                    </div>

                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection