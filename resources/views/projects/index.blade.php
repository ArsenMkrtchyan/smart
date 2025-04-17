{{--@extends('layouts')--}}

{{--@section('content')--}}
{{--    <div class="container-fluid">--}}
{{--        <h3 class="text-dark mb-4">Оբեկտ</h3>--}}
{{--        <div class="card shadow">--}}
{{--            <div class="card-header py-3">--}}
{{--                <a class="btn btn-outline-primary" role="button" href="{{ route('projects.create') }}">--}}
{{--                    Ստեղծել նոր Օբեկտ--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            <div class="card-body">--}}

{{--                <div class="row mb-3">--}}
{{--                    <div class="col-auto">--}}
{{--                        <label for="objectCheckSelect">Фильтр по статусу:</label>--}}
{{--                        <select id="objectCheckSelect" class="form-select">--}}
{{--                            <option value="">Все</option>--}}
{{--                            <option value="1">սպասվող</option>--}}
{{--                            <option value="2">Հրաժարված</option>--}}
{{--                            <option value="3">Պայմանագիրը լուծարված</option>--}}
{{--                            <option value="4">Պայմանագրի ընդացք</option>--}}
{{--                            <option value="5">կարգավորման ընդացք</option>--}}
{{--                            <option value="6">911-ին միացված</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="col-auto d-flex align-items-end">--}}
{{--                    <span class="ms-2">--}}
{{--                        Совпадений: <strong id="objectCountSpan">{{ $totalCount ?? '' }}</strong>--}}
{{--                    </span>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="row mb-3">--}}
{{--                    <!-- Выбор кол-ва записей -->--}}
{{--                    <div class="col-md-6">--}}
{{--                        <label class="form-label">--}}
{{--                            Показать--}}
{{--                            <select class="form-select form-select-sm d-inline-block" id="perPage">--}}
{{--                                <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10</option>--}}
{{--                                <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25</option>--}}
{{--                                <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50</option>--}}
{{--                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>--}}
{{--                            </select>--}}
{{--                        </label>--}}
{{--                        <div class="form-check form-switch">--}}
{{--                            <input class="form-check-input" type="checkbox" id="filterIdentNull">--}}
{{--                            <label class="form-check-label" for="filterIdentNull">Received</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                    <!-- Поиск -->--}}
{{--                    <div class="col-md-6 text-md-end">--}}
{{--                        <input--}}
{{--                            type="search"--}}
{{--                            class="form-control form-control-sm"--}}
{{--                            id="search"--}}
{{--                            placeholder="Поиск (фирма, идентификатор)..."--}}
{{--                            value="{{ request('search') ?? '' }}"--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Контейнер для таблицы -->--}}
{{--                <div id="tableData" class="table-responsive">--}}
{{--                    @include('projects._table', ['projects' => $projects])--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{-- jQuery --}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script>--}}
{{--        $(function() {--}}

{{--            // При смене objectCheckSelect:--}}
{{--            $('#objectCheckSelect').on('change', function(){--}}
{{--                fetchData();--}}
{{--            });--}}

{{--            // При смене perPage:--}}
{{--            $('#perPage').on('change', function(){--}}
{{--                fetchData();--}}
{{--            });--}}

{{--            // При вводе в search:--}}
{{--            // (добавим задержку - debounce - если хотим)--}}
{{--            $('#search').on('keyup', function(){--}}
{{--                // Можно поставить setTimeout, но для примера просто так--}}
{{--                fetchData();--}}
{{--            });--}}
{{--            $('#filterIdentNull').on('change', function() {--}}
{{--                fetchData();--}}
{{--            });--}}

{{--            function fetchData() {--}}
{{--                let objectCheckVal = $('#objectCheckSelect').val();--}}
{{--                let perPageVal = $('#perPage').val();--}}
{{--                let searchVal = $('#search').val();--}}
{{--                let filterIdentNull = $('#filterIdentNull').is(':checked'); // Проверяем, установлен ли чекбокс--}}

{{--                $.ajax({--}}
{{--                    url: '{{ route('projects.index') }}',--}}
{{--                    type: 'GET',--}}
{{--                    data: {--}}
{{--                        object_check: objectCheckVal,--}}
{{--                        per_page: perPageVal,--}}
{{--                        search: searchVal,--}}
{{--                        filter_ident_null: filterIdentNull,--}}
{{--                    },--}}
{{--                    dataType: 'json',--}}
{{--                    success: function(response){--}}
{{--                        // Обновим HTML таблицы--}}
{{--                        $('#tableData').html(response.html);--}}
{{--                        // Обновим счётчик--}}
{{--                        $('#objectCountSpan').text(response.count);--}}
{{--                    },--}}
{{--                    error: function(err){--}}
{{--                        console.log('Ошибка AJAX:', err);--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}

{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
@extends('layouts')

@section('content')
    <head>
        <style>
            /* горизонтальный скролл только при необходимости */
            .table-responsive-x {
                width: 100%;
                overflow-x: auto;
            }

            /* на узких экранах чуть уменьшим размер шрифта таблицы */
            @media (max-width: 576px) {
                table.table {
                    font-size: 0.875rem;
                }
                .sidebar {
                    /* даём возможность свайп‑скролла меню */
                    -webkit-overflow-scrolling: touch;
                }
            }
        </style>
    </head>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Օբեկտ</h3>

        {{--‑‑‑ Фильтры / счётчик ‑‑‑--}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap gap-3 align-items-end">
                <a href="{{ route('projects.create') }}" class="btn btn-outline-primary flex-grow-1 flex-sm-grow-0">
                    Ստեղծել նոր Օբեկտ
                </a>

                <div class="ms-sm-auto d-flex flex-column flex-sm-row flex-grow-1 flex-sm-grow-0 gap-2">
                    <div>
                        <label for="objectCheckSelect" class="form-label mb-0">Ֆильтр</label>
                        <select id="objectCheckSelect" class="form-select form-select-sm">
                            <option value="">Все</option>
                            <option value="1">սպասվող</option>
                            <option value="2">Հրաժարված</option>
                            <option value="3">Պայմանագիրը լուծարված</option>
                            <option value="4">Պայմանագրի ընդացք</option>
                            <option value="5">կարգավորման ընդացք</option>
                            <option value="6">911-ին միացված</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-end">
                        Совпадений:&nbsp;<strong id="objectCountSpan">{{ $totalCount ?? '' }}</strong>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{--‑‑‑ Выбор кол‑ва / чекбокс / поиск ‑‑‑--}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6 d-flex flex-column flex-sm-row align-items-start gap-2">
                        <label class="form-label mb-0">
                            Показать
                            <select id="perPage" class="form-select form-select-sm d-inline-block w-auto">
                                <option value="10"  @selected(request('per_page') == 10 )>10</option>
                                <option value="25"  @selected(request('per_page') == 25 )>25</option>
                                <option value="50"  @selected(request('per_page') == 50 )>50</option>
                                <option value="100" @selected(request('per_page') == 100)>100</option>
                            </select>
                        </label>

                        <div class="form-check form-switch ms-sm-3">
                            <input type="checkbox" id="filterIdentNull" class="form-check-input">
                            <label for="filterIdentNull" class="form-check-label">Received</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <input type="search"
                               id="search"
                               class="form-control form-control-sm"
                               placeholder="Поиск (фирма, идентификатор)…"
                               value="{{ request('search') ?? '' }}">
                    </div>
                </div>

                {{--‑‑‑ Таблица (гориз‑скролл на мобиле) ‑‑‑--}}
                <div class="table-responsive-x" id="tableData">
                    @include('projects._table', ['projects' => $projects])
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery + скрипт --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-3fpdpIvT0YIShZj7OVz1Q0Jt08Jc9N1SOeJoXxNumwA="
                crossorigin="anonymous"></script>

        <script>
            (() => {
                const $objectCheck = $('#objectCheckSelect'),
                    $perPage     = $('#perPage'),
                    $search      = $('#search'),
                    $filterNull  = $('#filterIdentNull');

                // debounce — 0.4 сек.
                const debounce = (fn, ms = 400) => {
                    let timer;
                    return (...args) => {
                        clearTimeout(timer);
                        timer = setTimeout(() => fn.apply(this, args), ms);
                    };
                };

                function fetchData() {
                    $.get({
                        url: '{{ route('projects.index') }}',
                        data: {
                            object_check      : $objectCheck.val(),
                            per_page          : $perPage.val(),
                            search            : $search.val(),
                            filter_ident_null : $filterNull.is(':checked')
                        },
                        dataType: 'json',
                        success(resp) {
                            $('#tableData').html(resp.html);
                            $('#objectCountSpan').text(resp.count);
                        },
                        error: err => console.error('AJAX error →', err)
                    });
                }

                $objectCheck.on('change', fetchData);
                $perPage.on('change',    fetchData);
                $filterNull.on('change', fetchData);
                $search.on('input', debounce(fetchData));
            })();
        </script>
    @endpush
@endsection
