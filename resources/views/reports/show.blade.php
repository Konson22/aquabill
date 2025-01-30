<!-- resources/views/reports/show.blade.php -->
<html>
<body>
    <h1>Report for Meter ID: {{ $reportData['meter']->id }}</h1>
    <h2>Readings</h2>
    <ul>
        @foreach($reportData['readings'] as $reading)
            <li>{{ $reading->date }}: {{ $reading->value }}</li>
        @endforeach
    </ul>
    <h2>Payments</h2>
    <ul>
        @foreach($reportData['payments'] as $payment)
            <li>{{ $payment->date }}: {{ $payment->amount }}</li>
        @endforeach
    </ul>
    {{-- <a href="{{ route('reports.exportPdf', ['meter_id' => $reportData['meter']->id, 'date_from' => $reportData['date_from'], 'date_to' => $reportData['date_to']]) }}">Export as PDF</a> --}}
    {{-- <a href="{{ route('reports.exportExcel', ['meter_id' => $reportData['meter']->id, 'date_from' => $reportData['date_from'], 'date_to' => $reportData['date_to']]) }}">Export as Excel</a> --}}
</body>
</html>