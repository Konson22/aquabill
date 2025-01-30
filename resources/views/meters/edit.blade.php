@extends('layouts.app')

@section('content')
    <h1>Edit Meters</h1>
    <form method="POST" action="{{ route('meters.update', $meter->id) }}">
        @csrf
        @method('PUT')
        <!-- Form fields -->
    </form>
@endsection