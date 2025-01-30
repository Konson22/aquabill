<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reading;
use App\Models\Report;
use App\Models\Meter;
use App\Models\Customer;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
// use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of available reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalPayments = Payment::sum('amount');
        $totalPaid = Payment::where('status', 'Paid')->sum('amount');
        $totalUnpaid = Payment::where('status', 'Not Paid')->sum('amount');

        $totalBills = Payment::count();
        $paidBills = Payment::where('remaining', 0.00)->count();
        $unpaidBills = Payment::where('remaining', '>', 0.00)->count();

        $totalCustomers = Customer::count();
        $newCustomers = Meter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'Active')
                        ->count();
        $activeMeters = Meter::where('status', 'Active')->count();
        $inactiveMeters = Meter::where('status', 'Damaged')->count();

         // Retrieve all meter logs
         $meterLogs = Reading::all();

         // Calculate total consumption
        $totalConsumption = $meterLogs->reduce(function ($carry, $log) {
            return $carry + max(0, $log->value - $log->previous);
        }, 0);

        return view('reports.index', compact('totalPayments', 'totalConsumption', 'totalPaid', 'totalUnpaid','totalBills','paidBills','unpaidBills','totalCustomers','newCustomers','activeMeters','inactiveMeters'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Pass any necessary data for the report generation form, e.g., customers, meters, etc.
        $meters = Meter::all(); // Or you can fetch meters based on certain criteria
    return view('reports.create', compact('meters'));
    }

    /**
     * Store a newly created report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'meter_id' => 'required|exists:meters,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $meter = Meter::findOrFail($request->meter_id);
        $readings = Reading::where('meter_id', $meter->id)
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();
        $payments = Payment::where('customer_id', $meter->customer_id) // Assuming meter belongs to a customer
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();

        // Generate a summary or detailed report based on the data
        $reportData = [
            'meter' => $meter,
            'readings' => $readings,
            'payments' => $payments,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        // Return the report view with the data
        return view('reports.show', compact('reportData'));
    }

    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Normally, you might fetch a pre-generated report from the database.
        // For simplicity, we will assume the report is generated on-the-fly.
        // The logic to fetch and display the report can be similar to the store method.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // This may not be relevant if reports are generated on-the-fly.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // This may not be relevant if reports are generated on-the-fly.
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // This may not be relevant if reports are generated on-the-fly.
    }

    /**
     * Export the report as PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        // Validate request data
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        // Fetch necessary data based on the request
        $customer = Customer::findOrFail($request->customer_id);
        $readings = Reading::where('customer_id', $customer->id)
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();
        $payments = Payment::where('customer_id', $customer->id)
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();

        $reportData = [
            'customer' => $customer,
            'readings' => $readings,
            'payments' => $payments,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        $pdf = PDF::loadView('reports.pdf', $reportData);
        return $pdf->download('report.pdf');
    }

    /**
     * Export the report as Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        // Validate request data
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        // Fetch necessary data based on the request
        $customer = Customer::findOrFail($request->customer_id);
        $readings = Reading::where('customer_id', $customer->id)
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();
        $payments = Payment::where('customer_id', $customer->id)
                            ->whereBetween('date', [$request->date_from, $request->date_to])
                            ->get();

        $reportData = [
            'customer' => $customer,
            'readings' => $readings,
            'payments' => $payments,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        return Excel::download(new ReportsExport($reportData), 'report.xlsx');
    }
}