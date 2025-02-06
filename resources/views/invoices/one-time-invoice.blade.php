@extends('layouts/layoutMaster')

@section('title', 'One Time Invoice')

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
    .main-wraper{
        /* margin-top: 5rem; */
        /* padding: 0 20%; */
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
        <button class="btn btn-primary" onclick="printDiv('printable-onetime-area')">Print Bill</button>
    </div>
    <div class="my-container" id="printable-onetime-area">
        <header class="d-flex">
            <img class="logo" src="{{ asset('logo.jpg') }}" alt="Logo">
            <div class="flex-1 text-center">
                <p class="title-text">SOUTH SUDAN URBAN WATER CORPERATION <br /> ONE TIME INVOICE</p>
            </div>
            <img class="logo" src="{{ asset('logo.jpg') }}" alt="Logo2">
        </header>
        <div class="d-flex align-items-start justify-content-between">
            <div class="flex-1">
                <div class="item-wraper">
                    CUS NAME
                    <span class="flex-1">{{$customer->first_name}}</span>
                </div>
                <div class="item-wraper">
                    CONTACT
                    <span class="flex-1">{{$customer->phone}}</span>
                </div>
                <div class="item-wraper">
                    CUS TYPE
                    <span class="flex-1">{{$category->name}}</span>
                </div>
                
            </div>
            <div class="flex-1 center-content">
                <div class="item-wraper">
                    AREA
                    <span class="flex-1">{{$location->name}}</span>
                </div>
                <div class="item-wraper">
                    HOUSE NO
                    <span class="flex-1">{{$location->number}}</span>
                </div>
                <div class="item-wraper">
                    Tariff
                    <span class="flex-1">{{$payment->tariff}}</span>
                </div>
            </div>
            <div class="flex-1">
                <div class="item-wraper">
                    date
                    <span class="flex-1">{{$payment->date}}</span>
                </div>
                <div class="item-wraper">
                    description
                    <span class="flex-1">{{$payment->description}}</span>
                </div>
                <div class="item-wraper">
                    amount:
                    <span class="flex-1">{{$payment->amount}}</span>
                </div>
                <div class="item-wraper">
                    charges
                    <span class="flex-1">{{$payment->charges}}</span>
                </div>
                <div class="item-wraper">
                    TOTAL
                    <span class="flex-1">{{$payment->charges + $payment->amount}}</span>
                </div>
                <div class="item-wraper">
                    paid
                    <span class="flex-1">{{$payment->paid}}</span>
                </div>
                <div class="item-wraper">
                    balance
                    <span class="flex-1">{{$payment->remaining}}</span>
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
