@extends('layouts.app')

@section('content')
    <h1>Create Payments</h1>
    <form method="POST" action="{{ route('payments.store') }}">
        @csrf
        <!-- Form fields -->
    </form>
@endsection