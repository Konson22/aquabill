@extends('layouts/layoutMaster')

@section('title', 'Print Multiple Invoices')

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

<style>
    .title-text{
        font-size: 1rem !important;
    }
    h2{
        font-size: 0.8rem !important;
    }
    .flex-1{
        flex: 1;
    }
    
    .logo{
        width: 60px;
        height: 50px;
    }

    .my-container{
        margin-bottom: 20px;
        font-size: 14px;
        padding: 1rem;
        background-color: #fff;
    }
    .center-content{
        margin: 0 1rem;
    }

    .item-wraper{
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .item-wraper span{
        margin-left: 10px;
        flex: 1;
        padding: 3px 10px;
        background-color: rgb(245, 245, 245);
    }

    .sign{
        border-top: 1px dotted black;
    }
    @media print{
        .main-wraper{
            margin-top: 0;
            padding: 0;
        }
        .my-container{
            margin-bottom: 10px;
            font-size: 10px;
            padding: 6px;
        }
        .item-wraper span{
            margin-left: 7px;
            flex: 1;
            padding: 2px 2px;
            background-color: rgb(255, 255, 255);
        }

        .page_break{
            page-break-before: always;
            page-break-before: always !important;
        }
    }
</style>
@section('content')
    <div class="car">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h5">Total Invoices ({{$totalInvoices}})</h1>
            <button class="btn btn-primary btn-lg" onclick="printDiv('print-all')">Print All Bill</button>
        </div>
        <div class="main-wraper" id="print-all">
            @foreach($payments as $payment)
            <div class="my-container" id="printable-area">
                <header class="d-flex">
                    <img class="logo" src="{{ asset('logo.jpg') }}" alt="Logo">
                    <div class="flex-1 text-center">
                        <p class="title-text">
                            SOUTH SUDAN URBAN WATER CORPERATION 
                            <br /> WATER BILL <br/> Serial No: <span class="text-danger title-text">
                                #{{ date("dm", strtotime($payment->date)) }}{{ $payment->id }}</span>
                        </p>
                    </div>
                    <img class="logo" src="{{ asset('logo.jpg') }}" alt="Logo2">
                </header>
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-1">
                        <div class="item-wraper">
                            CUS NAME
                            <span class="flex-1">{{$payment->customer->first_name}}</span>
                        </div>
                        <div class="item-wraper">
                            CUS TYPE
                            <span class="flex-1">{{$payment->customer->category->name ?? null}}</span>
                        </div>
                        <div class="item-wraper">
                            AREA:
                            <span class="flex-1">
                                @if ($payment->customer->location)
                                    {{$payment->customer->location->address}}
                                @else
                                    ---
                                @endif
                           </span>
                        </div>
                        <div class="item-wraper">
                            HOUSE NO:
                            <span class="flex-1">
                                @if ($payment->customer->location)
                                    {{$payment->customer->location->number}}
                                @else
                                    ---
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 center-content">
                        <div class="item-wraper">
                            DATE
                            <span class="flex-1"> {{ date("F d, Y", strtotime($payment->paymentDate)) }}</span>
                        </div>
                        <div class="item-wraper">
                            INITIAL READING
                            <span class="flex-1">{{$payment->reading->previous ?? 0}}</span>
                        </div>
                        <div class="item-wraper">
                            CURRENT READING
                            <span class="flex-1">{{$payment->reading->value ?? 0}}</span>
                        </div>
                        <div class="item-wraper">
                            CONSUMPTION
                            {{-- <span class="flex-1">45 M³</span> --}}
                            <span class="flex-1">{{$payment->reading->value ?? 0 - $payment->reading->previous ?? 0}} M³</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="item-wraper">
                            TARIFF
                            <span class="flex-1">{{$payment->customer->category->tariff ?? null}}</span>
                        </div>
                        <div class="item-wraper">
                            FIXED CHARGES:
                            <span class="flex-1">{{ $payment->charges}}</span>
                        </div>
                        <div class="item-wraper">
                            VOLUMETRIC CHARGES
                            <span class="flex-1">{{$payment->amount}}</span>
                        </div>
                        <div class="item-wraper">
                            TOTAL BILL
                            <span class="flex-1">{{ $payment->charges + $payment->amount}}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between">
                    <div class="flex-1">
                        <p class="sign">Sign:Billing Officer</p>
                    </div>
                    <div class="flex-1"></div>
                    <div class="flex-1">
                        <div class="item-wraper">
                            PAID
                            <span class="flex-1">{{$payment->paid}}</span>
                        </div>
                        <div class="item-wraper">
                            OUTSTANDING
                            <span class="flex-1">{{$payment->remaining}}</span>
                        </div>
                    </div>
                </div>
                <ul>
                    <li>Make the settlement of water bills monthly and take care of water tape in your primese.</li>
                    <li>To report to Juba-Station management in case of damage or inquery Call:+211924500109/+211924600108</li>
                </ul>
            </div>
                @if($loop->iteration % 3 === 0 && !$loop->last)
                <div class="page_break"></div>
                @endif
            @endforeach
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
