@extends('layouts/layoutMaster')

@section('title', 'Invoices')

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

@foreach($payments as $payment)
  @include('modals.edit-payment-modal', ['payment' => $payment])
@endforeach

<style>
   
    
    @media print{
        .main_content_wraper{
           padding: 0;
        }
        table{
            font-size: 10px;
        }
        .action-content{
            display: none !important;
            visibility: hidden !important;
        }
    }
    
</style>
@section('content')

<div class="wraper-content">
    {{-- @include('layouts/sections/navbar/navbar'); --}}
   
    <div class="main_content_wraper">
        <div class="d-flex align-items-center justify-content-between">
            <h4>{{ $customer->first_name }}'s Summary</h4>
            <button onclick="printDiv('table')" class="btn btn-secondary btn-sm">Print Summary</button>
        </div>
        <div class="card">
            <div class="card-body" id="table">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <p class="">Customer Name: {{ $customer->first_name }} {{ $customer->last_name }}</p>
                        <p class="">House No: {{ $customer->location->number }}</p>
                        <p class="">Customer Type: {{ $categories->name }}</p>
                    </div>
                    <div class="">
                        <p class="">Meter No: {{ $meter->serial }}</p>
                        <p class="">Fixed charges: {{ $payment->charges }}</p>
                        <p class="">Tariff: {{ $categories->tariff }}</p>
                    </div>
                </div>
                <table class="table table-sm table-hover table-striped">
                <thead>
                    <tr>
                    <th scope="col" style="font-size: 12px;">NO</th>
                    <th style="font-size: 12px;">DATE</th>
                    <th style="font-size: 12px;">P/READING</th>
                    <th style="font-size: 12px;">C/READING</th>
                    <th style="font-size: 12px;">USAGE</th>
                    <th style="font-size: 12px;">AMOUNT</th>
                    <th style="font-size: 12px;">TOTAL</th>
                    <th style="font-size: 12px;">PAID</th>
                    <th style="font-size: 12px;">BALANCE</th>
                    <th class="action-content" style="font-size: 12px;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($payments as $payment)
                    <tr>
                        <td style="font-size: 12px;">
                            <span class="text-danger">
                                #{{ date("dm", strtotime($payment->date)) }}{{ $payment->id }}</span>
                        </td>
                        <td style="font-size: 12px;">{{ date("m d, Y", strtotime($payment->reading->date)) }}</td>
                        <td style="font-size: 12px;">{{ $payment->reading->previous }}</td>
                        <td style="font-size: 12px;">{{ $payment->reading->value }}</td>
                        <td style="font-size: 12px;">{{$payment->reading->value - $payment->reading->previous }} M³</td>
                        <td style="font-size: 12px;">{{($payment->reading->value - $payment->reading->previous) * $payment->tariff}} SSP</td>
                        <td style="font-size: 12px;">{{ $payment->amount }} SSP</td>
                        <td style="font-size: 12px;">{{ $payment->paid }} SSP</td>
                        <td style="font-size: 12px;">{{ $payment->remaining }} SSP</td>
                        <td class="d-flex align-items-center action-content">
                            @if($customer->location) 
                            <a href="/invoices/print/{{$payment->id }}" title="Print" target="_blank">
                                <i class="ri-file-pdf-2-line"></i>
                            </a> 
                            @endif |
                            <a href="#" title="Pay" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}"><i class="ri-hand-coin-line"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No invoices found for this customer.</td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

    function printDiv(divId) {
        var content = document.getElementById(divId).innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = originalContent;
    }
  
  
  </script>