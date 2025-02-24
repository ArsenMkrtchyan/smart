@extends('layouts')

@section('content')
    <div class="container">
        <h1>Payments for
            <a href="{{ route('projects.edit', $project->id) }}">
                {{ $project->firm_name ?? 'Project #' . $project->id }}
            </a>
        </h1>

        <div class="alert alert-info">
            <strong>Total Needed:</strong> {{ $needed }} |
            <strong>Total Paid:</strong> {{ $paid }} |
            <strong>Remaining:</strong> {{ $needed - $paid }}
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Finance</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->date ?? $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->description }}</td>
                    <td>
                        @if($payment->finance_id)
                            {{ $payment->finance->month }}
                        @else
                            Deposit
                        @endif
                    </td>
                    <td>
                        <!-- Кнопка для раскрытия подробностей с использованием Bootstrap Collapse -->
                        <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#collapse{{ $payment->id }}" aria-expanded="false" aria-controls="collapse{{ $payment->id }}">
                            Раскрыть
                        </button>
                    </td>
                </tr>
                <!-- Строка с collapse-блоком, который раскрывается при клике -->
                <tr>
                    <td colspan="5" class="p-0 border-0">
                        <div class="collapse" id="collapse{{ $payment->id }}">
                            <div class="card card-body">
                                @if(isset($distributions[$payment->id]) && count($distributions[$payment->id]) > 0)
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Тип</th>
                                            <th>Месяц / Примечание</th>
                                            <th>Требуемая сумма</th>
                                            <th>Оплачено</th>
                                            <th>Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($distributions[$payment->id] as $detail)
                                            @if($detail['type'] === 'finance')
                                                <tr>
                                                    <td>Finance</td>
                                                    <td>{{ $detail['month'] }}</td>
                                                    <td>{{ $detail['required'] }}</td>
                                                    <td>{{ $detail['allocated_from_payment'] }}</td>
                                                    <td>{{ $detail['fully_covered'] ? 'Закрыт' : 'Частично' }}</td>
                                                </tr>
                                            @elseif($detail['type'] === 'deposit')
                                                <tr>
                                                    <td>Deposit</td>
                                                    <td colspan="2">Остаток</td>
                                                    <td>{{ $detail['amount'] }}</td>
                                                    <td>Депозит</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>Нет подробностей.</p>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


    <!-- Подключаем Bootstrap CSS (если ещё не подключён) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- Подключаем jQuery (если ещё не подключён) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Подключаем Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

