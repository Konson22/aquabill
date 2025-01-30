@extends('layouts.app')

@section('content')
    <h1>Customer Details</h1>
    <p>Name: {{ $customer->first_name }} {{ $customer->last_name }}</p>
    <!-- Other details -->
@endsection