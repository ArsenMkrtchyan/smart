@extends('layouts')   {{--  или ваш базовый шаблон --}}

@section('title', 'Dashboard · Payments')

@section('content')
    <div class="container-fluid py-4">

        <h1 class="h3 mb-4 fw-semibold">Dashboard: Payments</h1>

        {{-- ─────────────  селекты  ───────────── --}}
        <div class="row gx-4 gy-3 mb-5">
            <div class="col-md-6">
                <label class="form-label">Select Year</label>
                <select id="yearSelect" class="form-select"></select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Select Month</label>
                <select id="monthSelect" class="form-select" disabled>
                    <option value="">— сначала год —</option>
                </select>
            </div>
        </div>

        {{-- ─────────────  график #1  (столбцы + линия)  ───────────── --}}
        <div class="card mb-5 shadow-sm">
            <div class="card-body">
                <canvas id="yearChart" height="110"></canvas>
            </div>
        </div>

        {{-- ─────────────  график #2  (линия + area)  ───────────── --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="monthChart" height="90"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js 3 --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const routes = {
                years      : @json(route('dashboard.payments.years')),
                yearStats  : @json(route('dashboard.payments.yearStats')),
                monthStats : @json(route('dashboard.payments.monthStats')),
            };

            /*───────────────────────────────────────────*/
            let yearChart  = null;
            let monthChart = null;

            const $year  = document.getElementById('yearSelect');
            const $month = document.getElementById('monthSelect');

            /*────  загружаем список годов  ────*/
            fetch(routes.years)
                .then(r => r.json())
                .then(data => {
                    $year.innerHTML = '<option value="">— выберите год —</option>';
                    data.forEach(y => {
                        $year.insertAdjacentHTML('beforeend', `<option value="${y}">${y}</option>`);
                    });
                });

            /*────  обработчики селектов  ────*/
            $year.addEventListener('change', () => {
                const y = +$year.value;
                if(!y){ resetYear(); return; }
                drawYearChart(y);
                fillMonthSelect(y);
            });

            $month.addEventListener('change', () => {
                const y = +$year.value,
                    m = +$month.value;
                if(!m){ resetMonth(); return; }
                drawMonthChart(y, m);
            });

            /*────────────────── helpers ──────────────────*/
            function resetYear(){
                if(yearChart) yearChart.destroy();
                $month.innerHTML = '<option value="">— сначала год —</option>';
                $month.disabled  = true;
                resetMonth();
            }
            function resetMonth(){
                if(monthChart) monthChart.destroy();
            }

            function fillMonthSelect(year){
                $month.disabled  = false;
                $month.innerHTML = '<option value="">— выберите месяц —</option>';
                for(let m=1; m<=12; m++){
                    const label = new Date(year, m-1).toLocaleString('ru',{month:'long'});
                    $month.insertAdjacentHTML('beforeend',
                        `<option value="${m}">${label}</option>`);
                }
            }

            /*────────────────── YEAR → MONTHS (bar + line) ──────────────────*/
            function drawYearChart(year){
                fetch(`${routes.yearStats}?year=${year}`)
                    .then(r=>r.json())
                    .then(rows=>{
                        const labels  = rows.map(r=>r.month);
                        const counts  = rows.map(r=>r.count);
                        const totals  = rows.map(r=>r.sum);

                        const ctx = document.getElementById('yearChart').getContext('2d');
                        if(yearChart) yearChart.destroy();

                        yearChart = new Chart(ctx,{
                            type:'bar',
                            data:{
                                labels,
                                datasets:[
                                    {   // столбцы — сколько транзакций
                                        label:'# Transactions',
                                        data : counts,
                                        backgroundColor:'rgba(99,102,241,.55)',
                                        borderRadius:4,
                                        yAxisID:'y1'
                                    },
                                    {   // линия — сумма
                                        label:'Amount (AMD)',
                                        data : totals,
                                        borderColor:'rgba(16,185,129,1)',
                                        backgroundColor:'rgba(16,185,129,.15)',
                                        type:'line',
                                        tension:.3,
                                        fill:true,
                                        yAxisID:'y2'
                                    }
                                ]
                            },
                            options:{
                                maintainAspectRatio:false,
                                interaction:{mode:'index',intersect:false},
                                scales:{
                                    y1:{beginAtZero:true,
                                        title:{display:true,text:'#'}},
                                    y2:{beginAtZero:true,
                                        title:{display:true,text:'AMD'},
                                        grid:{drawOnChartArea:false}}
                                },
                                plugins:{legend:{display:false}}
                            }
                        });
                    });
            }

            /*────────────────── MONTH → DAYS (line + area) ──────────────────*/
            function drawMonthChart(year,month){
                fetch(`${routes.monthStats}?year=${year}&month=${month}`)
                    .then(r=>r.json())
                    .then(rows=>{
                        const labels = rows.map(r=>r.day);
                        const counts = rows.map(r=>r.count);
                        const sums   = rows.map(r=>r.sum);

                        const ctx = document.getElementById('monthChart').getContext('2d');
                        if(monthChart) monthChart.destroy();

                        monthChart = new Chart(ctx,{
                            data:{
                                labels,
                                datasets:[
                                    { // тёмно‑синяя полупрозрачная линия + area
                                        label:'Amount (AMD)',
                                        data : sums,
                                        borderColor:'rgba(37,99,235,1)',
                                        backgroundColor:'rgba(37,99,235,.15)',  // very “transparent blue”
                                        tension:.35,
                                        fill:true,
                                        yAxisID:'y2',
                                        type:'line'
                                    },
                                    { // столбцы с количеством транзакций
                                        label:'# Transactions',
                                        data : counts,
                                        backgroundColor:'rgba(249,115,22,.55)',
                                        borderRadius:4,
                                        yAxisID:'y1',
                                        type:'bar'
                                    }
                                ]
                            },
                            options:{
                                maintainAspectRatio:false,
                                interaction:{mode:'index',intersect:false},
                                scales:{
                                    y1:{beginAtZero:true,title:{display:true,text:'#'}},
                                    y2:{beginAtZero:true,
                                        title:{display:true,text:'AMD'},
                                        grid:{drawOnChartArea:false}}
                                },
                                plugins:{legend:{display:false}}
                            }
                        });
                    });
            }
        });
    </script>
@endsection
