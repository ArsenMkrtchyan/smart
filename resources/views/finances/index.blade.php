@extends('layouts')

@section('content')
    <div class="container">
        <h1>Finances</h1>

        <!-- Селект для выбора года -->
        <div class="mb-3">
            <label for="yearSelect" class="form-label">Select Year:</label>
            <select id="yearSelect" class="form-select">
                <option value="">-- Select Year --</option>
            </select>
        </div>

        <!-- Таблица для месяцев -->
        <h2>Months</h2>
        <table class="table table-bordered" id="monthsTable">
            <thead>
            <tr>
                <th>Month Year</th>
                <th>Total Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="2" class="text-center text-muted">No data</td></tr>
            </tbody>
        </table>

        <!-- Поле поиска для проектов -->
        <h2 class="mt-5">Projects for Selected Month</h2>
        <div class="mb-3">
            <label for="searchProjects" class="form-label">Search Projects:</label>
            <input type="text" id="searchProjects" class="form-control" placeholder="Enter search text">
        </div>

        <!-- Таблица проектов -->
        <table class="table table-bordered" id="projectsTable">
            <thead>
            <tr>
                <th>Project Name</th>
                <th>Amount</th>
                <th>Pay</th>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
            </tbody>
        </table>
    </div>
@endsection

<!-- Подключаем jQuery (если ещё не подключён) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var currentMonthYear = null;

        // Загрузка годов (предполагается, что у вас уже есть метод getYears)
        $.ajax({
            url: "{{ route('finances.getYears') }}",
            method: "GET",
            success: function(data) {
                var yearSelect = $("#yearSelect");
                yearSelect.empty();
                yearSelect.append('<option value="">-- Select Year --</option>');
                data.forEach(function(year) {
                    yearSelect.append('<option value="' + year + '">' + year + '</option>');
                });
            }
        });

        // При выборе года загружаем месяцы
        $("#yearSelect").on("change", function() {
            var year = $(this).val();
            if (!year) {
                $("#monthsTable tbody").html('<tr><td colspan="2" class="text-center text-muted">No data</td></tr>');
                $("#projectsTable tbody").html('<tr><td colspan="3" class="text-center text-muted">No data</td></tr>');
                return;
            }

            $.ajax({
                url: "{{ route('finances.getMonths') }}",
                method: "GET",
                data: { year: year },
                success: function(data) {
                    var tbody = $("#monthsTable tbody");
                    tbody.empty();
                    if (data.length === 0) {
                        tbody.html('<tr><td colspan="2" class="text-center text-muted">No data</td></tr>');
                        return;
                    }
                    data.forEach(function(item) {
                        var row = '<tr>' +
                            '<td><a href="#" class="month-link" data-monthyear="' + item.monthYear + '">' + item.monthYear + '</a></td>' +
                            '<td>' + item.amount + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                }
            });
        });

        // При клике на месяц сохраняем выбранный месяц и загружаем проекты за этот месяц
        $(document).on("click", ".month-link", function(e) {
            e.preventDefault();
            currentMonthYear = $(this).data("monthyear");
            $("#searchProjects").val(""); // Сбрасываем текст поиска
            loadProjects(currentMonthYear, "");
        });

        // Обработчик поля поиска: при каждом вводе текста выполняется AJAX-запрос
        $("#searchProjects").on("keyup", function() {
            var query = $(this).val();
            if (currentMonthYear) {
                loadProjects(currentMonthYear, query);
            }
        });

        // Функция для загрузки проектов по выбранному месяцу и поисковому запросу
        function loadProjects(monthYear, query) {
            $.ajax({
                url: "{{ route('finances.searchProjects') }}",
                method: "GET",
                data: {
                    monthYear: monthYear,
                    query: query
                },
                success: function(data) {
                    var tbody = $("#projectsTable tbody");
                    tbody.empty();
                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="3" class="text-center text-muted">No data</td></tr>');
                    } else {
                        data.forEach(function(item) {
                            // Формируем ссылку для оплаты (заменяем :id на finance_id)
                            var payUrl = "{{ route('payments.create', ':id') }}".replace(':id', item.finance_id);
                            var row = '<tr>' +
                                '<td>' + item.project_name + '</td>' +
                                '<td>' + item.amount + '</td>' +
                                '<td><a href="' + payUrl + '" class="btn btn-success btn-sm">Pay</a></td>' +
                                '</tr>';
                            tbody.append(row);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Ошибка запроса:", error);
                }
            });
        }
    });
</script>
