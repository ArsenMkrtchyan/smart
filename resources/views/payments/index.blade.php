@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Projects Payments</h1>

        @php
            use Carbon\Carbon;

            // Определяем текущую дату
            $currentDate = Carbon::now();
            $currentMonthYear = $currentDate->format('F_Y'); // Например: "January_2025"

            // Функция для преобразования строки month_year в Carbon-дату
            function parseMonthYear($monthYear) {
                [$monthName, $year] = explode('_', $monthYear);
                return Carbon::createFromFormat('F Y', "$monthName $year");
            }

            // Функция для проверки, находится ли monthYear раньше текущего месяца,
            // но не включает последний месяц перед текущим
            function isDebtMonth($monthYear, $currentMonthYear) {
                $financeMonth = parseMonthYear($monthYear);
                $currentMonth = parseMonthYear($currentMonthYear);
                return $financeMonth->lessThan($currentMonth->subMonth());
            }

            $totalDebt = 0; // Общий долг всех проектов
        @endphp

        <div class="alert alert-info">
            <strong>Total Needed:</strong> {{ $totalNeeded }} |
            <strong>Total Paid:</strong> {{ $totalPaid }} |
            <strong>Total Debt:</strong>
            @php
                $totalDebt = $projectData->sum(function ($data) use ($currentMonthYear) {
                    $financesBefore = $data['project']->finances->filter(function ($finance) use ($currentMonthYear) {
                        return isDebtMonth($finance->month, $currentMonthYear);
                    });

                    $financesBeforeSum = $financesBefore->sum('amount');
                    $paymentsBefore = $data['project']->payments->filter(function ($payment) use ($financesBefore) {
                        return $financesBefore->contains('id', $payment->finance_id) || $payment->finance_id === null;
                    })->sum('amount');

                    return $financesBeforeSum - $paymentsBefore;
                });
            @endphp
            {{ $totalDebt }}
        </div>

        <p><a href="{{ route('payments.search') }}" class="btn btn-secondary">Search & Pay</a></p>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Project</th>
                <th>Needed</th>
                <th>Paid</th>
                <th>Debt</th>
                <th>Pay directly (Deposit)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projectData as $data)
                @php
                    $financesBefore = $data['project']->finances->filter(function ($finance) use ($currentMonthYear) {
                        return isDebtMonth($finance->month, $currentMonthYear);
                    });

                    $financesBeforeSum = $financesBefore->sum('amount');
                    $paymentsBefore = $data['project']->payments->filter(function ($payment) use ($financesBefore) {
                        return $financesBefore->contains('id', $payment->finance_id) || $payment->finance_id === null;
                    })->sum('amount');

                    $debt = $financesBeforeSum - $paymentsBefore;
                @endphp

                <tr class="{{ $debt > 0 ? 'table-danger' : '' }}">
                    <td>
                        <a href="{{ route('payments.projectPayments', ['project' => $data['project']->id]) }}">
                            {{ $data['project']->brand_name ?? 'Project #'.$data['project']->id }}
                        </a>
                    </td>
                    <td>{{ $data['needed'] }}</td>
                    <td>{{ $data['paid'] }}</td>
                    <td>{{ $debt }}</td>
                    <td>
                        <a href="{{ route('payments.createForProject', ['project' => $data['project']->id]) }}" class="btn btn-success btn-sm">Pay</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


e0irjierwjijreig
