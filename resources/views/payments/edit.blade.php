@extends('layouts.app')

@section('content')
    <h1>Edit Payment</h1>
    <form method="POST" action="{{ route('payments.update', $payment->id) }}">
        @csrf
        @method('PUT')
        <!-- Form fields -->
    </form>
@endsection