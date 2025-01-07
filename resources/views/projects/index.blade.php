{{--@extends('layouts')--}}
{{--@section('content')--}}


{{--    <div class="container-fluid">--}}
{{--        <h3 class="text-dark mb-4"> Օբեկտ</h3>--}}
{{--        <div class="card shadow">--}}
{{--            <div class="card-header py-3">--}}
{{--                <div class="btn-group" role="group" aria-label="Basic radio toggle button group"><a class="btn btn-outline-primary" role="button" href="{{ route('projects.create') }}"> Ստեղծել նոր Օբեկտ </a></div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6 text-nowrap">--}}
{{--                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">--}}
{{--                                    <option value="10" selected="">10</option>--}}
{{--                                    <option value="25">25</option>--}}
{{--                                    <option value="50">50</option>--}}
{{--                                    <option value="100">100</option>--}}
{{--                                </select>&nbsp;</label></div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">--}}
{{--                    <table class="table my-0" id="dataTable">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th><strong>Օբ․ ID</strong></th>--}}
{{--                            <th><strong>Անվանում</strong></th>--}}
{{--                            <th><strong>օբ.Հասցե</strong></th>--}}
{{--                            <th><strong>Տնօրեն</strong></th>--}}
{{--                            <th>Հեռախոս</th>--}}
{{--                            <th>Տեսակ</th>--}}
{{--                            <th>Կարգավիճակ</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach($projects as $project)--}}
{{--                            <tr>--}}
{{--                                <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg">&nbsp;{{$project->id}}</td>--}}
{{--                                <td>{{$project->brand_name}}</td>--}}
{{--                                <td>{{$project->state->name}} - {{$project->state->district}}- {{$project->w_address}}</td>--}}
{{--                                <td>{{$project->ceo_name}}</td>--}}
{{--                                <td>{{$project->ceo_phone}}</td>--}}
{{--                                <td>{{$project->i_address}}</td>--}}
{{--                                <td>{{$project->status}}</td>--}}
{{--                                </tr>--}}


{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                        <tfoot>--}}
{{--                        <tr>--}}
{{--                            <td><strong>Օբ․ ID</strong></td>--}}
{{--                            <td><strong>Անվանում</strong></td>--}}
{{--                            <td><strong>օբ.Հասցե</strong></td>--}}
{{--                            <td><strong>Տնօրեն</strong></td>--}}
{{--                            <td><strong>Հեռախոս</strong></td>--}}
{{--                            <td><strong>Տեսակ</strong></td>--}}
{{--                            <td><strong>Տեսակ</strong></td>--}}
{{--                        </tr>--}}
{{--                        </tfoot>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6 align-self-center">--}}
{{--                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">--}}
{{--                            <ul class="pagination">--}}
{{--                                <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>--}}
{{--                                <li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>--}}
{{--                            </ul>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}



{{--                        <tr>--}}
{{--                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg">&nbsp;1001</td>--}}
{{--                            <td>Վանարմկոմպ ՍՊԸ</td>--}}
{{--                            <td>Լոռու մ․, ք․ Վանաձոր, Շինարարների 14</td>--}}
{{--                            <td>Գարիկ Ղուբաթյան</td>--}}
{{--                            <td>37493433212</td>--}}
{{--                            <td>Կարի արտադրամաս</td>--}}
{{--                            <td>911 միացված</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar2.jpeg">&nbsp;1002</td>--}}
{{--                            <td>Մաջիք կոմպ ՍՊԸ</td>--}}
{{--                            <td>Երևան.,Փարաքյար համայնք, Մաշտոցի 1/2</td>--}}
{{--                            <td>Վարդուհի Փաշոյան</td>--}}
{{--                            <td>+37494777041</td>--}}
{{--                            <td>Բենզալցակայան</td>--}}
{{--                            <td>սպասվող</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar3.jpeg">&nbsp;<span style="color: rgb(255, 1, 1);">ՉԿԱ</span></td>--}}
{{--                            <td>Արմեն Մկրտչյան</td>--}}
{{--                            <td>Լոռու մ․, ք․ Վանաձոր, Կնունյանց 43</td>--}}
{{--                            <td>Արսեն Մկրտչյան</td>--}}
{{--                            <td>+37494756057</td>--}}
{{--                            <td>Խանութ</td>--}}
{{--                            <td>կարգ․ փուլ</td>--}}
{{--                        </tr>--}}

@extends('layouts')

@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Оբեկտ</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <a class="btn btn-outline-primary" role="button" href="{{ route('projects.create') }}">
                        Ստեղծել նոր Օբեկտ
                    </a>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Show
                            <select class="form-select form-select-sm d-inline-block" id="perPage">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </label>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <input
                            type="search"
                            class="form-control form-control-sm"
                            id="search"
                            placeholder="Search brand name..."
                            value="{{ request('search') ?? '' }}"
                        >
                    </div>
                </div>

                {{-- Блок, куда будем AJAX-ом загружать таблицу --}}
                <div id="tableData">
                    {{-- Подключаем часть разметки из _table.blade.php --}}
                    @include('projects._table', ['projects' => $projects])
                </div>

            </div>
        </div>
    </div>

    {{-- Подключим jQuery (или используйте свой вариант) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function(){
            // При изменении "сколько записей показывать"
            $('#perPage').on('change', function() {
                fetchData();
            });

            // При вводе в поле поиска
            $('#search').on('keyup', function() {
                // Сделаем небольшую задержку, чтобы не дергать сервер на каждый символ
                // Можно использовать setTimeout, debounce... Но для примера хватит и так
                fetchData();
            });

            function fetchData() {
                // Получаем текущее значение полей
                let perPageVal = $('#perPage').val();
                let searchVal  = $('#search').val();

                $.ajax({
                    url: '{{ route('projects.index') }}',
                    type: 'GET',
                    data: {
                        per_page: perPageVal,
                        search: searchVal,
                        // доп. параметр ajax не обязателен, но можно
                    },
                    success: function(response) {
                        // В ответе придёт JSON вида { html: '...таблица...'}
                        $('#tableData').html(response.html);
                    },
                    error: function(err) {
                        console.log('Ошибка:', err);
                    }
                });
            }
        });
    </script>
@endsection
