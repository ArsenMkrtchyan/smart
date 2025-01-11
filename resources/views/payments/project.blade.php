@extends('layouts')

@section('content')
    <div class="container">
        <h1>Payments for {{ $project->firm_name ?? 'Project #'.$project->id }}</h1>

        <div class="alert alert-info">
            <strong>Total Needed:</strong> {{ $needed }} |
            <strong>Total Paid:</strong> {{ $paid }} |
            <strong>Remaining:</strong> {{ $needed - $paid }}
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p>
            <a href="{{ route('payments.createForProject', ['project' => $project->id]) }}" class="btn btn-primary">Pay (Deposit)</a>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to Projects</a>
        </p>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Type</th> <!-- либо месяц finance, либо "депозит" -->
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->description }}</td>
                    <td>
                        @if($payment->finance_id)
                            {{ $payment->finance->month }}
                        @else
                            Դեպոզիտ (Deposit)
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No payments</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>Payments for {{ $project->firm_name ?? 'Project #'.$project->id }}</h1>--}}

{{--        @php--}}
{{--            $currentMonthYear = "January_2025"; // такой же как в index--}}
{{--            $projectFinancesBefore = \App\Models\Finance::where('project_id',$project->id)->get()->filter(function($f) use ($currentMonthYear) {--}}
{{--                return isBefore($f->month, $currentMonthYear);--}}
{{--            });--}}
{{--            $projectFinancesBeforeSum = $projectFinancesBefore->sum('amount');--}}

{{--            $projectFinanceIdsBefore = $projectFinancesBefore->pluck('id');--}}
{{--            $projectPaymentsBefore = \App\Models\Payment::where('project_id', $project->id)--}}
{{--                ->where(function($q) use ($projectFinanceIdsBefore) {--}}
{{--                    $q->whereIn('finance_id', $projectFinanceIdsBefore)--}}
{{--                      ->orWhereNull('finance_id');--}}
{{--                })->sum('amount');--}}

{{--            $projectDebt = $projectFinancesBeforeSum - $projectPaymentsBefore;--}}
{{--        @endphp--}}

{{--        <div class="alert alert-info">--}}
{{--            <strong>Total Needed:</strong> {{ $needed }} |--}}
{{--            <strong>Total Paid:</strong> {{ $paid }} |--}}
{{--            <strong>Remaining:</strong> {{ $needed - $paid }} |--}}
{{--            <strong>Debt (до {{ $currentMonthYear }}):</strong> {{ $projectDebt }}--}}
{{--        </div>--}}

{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--        @endif--}}

{{--        <p>--}}
{{--            <a href="{{ route('payments.createForProject', ['project' => $project->id]) }}" class="btn btn-primary">Pay (Deposit)</a>--}}
{{--            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to Projects</a>--}}
{{--        </p>--}}

{{--        <table class="table table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Date</th>--}}
{{--                <th>Amount</th>--}}
{{--                <th>Description</th>--}}
{{--                <th>Type</th> <!-- либо месяц finance, либо "депозит" -->--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @forelse($payments as $payment)--}}
{{--                <tr>--}}
{{--                    <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>--}}
{{--                    <td>{{ $payment->amount }}</td>--}}
{{--                    <td>{{ $payment->description }}</td>--}}
{{--                    <td>--}}
{{--                        @if($payment->finance_id)--}}
{{--                            {{ $payment->finance->month }}--}}
{{--                        @else--}}
{{--                            Депոզит (Deposit)--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @empty--}}
{{--                <tr><td colspan="4" class="text-center text-muted">No payments</td></tr>--}}
{{--            @endforelse--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}

