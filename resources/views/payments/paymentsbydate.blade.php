@extends('layouts')

@section('content')
    <div class="container">
        <h1>Payments by Date</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($groupedPayments as $date => $paymentsGroup)
                @php
                    // Подсчитываем сумму платежей за эту дату
                    $totalAmount = $paymentsGroup->sum('amount');
                    // Для формирования корректного id collapse используем slug из даты
                    $collapseId = \Illuminate\Support\Str::slug($date);
                @endphp
                <tr>
                    <td>{{ $date }}</td>
                    <td>{{ $totalAmount }}</td>
                    <td>
                        <!-- Кнопка для раскрытия группы платежей -->
                        <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#collapse{{ $collapseId }}" aria-expanded="false" aria-controls="collapse{{ $collapseId }}">
                            Раскрыть
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="p-0 border-0">
                        <div class="collapse" id="collapse{{ $collapseId }}">
                            <div class="card card-body">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Project</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($paymentsGroup as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>
                                                @if(isset($payment->project) && $payment->project)
                                                    {{ $payment->project->firm_name ? $payment->project->firm_name : $payment->project->brand_name }}
                                                @else
                                                    Нет данных по проекту
                                                @endif
                                            </td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>{{ $payment->description }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

