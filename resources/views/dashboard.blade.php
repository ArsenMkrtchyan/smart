@extends('layouts')

@section('content')
    <div class="container-fluid py-4">

        <!-- Верхние карточки статистики -->
        <div class="row">
            <!-- Карточка: Всего проектов -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Всего проектов</h5>
                        <h3 class="card-text mb-0">
                            {{ $totalProjects }}
                            <!-- Стрелка и разница vs прошлый месяц -->
                            @php
                                $projDiff = (int) $projectsDiff;
                            @endphp
                            @if($projDiff !== 0)
                                <span class="{{ $projDiff > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 0.9em;">
                                {{ $projDiff > 0 ? '▲' : '▼' }}
                                    {{ abs($projDiff) }}
                            </span>
                            @endif
                        </h3>
                        <small class="text-muted">сравнение с прошлым месяцем</small>
                    </div>
                </div>
            </div>
            <!-- Карточка: Общий доход -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Общий доход</h5>
                        <h3 class="card-text mb-0">{{ number_format($totalIncome, 2, '.', ' ') }}</h3>
                        <small class="text-muted">сумма всех платежей</small>
                    </div>
                </div>
            </div>
            <!-- Карточка: Доход текущего месяца -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Доход текущего месяца</h5>
                        <h3 class="card-text mb-0">
                            {{ number_format($currentMonthIncome, 2, '.', ' ') }}
                            @if(isset($incomeGrowthPercent))
                                @if($incomeGrowthPercent !== 0)
                                    <span class="{{ $incomeGrowthPercent > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 0.9em;">
                                    {{ $incomeGrowthPercent > 0 ? '▲' : '▼' }}
                                        {{ abs($incomeGrowthPercent) }}%
                                </span>
                                @else
                                    <span class="text-muted" style="font-size: 0.9em;">0%</span>
                                @endif
                            @else
                                <span class="text-muted" style="font-size: 0.9em;">нет данных</span>
                            @endif
                        </h3>
                        <small class="text-muted">vs прошлый месяц</small>
                    </div>
                </div>
            </div>
            <!-- Карточка: Ожидаемый доход за прошлый месяц -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ожидаемый доход (прошлый месяц)</h5>
                        <h3 class="card-text mb-0">{{ number_format($expectedLastMonth, 2, '.', ' ') }}</h3>
                        <small class="text-muted">{{-- предыдущий месяц в названии --}}по плану за {{ date('F Y', strtotime('-1 month')) }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- График 1: Bar Chart (Ожидалось / Оплачено / Долг по месяцам) -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Сравнение ожиданий и оплат по месяцам {{ $currentYear }}</h5>
                        <div id="chart1"></div>  <!-- контейнер для бар-чарта -->
                    </div>
                </div>
            </div>
        </div>

        <!-- График 2: Area Chart (Суммы и транзакции) + селекторы года и месяца -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <h5 class="card-title mb-0 me-3">Динамика платежей</h5>
                            <!-- Выбор года -->
                            <label for="yearSelect" class="me-2 mb-0">Год:</label>
                            <select id="yearSelect" class="form-select form-select-sm me-3" style="width:auto; display:inline-block;">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" @if($year == $currentYear) selected @endif>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Выбор месяца (появляется после выбора года) -->
                            <label for="monthSelect" class="me-2 mb-0">Месяц:</label>
                            <select id="monthSelect" class="form-select form-select-sm" style="width:auto; display:none;">
                                <option value="">(все месяцы)</option>
                                @for($m=1; $m<=12; $m++)
                                    @php $monthName = DateTime::createFromFormat('!m', $m)->format('F'); @endphp
                                    <option value="{{ $m }}">{{ $monthName }}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="chart2"></div>  <!-- контейнер для area-чарта -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Подключение ApexCharts (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Настройки и рендеринг Bar Chart (График 1)
            var options1 = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%'
                    }
                },
                colors: ['#007bff', '#28a745', '#dc3545'],  // синие - ожидаемо, зеленые - оплачено, красные - долг (напр. Bootstrap цвета)
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [
                    {
                        name: 'Expected',
                        data: @json($expectedData)
                    },
                    {
                        name: 'Paid',
                        data: @json($paidData)
                    },
                    {
                        name: 'Debt',
                        data: @json($debtData)
                    }
                ],
                xaxis: {
                    categories: @json($monthsCategories),
                    title: { text: 'Месяцы' }
                },
                yaxis: {
                    title: { text: 'Сумма, ₽' }  // предполагаем рубли; поправьте на нужную валюту/единицу
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2);  // форматирование всплывающей подсказки (2 знака после запятой)
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            };

            var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
            chart1.render();

            // 2. Настройки и первоначенный рендеринг Area Chart (График 2)
            var options2 = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false },
                    animations: {
                        easing: 'easeinout',
                        animateGradually: { enabled: true },
                        dynamicAnimation: { enabled: true }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 4
                },
                series: [
                    {
                        name: 'Amount Paid',
                        data: @json($yearlySums)
                    },
                    {
                        name: 'Transactions',
                        data: @json($yearlyCounts)
                    }
                ],
                xaxis: {
                    categories: @json($yearlyCategories),
                    title: { text: 'Месяцы' }
                },
                yaxis: [
                    {
                        title: { text: 'Сумма платежей, ₽' }
                    },
                    {
                        opposite: true,
                        title: { text: 'Кол-во транзакций' }
                    }
                ],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: [
                        {
                            formatter: function(val) {
                                return val ? val.toFixed(2) + " Dram" : val;
                            }
                        },
                        {
                            formatter: function(val) {
                                return val ? val + " transactions" : val;
                            }
                        }
                    ]
                },
                legend: {
                    position: 'top'
                }
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            chart2.render();

            // 3. Логика динамического обновления графика 2 при изменении селекторов
            var yearSelect = document.getElementById('yearSelect');
            var monthSelect = document.getElementById('monthSelect');

            // Функция для загрузки данных и обновления графика 2
            function loadChartData(selectedYear, selectedMonth = '') {
                // Формируем URL запроса к маршруту chartData (из Laravel route)
                var url = "{{ route('dashboard.chartData') }}" + "?year=" + selectedYear;
                if (selectedMonth) {
                    url += "&month=" + selectedMonth;
                }
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error("Ошибка загрузки данных графика:", data.error);
                            return;
                        }
                        // Обновляем график 2 новыми категориями и сериями данных
                        chart2.updateOptions({
                            xaxis: {
                                categories: data.categories,
                                title: { text: selectedMonth ? 'Дни' : 'Месяцы' }
                            },
                            series: [
                                { name: 'Amount Paid', data: data.sums },
                                { name: 'Transactions', data: data.counts }
                            ]
                        });
                    })
                    .catch(err => console.error("AJAX error:", err));
            }

            // Обработчик изменения года
            yearSelect.addEventListener('change', function() {
                var year = this.value;
                // При смене года показываем селектор месяцев (если еще не показан)
                monthSelect.style.display = 'inline-block';
                // Сбросить выбор месяца (на "(все месяцы)")
                monthSelect.value = "";
                // Загрузить данные за весь выбранный год (помесячно)
                loadChartData(year);
            });

            // Обработчик изменения месяца
            monthSelect.addEventListener('change', function() {
                var year = yearSelect.value;
                var month = this.value;
                // Если месяц не выбран (значение пустое) – показываем данные за год
                loadChartData(year, month);
            });
        });
    </script>

@endsection
