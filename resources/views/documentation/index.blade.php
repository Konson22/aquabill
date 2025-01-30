@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = Helper::appClasses();
@endphp


@extends('layouts/commonMaster' )
@php
// @section('title', 'AquaBill - Documentation')

$menuHorizontal = true;
$navbarFull = true;

/* Display elements */
$isNavbar = ($isNavbar ?? true);
$isMenu = ($isMenu ?? true);
$isFlex = ($isFlex ?? false);
$isFooter = ($isFooter ?? true);
$customizerHidden = ($customizerHidden ?? '');

/* HTML Classes */
$menuFixed = (isset($configData['menuFixed']) ? $configData['menuFixed'] : '');
$navbarType = (isset($configData['navbarType']) ? $configData['navbarType'] : '');
$footerFixed = (isset($configData['footerFixed']) ? $configData['footerFixed'] : '');
$menuCollapsed = (isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '');

/* Content classes */
$container = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
$containerNav = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';

@endphp
<style>
    body{
        background-color: rgb(238, 238, 238);
        scroll-behavior: smooth;
    }
    .list-group-item {
        : none;
    }
    .caret::after {
        content: '\25BC'; /* Down arrow */
        font-size: 0.8em;
        margin-left: 8px;
    }
    .collapse.show + .caret::after {
        content: '\25B2'; /* Up arrow */
    }
    .wraper-content{
        padding-top: 65px;
        height: 100vh;
        overflow: hidden;
    }
    .sidebar{
        width: 25%;
        height: 100%;
        overflow-y: scroll;
    }
    .inner-content-wrapper{
        padding: 0 10rem 0 2rem;
        flex: 1;
        max-height:  100%;
        overflow-y: scroll;
        scroll-behavior: smooth !important;
    }

  
    .section{
       border-bottom: 2px solid gray;
       margin-bottom: 2.5rem;
       padding-bottom: 2.5rem;
    }
    img{
        border: 2px solid rgb(168, 166, 166);
        box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
    }
    .image{
        height: 350px;
        border: 4px solid red;
    }

    ul, ol li{
        padding: 5px 0;
    }
    .cusomer-image{
        justify-content: space-between;
        height: 340px;
    }
    .left-image{
        flex-basis: 63%;
    }
    .right-image{
        flex-basis: 35%;
    }
    
</style>

<div class="d-flex wraper-content">
   <div class="bg-info"> @include('layouts/sections/navbar/navbar');</div>
    <nav class="sidebar">
        <ul class="list-group">
            @foreach ($items as $index => $item)
                @if (!empty($item['subcontent']))
                     <li class="list-group-item">
                        <a 
                            class="d-flex justify-content-between align-items-center text-decoration-none" 
                            data-bs-toggle="collapse" 
                            href="#collapse-{{ $index }}" 
                            role="button" 
                            aria-expanded="false" 
                            aria-controls="collapse-{{ $index }}"
                            
                        >
                            {{ $item['name'] }}
                            @if (!empty($item['subcontent']))
                                <span class="caret"></span>
                            @endif
                        </a>
                        <div class="collapse mt-2" id="collapse-{{ $index }}">
                            <ul class="list-group">
                                @foreach ($item['subcontent'] as $sub)
                                    <li class="list-group-item">
                                        <a class="scroll-bt" href="#{{ $sub['id'] }}">
                                            {{ $sub['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @else
                        <li class="list-group-item">
                            <a class="scroll-bt" href="#{{ $item['id'] }}">
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endif
            @endforeach
        </ul>
    </nav>
    
    <div class="inner-content-wrapper">
        <!-- Sections -->
        <section id="introduction" class="section">
            <h1 class="">Introduction</h1>
            <p class="text">
                Welcome to the documentation for our system! This guide is designed to help you get started, understand the system’s key features, and provide step-by-step instructions for efficient use. Whether you’re a new user or an experienced administrator, this documentation will assist you in navigating through the platform, managing customers, configuring tariffs, and utilizing advanced features.
            </p>
            <h4>Inside you will find</h4>
            <ul class="">
                <li class="py-2">
                    <strong>Getting Started</strong>: A beginner-friendly guide to setting up and using the system.
                </li>
                <li class="py-2">
                    <strong>Customer Management</strong>: Learn how to add, edit, and manage customer profiles and invoices.
                </li>
                <li class="py-2">
                    <strong>Tariff Management</strong>: Understand how to manage tariffs, including adding categories and charges.
                </li>
                <li class="py-2">
                    <strong>Meters</strong>: Configure and manage meter models for accurate data collection.
                </li>
                <li class="py-2">
                    <strong>Analytics and Settings</strong>: Access system analytics and manage application settings.
                </li>
            </ul>
            <p class="text mt-3">
                This documentation aims to make your experience with the system seamless and productive, providing you with all the information needed to maximize its potential.
            </p>
        </section>
        {{-- INSTALLATION --}}
        <div id="installation_setup" class="section">
            <h2>Installation and setup</h2>
        </div>
          {{-- SYSTEM REQUIREMENTS --}}
        <div id="system_requirements" class="section">
            <h2>System Requirements</h2>
            <p>Before you start using the system, it's important to ensure that your environment meets the necessary requirements. The system is designed to run smoothly on modern hardware and software configurations. Below are the minimum and recommended system requirements to ensure optimal performance.</p>
            <h3 class="h3">Minimum Requirements</h3>
            <ul class="list-group requirement-list mb-5">
                <li class="list-group-item"><strong>Operating System:</strong> Windows 10 or later, macOS 10.12 (Sierra) or later, Linux (Ubuntu 18.04 or later)</li>
                <li class="list-group-item"><strong>Processor:</strong> Intel Core i3 or equivalent</li>
                <li class="list-group-item"><strong>Memory (RAM):</strong> 4 GB or more</li>
                <li class="list-group-item"><strong>Storage:</strong> 2 GB of available disk space</li>
                <li class="list-group-item"><strong>Internet:</strong> Stable internet connection (Broadband recommended)</li>
                <li class="list-group-item"><strong>Software:</strong> Web Browser: Latest version of Chrome, Firefox, Safari, or Edge. JavaScript enabled</li>
            </ul>
            <h3 class="h3">Recommended Requirements</h3>
            <ul class="list-group requirement-list mb-4">
                <li class="list-group-item"><strong>Operating System:</strong> Windows 10/11 (64-bit), macOS 10.15 (Catalina) or later, Linux (Ubuntu 20.04 LTS or later)</li>
                <li class="list-group-item"><strong>Processor:</strong> Intel Core i5 or equivalent (Quad-core or higher)</li>
                <li class="list-group-item"><strong>Memory (RAM):</strong> 8 GB or more</li>
                <li class="list-group-item"><strong>Storage:</strong> 5 GB of available disk space (SSD preferred)</li>
                <li class="list-group-item"><strong>Internet:</strong> High-speed internet connection (10 Mbps or faster)</li>
                <li class="list-group-item"><strong>Software:</strong> Web Browser: Latest version of Chrome, Firefox, Safari, or Edge. JavaScript enabled. Latest version of Node.js</li>
            </ul>

            <h3 class="h3">Optional Software</h3>
            <ul class="list-group requirement-list mb-5">
                <li class="list-group-item"><strong>Database:</strong> MySQL 5.7 or later, PostgreSQL 12 or later (if the system requires local database configuration)</li>
                <li class="list-group-item"><strong>Development Environment:</strong> Visual Studio Code or any other modern code editor. Docker (for containerization and local development environments)</li>
            </ul>

            <p>By meeting these requirements, you will ensure that the system performs optimally, without any issues related to compatibility or performance.</p>
        </div>
        {{-- Installation and Set up --}}
        <section id="getting_started" class="section">
            <h1 class="">Getting started</h1>
            <p class="text">
                To begin using AquaBill, follow these steps:
            </p>

            <h5 class="m-2">Access the AquaBill Admin Portal</h5>
            <ul>
                <li>
                    <strong>Open Your Browser</strong> Launch a web browser (e.g., Google Chrome, Mozilla Firefox, or Safari).
                </li>
                <li>
                    go to address bar, type in localhost:8000 or 127.0.0.1:8000 and press Enter.
                </li>
                <li>This will direct you to the AquaBill login page.</li>
            </ul>
           
            {{-- LOGIN PROCESS --}}
            <div class="d-flex">
                <img src="{{asset('assets/documentation/login.png') }}" class="image w-50" alt="login image" />
                <div class="">
                    <h5 class="m-2">Log In to Your Account</h5>
                    <ul>
                        <li>
                            Enter your username and password in the respective fields.
                        </li>
                        <li>
                            Click the Login button to access the admin dashboard.
                        </li>
                        <li>
                           <h5>Explore the Dashboard</h5>
                            After logging in, you'll land on the Admin Dashboard, where you can manage customers, generate bills, track payments, and access reports.
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        {{-- DASHBOARD --}}
        <section id="dashboard" class="section">
            <h1 class="">dashboard</h1>
            <p class="text">
                The Dashboard is the central hub of AquaBill, providing administrators with a quick and comprehensive overview of the system's key metrics and statuses. Here's what you can find on the Dashboard
            </p>
            <ul>
                <li>
                    <h5 class="m-0">Summary Cards</h5>
                    <p>
                        Displays critical information such as the total number of customers, bills generated, pending payments, and overdue accounts.
                    </p>
                </li>
                <li>
                    <h5 class="m-0">Recent Activity</h5>
                    <p>
                        Shows the latest actions within the system, such as new customers added, payments made, or bills updated.
                    </p>
                </li>
                <li>
                    <h5 class="m-0">Quick Access Shortcuts</h5>
                    <p>
                        Provides one-click access to commonly used features like generating bills, sending notifications, or viewing reports.
                    </p>
                </li>
                <li>
                    <h5 class="m-0">Charts and Graphs</h5>
                    <p>
                        Visual representations of water consumption trends, payment statuses, and system performance for better insights.
                    </p>
                </li>
                <li>
                    <h5 class="m-0">System Notifications</h5>
                    <p>
                        Highlights alerts and updates, such as pending approvals, system maintenance schedules, or overdue payments requiring immediate attention.
                    </p>
                </li>
            </ul>
            <img src="{{asset('assets/documentation/Dashboard.png') }}" class="  w-100" alt="login image" />
          
        </section>
        {{-- CUSTOMERS OVERVIEW --}}
        <section id='customers_overview' class="section">
            <h1 class="">Customers Page Overview</h1>
            <p>
                Here is where you will manage all customer-related information and activities. It provides tools to efficiently handle customer accounts and ensure accurate billing data.
            </p>
            <ul>
                <li>
                    Displays all registered customers
                </li>
                <li>
                    Search and Filters Quickly find specific customers using filters like name, account number, or billing status.
                </li>
                <li>
                    Customer Profile View detailed customer information, including contact details, billing history, and payment records.
                </li>
            </ul>
            <img 
                src="{{asset('assets/documentation/Customers_overview.png') }}" class="  w-100 mt-4" alt="login image" 
            />
            {{-- ADD NEW CUSTOMER --}}
            <div id='add_new_customer' class="mt-6">
                <h4 class="">to add new customer</h4>
                <ol>
                    <li>
                        From the dashboard, select Customers in the left-hand navigation menu.
                    </li>
                    <li>
                        On the Customers page, click the Add New Customer button located at the top-right of the page.
                    </li>
                    <li>
                        Fill in Customer Details
                    </li>
                    <li>
                        After filling out the form, click Save to create the new customer account.
                    </li>
                </ol>
               <div class="d-flex cusomer-image  mt-4">
                   <img 
                       src="{{asset('assets/documentation/Customers_add.png') }}" class="  left-image mr-2" alt="login image" 
                   />
                    <img 
                    src="{{asset('assets/documentation/customer_form2.png') }}" class="right-image ml-2  " alt="login image" 
                    />
               </div>
            </div>
            {{-- VIEW CUSTOMER PROFILE --}}
            <div id='view_customer_profile' class="mt-6">
                <div class="">
                    <div class="">
                        <h4 class="">to view customer profile</h4>
                        <ol>
                            <li>
                                Go to the Customers Page
                            </li>
                            <li>
                                Find the customer you want or use the search bar or filters to find the customer you’re looking for.
                            </li>
                            <li>
                                On the Customers List, click on Customer name this will direct you to the customer profile page.
                            </li>
                            <li>
                                Here, you’ll find everything you need about account efficiently and keep track of their history
                            </li>
                        </ol>
                    </div>
                    <img 
                        src="{{asset('assets/documentation/view_profile.png') }}" class="  w-75" alt="login image" 
                    />
               </div>
            </div>
        </section>
        {{-- VIEW CUSTOMER PROFILE --}}
        <section id='customers_profile_overview' class="section">
            <h2 class="">Profile</h2>
            <p>
                Here, you’ll find everything you need to manage their account efficiently and keep track of their history.
            </p>
            <ol>
                <li>
                    Personal Details
                </li>
                <li>
                    Invoices
                </li>
                <li>
                    One-time Invoice
                </li>
                <li>
                    Meter Readings
                </li>
                <li>
                    Meter Details and History
                </li>
            </ol>
            <img 
                src="{{asset('assets/documentation/profile.png') }}" class="right-image mb-4   w-100" alt="login image" 
            />
            {{-- EDIT CUSTOMER --}}
            <div id='edit_customer' class="mt-6">
                <h5 class="mt-4">To edit customer details</h5>
                <div class="d-flex">
                    <img 
                        src="{{asset('assets/documentation/profile_edit_btn.png') }}" class="w-100" alt="login image" 
                    />
                    <ol>
                        <li>
                            Navigate to the Customers page.
                        </li>
                        <li>
                            Search for the desired customer using their name or account number.
                        </li>
                        <li>
                            Click on the customer’s name in the list to open their profile.
                        </li>
                        <li>
                            on profile card click three dotes on top right corner to show edit action
                        </li>
                    </ol>
                   
                </div>

            </div>
            {{-- CUSTOMER INVOICES --}}
            <div id='customer_invoices' class="mt-6">
                <h5 class="">Customer invoices</h5>
                <p>
                    Detailed records of payments made, including payment dates, amounts, and methods (e.g., mobile money, bank transfer).
                </p>
            </div>
            {{-- CUSTOMER ONE-TIME INVOICES --}}
            <div id='customer_one_time_invoices' class="">
                <h5 class="">customer one time invoices</h5>
            </div>
            {{-- CUSTOMER METER READINGS --}}
            <div id='customer_readings' class="mt-6">
                <h5 class="my-2">Customer meter readings</h5>
                <p>
                    The Customer Meter Readings section lists all recorded meter readings that track the customer’s water consumption over time.
                </p>
                <h6 class="m-2"> Each entry includes:</h6>
                <ol>
                    <li>
                        Date of the reading
                    </li>
                    <li>
                        Meter reading value
                    </li>
                    <li>
                        Usage calculated since the last reading
                    </li>
                </ol>
                <p class="border border-danger p-3 mt-3">
                    This data ensures accurate billing and allows monitoring of the customer’s water usage patterns.
                </p>
            </div>
            {{-- METER DETAILS --}}
            <div id="customer_meters" class="mt-6">
                <h5 class="my-2">Meter Details</h5>
                <p>
                    The Customer Meter Details section displays information about the current meter assigned to the customer.
                </p>
                <h6 class="m-2">Key details include:</h6>
                <ol>
                    <li>
                        Meter serial number
                    </li>
                    <li>
                        Installation date
                    </li>
                    <li>
                        Current status (e.g., active, under maintenance)
                    </li>
                    <li>
                        Last recorded reading
                    </li>
                </ol>
                <p class="border border-danger p-3 mt-3">
                    This section provides a clear overview of the active meter for operational tracking.
                </p>
            </div>
            <div id="customer_meters" class="mt-6">
                <h5 class="my-2"> History of Replaced Meters</h5>
                <p>
                    The Meter History section documents all previous meters that have been replaced for the customer.
                </p>
                <h6 class="m-2">It includes:</h6>
                <ol>
                    <li>
                        Serial numbers of old meters
                    </li>
                    <li>
                        Dates of replacement
                    </li>
                    <li>
                        Reasons for replacement (e.g., malfunction, upgrade)
                    </li>
                </ol>
                <p class="border border-danger p-3 mt-3">
                    This historical record ensures transparency and assists in resolving any disputes related to meter changes.
                </p>
            </div>
            <div id="customer_meters_update" class="mt-6">
                <h5 class="my-2">To update or replace customer meter</h5>
                <p>
                    The Meter History section documents all previous meters that have been replaced for the customer.
                </p>
                <img 
                src="{{asset('assets/documentation/update_meter.png') }}" class="mb-4 w-100" alt="login image" 
            />
                
            </div>
        </section>
        {{-- TARIFF --}}
        <section class="section">
            <h2 class="m-3">Tariff Management</h2>
           <div class="">
                <p>
                    The Tariff Section allows administrators to manage billing rates and charges for customers based on predefined categories. This section is crucial for ensuring accurate and consistent billing.
                </p>
                <h5 class="my-2">Category:</h5>
                <p>
                    This field defines the type or classification of the customer based on their water usage, such as:
                </p>
                <ol>
                    <li>
                        Residential
                    </li>
                    <li>
                        Commercial
                    </li>
                    <li>
                        Industrial
                    </li>
                </ol>
                <p class="border border-danger p-3 rounnded">
                    Each category may have different rates or rules depending on the customer's water consumption and purpose.
                </p>
           </div>
            <div class="mt-5">
               <h5 class="my-2">Monthly Charges</h5>
               <p>
                    This specifies the fixed or variable charges applied to a customer’s account every month.
               </p>
                <h6 class="m-1">It includes:</h6>
                <ol>
                    <li>
                        <strong>Base fee:</strong> A standard amount charged for access to the water service.
                    </li>
                    <li>
                        <strong>Additional fees:</strong> Charges based on consumption, typically calculated per unit of water used.
                    </li>
                </ol>
                <p class="border border-danger p-3 rounnded mt-2">
                    By organizing customers into categories and assigning appropriate monthly charges, the Tariff Section ensures transparency and fairness in billing.
                </p>
            </div>
        </section>
        {{-- BILLING AND REPORT --}}
        <section id="billing_report" class="section">
            <h2>Billing & Reports</h2>
            <p>
                The Billing Report provides a detailed record of all billing activities, offering administrators a comprehensive view of the billing process. It helps in monitoring, auditing, and resolving any discrepancies in the system.
            </p>
            <h5 class="my-2">Key Features of the Billing Report:</h5>
            <ol>
                <li>
                    <h6 class="my-2">Comprehensive Billing Records</h6>
                    <p>
                        Lists all bills generated for customers, including Payment status (Paid, Pending, Overdue)
                    </p>
                </li>
                <li>
                    <h6 class="my-2">Filter and Search Options</h6>
                    <p>
                        Easily locate specific billing records by filtering based on (Name, Phone or Contract Number)
                    </p>
                </li>
                <li>
                    <h6 class="my-2">Export and Share Reports</h6>
                    <p>
                        Administrators can export billing data as PDF, Excel, or CSV files for further analysis or sharing with relevant stakeholders.
                    </p>
                </li>
                <li>
                    <h6 class="my-2">Error and Discrepancy Resolution</h6>
                    <p>
                        Highlights any anomalies, such as missed payments or billing errors, for quick resolution.
                    </p>
                </li>
            </ol>
           <div class="mt-4">
               <h5 class="my-2">How to Access the Billing Report:</h5>
               <ol>
                   <li>
                       Navigate to the Analytics page from the Sidebar.
                   </li>
                   <li>
                       Click on Billing Report.
                   </li>
               </ol>
                <img 
                    src="{{asset('assets/documentation/access_billing.png') }}" class="mb-4 w-100" alt="login image" 
                />
           </div>
        </section>
        {{-- METERS --}}
        <section id="meters_management" class="section">
            <h2 class="">Maters Management</h2>
            <p>
                The Meters Section provides essential tools for managing customer water meters, including tracking, updating, and adding new meters. It ensures that each customer’s water consumption is accurately monitored and billed.
            </p>
            <div class="mt-4">
                <h5 class="my-2">Meters List</h5>
                <p>
                    The Meters List displays all the meters currently assigned to customers. this list helps administrators easily track and manage all meters within the system.
                </p>
            </div>
            <div class="mt-4">
                <h5 class="my-2">Meter Models</h5>
                <p>
                    The Meter Models section contains a list of available meter types or models used for customer installations to ensures that the correct meter is chosen for each customer based on their specific needs and consumption requirements.
                </p>
            </div>
        </section>
        {{-- ANALYTICS --}}
        <section id="analytics" class="section">
            <h2 class="">Analytics</h2>
            <p>
                The Analytics Section provides detailed insights into key performance metrics for AquaBill, allowing administrators to monitor billing, usage, customer data, and financial performance. This section helps in data-driven decision-making and overall system optimization.
            </p>

            <ol>
                <li>
                    <h5 class="my-2">Billing Overview</h5>
                    <p>
                        The Billing Overview offers a summary of the total number of bills generated, paid, and overdue within a specific period.
                    </p>
                    <h6 class="my-2">It provides key metrics such as:</h6>
                    <ul>
                        <li>
                            Total bills issued
                        </li>
                        <li>
                            Total payments received
                        </li>
                        <li>
                            Outstanding or overdue bills
                        </li>
                        <li>
                            Billing trends and patterns over time
                        </li>
                    </ul>
                    <p>
                        This overview helps track the efficiency of the billing system and identify areas that may require attention, such as overdue accounts.
                    </p>
                </li>
                {{-- usage overview --}}
                <li>
                    <h5 class="my-2">Usage Overview</h5>
                    <p>
                        The Usage Overview presents insights into water consumption across all customers. 
                    </p>
                    <h6 class="my-2">Key metrics include:</h6>
                    <ul>
                        <li>
                            Total water usage within a specific period
                        </li>
                        <li>
                            Average consumption per customer
                        </li>
                        <li>
                            Peak usage times or periods
                        </li>
                        <li>
                            Usage trends by customer category (residential, commercial, etc.)
                        </li>
                    </ul>
                    <p>
                        This data helps administrators monitor consumption patterns and ensure that the system is operating efficiently.
                    </p>
                </li>
                {{-- customer overview --}}
                <li>
                    <h5 class="my-2">Customers Overview</h5>
                    <p>
                        The Customers Overview gives an analysis of the customer base, including;
                    </p>
                    <ul>
                        <li>
                            Total number of active customers
                        </li>
                        <li>
                            New customer registrations
                        </li>
                        <li>
                            Customer demographics (e.g., by neighborhood or category)
                        </li>
                        <li>
                            Account status (active, inactive, or suspended)
                        </li>
                    </ul>
                    <p>
                        This section helps track customer growth and identify patterns, enabling targeted customer service strategies.
                    </p>
                </li>
                {{-- financial overview --}}
                <li>
                    <h5 class="my-2">Financial Overview</h5>
                    <p class="m-0">
                        The Financial Overview summarizes the financial health of the system, providing key insights such as:
                    </p>
                    <ul>
                        <li>
                            Total revenue generated from customer payments
                        </li>
                        <li>
                            Outstanding balances and arrears
                        </li>
                        <li>
                            Payment methods used (e.g., mobile money, bank transfer)
                        </li>
                        <li>
                            Financial trends and forecasts
                        </li>
                    </ul>
                    <p class="border border-danger p-5">
                        This overview helps ensure that the financial aspect of AquaBill is on track and provides insights into payment behaviors and revenue streams.
                    </p>
                </li>
            </ol>
        </section>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const scrollBtn = document.querySelectorAll('.scroll-btn');

    scrollBtn.forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Get the button's ID
            const targetId = btn.id; 

            // Find the corresponding section by ID
            const section = document.getElementById(targetId); 
            if (section) {
                
                section.scrollIntoView({ behavior: 'smooth', block: 'start' }); // Scroll smoothly
                console.log(targetId);
            }
        });
    });
});

</script>