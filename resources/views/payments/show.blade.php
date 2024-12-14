<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments for {{ $finance->project->firm_name }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
<div class="container mt-5">
    <h1>Payments for {{ $finance->project->firm_name }}</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Amount</th>
            <th>Detail</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->detail }}</td>
                <td>{{ $payment->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('finances.show', ['monthYear' => $finance->month]) }}" class="btn btn-primary">Back to Finances</a>
</div>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>

