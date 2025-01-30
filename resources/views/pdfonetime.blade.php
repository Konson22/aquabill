<!DOCTYPE html>
<html>
<head>
  <title>Water Bill</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 2px;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
      text-align: center;
    }

    .header img {
      height: 50px;
      margin-right: 10px;
    }

    .header h1 {
      font-size: 1.2rem;
      margin: 0;
    }

    h3 {
      text-align: center;
      font-size: 0.6rem;
      font-weight: normal;
      margin-bottom: 2px;
    }

    .section h2 {
      font-size: 1rem;
      border-bottom: .5px solid black;
    }

    .details,
    .reading,
    .summary {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding-left: 6px;
      margin: 0;
    }

    .details li,
    .reading li,
    .summary li,
    table tr td {
      list-style: none;
      margin-bottom: 2px;
      width: 100%;
      font-size: 0.8rem;
    }

    .details li span,
    .reading li span,
    .summary li span,
    table tr td span {
      display: inline-block;
      width: 70px;
      font-weight: bold;
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="header">
    <img src="{{ asset('logo.jpg') }}" alt="Logo">
    <h1>Water Bill</h1>
  </div>
  <h3><b>Number:</b> {{ $payment->id }} | <b>Date:</b> {{ date("F d, Y", strtotime($payment->date)) }}</h3>
  <h3><b>Contract No:</b> {{ $payment->customer->contract }} | <b>Status:</b> {{ $payment->status }} </h3>
  <div class="section">
    <h2></h2>
    <table>
        <tr>
    <td colspan="2"><b>Full Name</b></td>
    <td colspan="2">{{ $payment->customer->first_name }} {{ $payment->customer->last_name }}</td>
  </tr>
  <tr>
    <td><b>House:</b></td>
    <td>{{ $payment->customer->location->number }}</td>
    <td><b>Neighborhood:</b></td>
    <td>{{ $payment->customer->location->neighborhood->name }}</td>
    <td><b>Area</b></td>
    <td>{{ $payment->customer->location->name }}</td>
  </tr>
</table>
  </div>
  <div class="section">
    <h2></h2>
    <table>
      <tr>
    <td colspan="2"><b>Payment Description</b></td>
    <td colspan="2">{{ $payment->description }}</td>
  </tr>
</table>
  </div>
  <div class="section">
    <h2></h2>
       <table>
      <tr>
        <td>Amount</td>
        <td>{{ $payment->amount }}</td>
      </tr>
      <tr>
        <td>Other charges</td>
        <td>{{ $payment->charges }}</td>
      </tr>
      <tr>
        <td>Paid</td>
        <td>{{ $payment->paid }}</td>
      </tr>
      <tr>
        <td>Outstanding</td>
        <td>{{ $payment->remaining }}</td>
      </tr>
      </table>
  </div>
</body>
</html>