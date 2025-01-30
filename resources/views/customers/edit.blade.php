@extends('layouts.app')

@section('content')
    <h1>Edit Customer</h1>
    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')
        <!-- Form fields -->
    </form>
@endsection