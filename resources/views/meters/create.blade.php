@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
<h4>Create Meter</h4>
    <form method="POST" action="{{ route('meters.store') }}">
        @csrf
        <!-- Form fields -->
    </form>
@endsection