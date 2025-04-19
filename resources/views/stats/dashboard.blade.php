@extends('layouts.app')

@section('title','Finances Dashboard')

@push('head')
    {{-- Chart.js + countUp.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.umd.min.js"></script>
    <style>
        .kpi-card{border-radius:12px;padding:24px;box-shadow:0 4px 16px rgba(0,0,0,.08);transition:transform .3s}
        .kpi-card:hover{transform:translateY(-4px)}
        .kpi-number{font-size:32px;font-weight:700}
        .kpi-delta.up{color:#18ad66}
        .kpi-delta.down{color:#e84d4d}
    </style>
@endpush

@section('content')
    <div class="container-xl py-4">

        {{-- ---------- KPI row ------------------------------------------------ --}}
        <div class="row g-3 mb-4" id="kpiRow">
            @foreach(['projects','total','month','expected'] as $k)
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="kpi-card text-center">
                        <div class="kpi-title fw-semibold mb-1" id="{{$k}}Title"></div>
                        <div class="kpi-number" id="{{$k}}Number">0</div>
                        <div class="kpi-delta" id="{{$k}}Delta"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ---------- yearly bar chart --------------------------------------- --}}
        <h5 class="fw-semibold">Current Year Overview</h5>
        <canvas id="barChart" height="110"></canvas>
        <hr>

        {{-- ---------- selectors & area chart --------------------------------- --}}
        <div class="row gy-2 align-items-end">
            <div class="col-auto">
                <label class="form-label">Year</label>
                <select id="yearSelect" class="form-select"></select>
            </div>
            <div class="col-auto">
                <label class="form-label">Month</label>
                <select id="monthSelect" class="form-select"></select>
            </div>
        </div>
        <canvas id="areaChart" height="110" class="mt-3"></canvas>

    </div>
@endsection

@push('scripts')
    <script>
        const yearNow      = (new Date()).getFullYear();
        const monthNow     = (new Date()).getMonth()+1;

        /* ---------------- KPI fill ------------------------------------------- */
        function loadKpi(){
            fetch('{{route('api.kpi')}}')
                .then(r=>r.json()).then(data=>{
                fillCard('projects','Projects',data.projects,data.projectsDelta);
                fillCard('total','Total revenue',data.totalRevenue);
                fillCard('month','This month',data.monthRevenue,data.monthDelta);
                fillCard('expected','Expected',data.expected);
            });
        }
        function fillCard(key,title,val,delta){
            document.getElementById(key+'Title').innerText=title;
            const numEl = document.getElementById(key+'Number');
            const anim  = new countUp.CountUp(numEl,val,{duration:1.4,separator:' '});
            anim.start();
            const deltaEl=document.getElementById(key+'Delta');
            if(delta!==undefined){
                const cls  = delta>=0?'up':'down';
                deltaEl.className='kpi-delta '+cls;
                deltaEl.innerHTML = (delta>=0?'▲ ':'▼ ')+Math.abs(delta)+'%';
            }else deltaEl.innerHTML='';
        }

        /* ---------------- yearly bar chart ----------------------------------- */
        let barChart;
        function loadYear(year=yearNow){
            fetch(`/api/year-stats/${year}`)
                .then(r=>r.json())
                .then(d=>{
                    const data={
                        labels:d.labels,
                        datasets:[
                            {label:'Planned', type:'bar',backgroundColor:'#a7a3ff55',data:d.planned},
                            {label:'Paid',    type:'bar',backgroundColor:'#4e73dfaa',data:d.paid},
                            {label:'Outstanding',type:'bar',backgroundColor:'#e84d4d55',data:d.planned.map((v,i)=>v-d.paid[i])}
                        ]};
                    if(barChart){barChart.destroy();}
                    barChart=new Chart(document.getElementById('barChart'),{
                        data,options:{responsive:true,plugins:{tooltip:{callbacks:{
                                        footer:(tt)=>'Payments: '+d.countPay[tt[0].dataIndex]}}}}
                    });
                });
        }

        /* ---------------- monthly area chart --------------------------------- */
        let areaChart;
        function loadMonth(y,m){
            fetch(`/api/month-stats/${y}/${m}`)
                .then(r=>r.json())
                .then(d=>{
                    const data={labels:d.labels,datasets:[
                            {label:'Paid',data:d.paid,fill:'origin',tension:.4,
                                backgroundColor:'rgba(78,115,223,.25)',borderColor:'#4e73df',pointRadius:4},
                        ]};
                    if(areaChart){areaChart.destroy();}
                    areaChart=new Chart(document.getElementById('areaChart'),{
                        type:'line',data,
                        options:{plugins:{tooltip:{callbacks:{
                                        footer:(tt)=>'Tx: '+d.countPay[tt[0].dataIndex]}}}}
                    });
                })
        }

        /* ---------------- select helpers ------------------------------------- */
        function fillYearSelect(){
            let html='';
            for(let y=yearNow-5;y<=yearNow+1;y++){
                html+=`<option value="${y}" ${y===yearNow?'selected':''}>${y}</option>`;
            }
            yearSelect.innerHTML=html;
        }
        function fillMonthSelect(){
            const names=['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            let html='<option value="">–</option>';
            for(let m=1;m<=12;m++){
                html+=`<option value="${m}" ${m===monthNow?'selected':''}>${names[m]}</option>`;
            }
            monthSelect.innerHTML=html;
        }

        /* ---------------- init ------------------------------------------------ */
        fillYearSelect();
        fillMonthSelect();
        loadKpi();
        loadYear();
        loadMonth(yearNow,monthNow);

        /* ---------------- listeners ------------------------------------------ */
        yearSelect.addEventListener('change',e=>{
            loadYear(e.target.value);
            // при смене года сбрасываем месяц
            monthSelect.selectedIndex=0;
            areaChart&&areaChart.destroy();
        });
        monthSelect.addEventListener('change',e=>{
            const m=parseInt(e.target.value);
            const y=parseInt(yearSelect.value||yearNow);
            if(m)loadMonth(y,m);
        });
    </script>
@endpush
