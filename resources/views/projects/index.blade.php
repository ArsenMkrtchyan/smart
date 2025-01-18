@extends('layouts')

@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Оբեկտ</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <a class="btn btn-outline-primary" role="button" href="{{ route('projects.create') }}">
                    Ստեղծել նոր Օբեկտ
                </a>

            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-auto">
                        <label for="objectCheckSelect">Фильтр по статусу:</label>
                        <select id="objectCheckSelect" class="form-select">
                            <option value="">Все</option>
                            <option value="1">սպասվող</option>
                            <option value="2">Հրաժարված</option>
                            <option value="3">Պայմանագիրը լուծարված</option>
                            <option value="4">Պայմանագրի ընդացք</option>
                            <option value="5">կարգավորման ընդացք</option>
                            <option value="6">911-ին միացված</option>
                        </select>
                    </div>
                    <div class="col-auto d-flex align-items-end">
                    <span class="ms-2">
                        Совпадений: <strong id="objectCountSpan">{{ $totalCount ?? '' }}</strong>
                    </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Выбор кол-ва записей -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Показать
                            <select class="form-select form-select-sm d-inline-block" id="perPage">
                                <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10</option>
                                <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25</option>
                                <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="filterIdentNull">
                            <label class="form-check-label" for="filterIdentNull">Received</label>
                        </div>
                    </div>


                    <!-- Поиск -->
                    <div class="col-md-6 text-md-end">
                        <input
                            type="search"
                            class="form-control form-control-sm"
                            id="search"
                            placeholder="Поиск (фирма, идентификатор)..."
                            value="{{ request('search') ?? '' }}"
                        >
                    </div>
                </div>

                <!-- Контейнер для таблицы -->
                <div id="tableData">
                    @include('projects._table', ['projects' => $projects])
                </div>

            </div>
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {

            // При смене objectCheckSelect:
            $('#objectCheckSelect').on('change', function(){
                fetchData();
            });

            // При смене perPage:
            $('#perPage').on('change', function(){
                fetchData();
            });

            // При вводе в search:
            // (добавим задержку - debounce - если хотим)
            $('#search').on('keyup', function(){
                // Можно поставить setTimeout, но для примера просто так
                fetchData();
            });
            $('#filterIdentNull').on('change', function() {
                fetchData();
            });

            function fetchData() {
                let objectCheckVal = $('#objectCheckSelect').val();
                let perPageVal = $('#perPage').val();
                let searchVal = $('#search').val();
                let filterIdentNull = $('#filterIdentNull').is(':checked'); // Проверяем, установлен ли чекбокс

                $.ajax({
                    url: '{{ route('projects.index') }}',
                    type: 'GET',
                    data: {
                        object_check: objectCheckVal,
                        per_page: perPageVal,
                        search: searchVal,
                        filter_ident_null: filterIdentNull,
                    },
                    dataType: 'json',
                    success: function(response){
                        // Обновим HTML таблицы
                        $('#tableData').html(response.html);
                        // Обновим счётчик
                        $('#objectCountSpan').text(response.count);
                    },
                    error: function(err){
                        console.log('Ошибка AJAX:', err);
                    }
                });
            }

        });
    </script>
@endsection
