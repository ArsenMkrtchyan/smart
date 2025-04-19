@extends('layouts')

@section('content')
    <div class="container py-4">

        {{-- 1) Карточки --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <div class="h5">Projects This Year</div>
                    <div id="card-projects" class="display-6 fw-bold">—</div>
                    <small id="card-projects-delta"></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <div class="h5">Total Revenue</div>
                    <div id="card-total" class="display-6 fw-bold">—</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <div class="h5">This Month</div>
                    <div id="card-month" class="display-6 fw-bold">—</div>
                    <small id="card-month-delta"></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <div class="h5">Expected This Month</div>
                    <div id="card-exp" class="display-6 fw-bold">—</div>
                </div>
            </div>
        </div>

        {{-- 2) Годовой график + годовой селект --}}
        <div class="d-flex align-items-center mb-2">
            <h4 class="me-auto">Annual Overview</h4>
            <select id="year-select" class="form-select w-auto"></select>
        </div>
        <canvas id="chart-annual" height="120"></canvas>

        {{-- 3) Месячный area-чарт + месячный селект --}}
        <div class="d-flex align-items-center mt-5 mb-2">
            <h4 class="me-auto">Daily Breakdown</h4>
            <select id="month-select" class="form-select w-auto">
                <option value="">— Select month —</option>
            </select>
        </div>
        <canvas id="chart-monthly" height="80"></canvas>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=> {

            // --- helper для анимации цифр
            function animateCount(el, to) {
                let start = 0,
                    duration = 800,
                    stepTime = Math.abs(Math.floor(duration/to)),
                    timer = setInterval(()=>{
                        start += 1;
                        el.textContent = start.toLocaleString();
                        if(start>=to) clearInterval(timer);
                    }, stepTime);
            }

            // 1) summary → карточки
            fetch('/api/finances/summary')
                .then(r=>r.json())
                .then(json=>{
                    animateCount(document.getElementById('card-projects'), json.projects.value);
                    let d = json.projects.delta;
                    let el = document.getElementById('card-projects-delta');
                    el.innerHTML = `${Math.abs(d)} ${d>0?'↑':'↓'}`;
                    animateCount(document.getElementById('card-total'), json.totalPaid.value);
                    animateCount(document.getElementById('card-month'), json.thisMonth.value);
                    document.getElementById('card-month-delta').textContent = json.thisMonth.delta+'%';
                    animateCount(document.getElementById('card-exp'), json.expected.value);
                });

            // 2) годовой график
            const ctxA = document.getElementById('chart-annual').getContext('2d');
            const chartA = new Chart(ctxA, {
                type:'line',
                data:{labels:[],datasets:[
                        {label:'Planned', data:[], borderColor:'#4e73df', tension:0.3},
                        {label:'Paid',    data:[], borderColor:'#1cc88a', tension:0.3},
                        {label:'Outstanding',data:[], borderColor:'#e74a3b', tension:0.3},
                    ]},
                options:{
                    animation:{duration:800},
                    scales:{y:{beginAtZero:true}}
                }
            });

            // 3) месячный area‑чарт
            const ctxM = document.getElementById('chart-monthly').getContext('2d');
            const chartM = new Chart(ctxM, {
                type:'line',
                data:{labels:[],datasets:[{
                        label:'Paid per day',
                        data:[],
                        fill:true,
                        backgroundColor:'rgba(54, 162, 235, 0.2)',
                        borderColor:'rgba(54, 162, 235, 1)',
                        tension:0.3
                    }]},
                options:{
                    animation:{duration:600},
                    scales:{y:{beginAtZero:true}},
                    plugins:{tooltip:{mode:'index', intersect:false}}
                }
            });

            // заполняем селекты годами и месяцами
            let now = new Date();
            let thisYear = now.getFullYear();
            let yearSel = document.getElementById('year-select');
            for(let y=thisYear;y>=thisYear-5;y--){
                let o=document.createElement('option');
                o.value=o.textContent=y;
                if(y==thisYear) o.selected=true;
                yearSel.append(o);
            }

            function loadAnnual(year){
                fetch(`/api/finances/annual?year=${year}`)
                    .then(r=>r.json())
                    .then(json=>{
                        chartA.data.labels = json.labels;
                        chartA.data.datasets[0].data = json.planned;
                        chartA.data.datasets[1].data = json.paid;
                        chartA.data.datasets[2].data = json.outst;
                        chartA.update();
                        // также обновляем месяц‑селект
                        let monSel = document.getElementById('month-select');
                        monSel.innerHTML = '<option value="">— Select month —</option>';
                        json.labels.forEach((_,i)=>{
                            let dt = new Date(year, i,1);
                            let key = dt.toLocaleString('en',{month:'long'})+'_'+year;
                            let txt = dt.toLocaleString('en',{month:'short'});
                            let o = document.createElement('option');
                            o.value = key;
                            o.textContent = txt;
                            monSel.append(o);
                        });
                    });
            }

            // initial load
            loadAnnual(thisYear);

            yearSel.addEventListener('change', ()=>{
                loadAnnual(yearSel.value);
                // сбросить месячный график
                chartM.data.labels=[]; chartM.data.datasets[0].data=[]; chartM.update();
            });

            // при выборе месяца — daily
            document.getElementById('month-select')
                .addEventListener('change', (e)=>{
                    let key = e.target.value;
                    if(!key) return;
                    fetch(`/api/finances/monthly?monthYear=${key}`)
                        .then(r=>r.json())
                        .then(json=>{
                            chartM.data.labels = json.labels;
                            chartM.data.datasets[0].data = json.data;
                            chartM.update();
                        });
                });

        });
    </script>
@endsection
