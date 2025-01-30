<!-- resources/views/reports/create.blade.php -->
<html>
<body>
    <h1>Create a New Report</h1>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <label for="meter_id">Meter:</label>
        <select name="meter_id" id="meter_id">
            @foreach($meters as $meter)
                <option value="{{ $meter->id }}">{{ $meter->id }} - {{ $meter->description }}</option>
            @endforeach
        </select>
        <label for="date_from">From Date:</label>
        <input type="date" name="date_from" id="date_from" required>
        <label for="date_to">To Date:</label>
        <input type="date" name="date_to" id="date_to" required>
        <button type="submit">Generate Report</button>
    </form>
</body>
</html>