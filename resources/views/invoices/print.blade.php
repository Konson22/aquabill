@extends('layouts/layoutMaster')

@section('title', 'Preview Invoice')

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
        width: 70px;
        height: 60px;
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
        padding: 2px 5px;
        background-color: rgb(224, 224, 224);
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
            font-size: 10px;
            padding: 6px;
            background-color: #e22121;
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Invoice Preview</h4>
        <button class="btn btn-primary" onclick="printDiv('printable-area')">Print Bill</button>
    </div>
    <div class="my-container" id="printable-area">
        <header class="d-flex mb-2">
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
                    CUSTOMER NAME
                    <span class="flex-1 d-flex justify-content-end">{{$payment->customer->first_name}} {{$payment->customer->last_name}}</span>
                </div>
                <div class="item-wraper">
                    CUSTOMER TYPE
                    <span class="flex-1 d-flex justify-content-end">{{$category->name ?? 'No Data'}}</span>
                </div>
                <div class="item-wraper">
                    AREA:
                    <span class="flex-1 d-flex justify-content-end">{{$location->address ?? 'No Data'}}</span>
                </div>
                <div class="item-wraper">
                    HOUSE NO:
                    <span class="flex-1 d-flex justify-content-end">{{$location->number ?? 'No data'}}</span>
                </div>
            </div>
            <div class="flex-1 center-content">
                <div class="item-wraper">
                    READING DATE
                    <span class="flex-1 d-flex justify-content-end"> {{ date("F d, Y", strtotime($payment->date)) }}</span>
                </div>
                <div class="item-wraper">
                    PREVIOUS READING
                    <span class="flex-1 d-flex justify-content-end">{{$reading->previous ?? 'No Data'}}</span>
                </div>
                <div class="item-wraper">
                    CURRENT READING
                    <span class="flex-1 d-flex justify-content-end">{{$reading->value ?? 'No Data'}}</span>
                </div>
                <div class="item-wraper">
                    CONSUMPTION
                    <span class="flex-1 d-flex justify-content-end">{{$reading->value - $reading->previous}} M³</span>
                </div>
            </div>
            <div class="flex-1">
                <div class="item-wraper">
                    OUTSTANDING
                    <span class="flex-1 d-flex justify-content-end">{{$payment->remaining ?? 'No Data'}} SSP</span>
                </div>
                <div class="item-wraper">
                    FIXED CHARGES:
                    <span class="flex-1 d-flex justify-content-end">{{$payment->charges ?? 'No Data'}} SSP</span>
                </div>
                <div class="item-wraper">
                    TARIFF
                    <span class="flex-1 d-flex justify-content-end">{{$category->tariff ?? 'No Data'}} SSP</span>
                </div>
                <div class="item-wraper">
                    VOLUMETRIC CHARGES
                    <span class="flex-1 d-flex justify-content-end">{{$payment->amount ?? 'No Data'}} SSP</span>
                </div>
                {{-- <div class="item-wraper">
                    PAID ON DATE
                    <span class="flex-1 d-flex justify-content-end"> {{ $payment->updated_at ?? '-----' }}</span>
                </div> --}}
            </div>
        </div>
        <div class="d-flex align-items-end justify-content-between">
            <div class="flex-1">
                {{ $reading->billing_officer ?? '' }}
                <p class="sign">Sign:Billing Officer</p>
            </div>
            <div class="flex-1"></div>
            <div class="flex-1">
                <div class="item-wraper">
                    AMOUNT PAID
                    <span class="flex-1 d-flex justify-content-end">{{$payment->paid}} SSP</span>
                </div>
                <div class="item-wraper">
                    TOTAL BILL
                    <span class="flex-1 d-flex justify-content-end">{{$payment->charges + $payment->amount}} SSP</span>
                </div>
            </div>
        </div>
        <ul>
            <li>Make the settlement of water bills monthly and take care of water tape in your primese.</li>
            <li>To report to Juba-Station management in case of damage or inquery Call:+211929928736/+211929928737</li>
        </ul>
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

        function convertToPDF(divId) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Get the HTML content of the selected div
            const content = document.getElementById(divId).innerHTML;

            // Sanitize the HTML content with DOMPurify to prevent any issues
            const sanitizedContent = DOMPurify.sanitize(content);

            // Use jsPDF's html method to add the div content to the PDF
            doc.html(sanitizedContent, {
                callback: function (doc) {
                    doc.save('div-content.pdf');  // Save the PDF with the name 'div-content.pdf'
                },
                x: 10,  // Set the x-coordinate for the content
                y: 10   // Set the y-coordinate for the content
            });
        }
    </script>
