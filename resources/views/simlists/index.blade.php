@extends('layouts')
@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Sim List</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group"><a class="btn btn-outline-primary" role="button" href="{{route('simlists.create')}}"><strong>ավելացնել Sim</strong></a>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="filterIdentNull">
                        <label class="form-check-label" for="filterIdentNull">ident_id == null</label>
                    </div>
            </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-nowrap">
                            <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                <label class="form-label">Show
                                    <select class="form-select form-select-sm d-inline-block" id="perPage">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </label>
                            </div>
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
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <div id="tableData">
                           @include('simlists._table', ['simlists' => $simlists])
                        </div>
                    </div>

                </div>
            </div>
        </div>

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
                        url: '{{ route('simlists.index') }}',
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
        <script>$(function(){
                // Обработка события изменения чекбокса
                $('#filterIdentNull').on('change', function() {
                    fetchData();
                });

                // При изменении "сколько записей показывать"
                $('#perPage').on('change', function() {
                    fetchData();
                });

                // При вводе в поле поиска
                $('#search').on('keyup', function() {
                    fetchData();
                });

                function fetchData() {
                    // Получаем текущее значение полей
                    let perPageVal = $('#perPage').val();
                    let searchVal  = $('#search').val();
                    let filterIdentNull = $('#filterIdentNull').is(':checked'); // Проверяем, установлен ли чекбокс

                    $.ajax({
                        url: '{{ route('simlists.index') }}',
                        type: 'GET',
                        data: {
                            per_page: perPageVal,
                            search: searchVal,
                            filter_ident_null: filterIdentNull, // Отправляем значение чекбокса
                        },
                        success: function(response) {
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
