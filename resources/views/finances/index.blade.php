@extends('finances.app')

@section('content')
    <div class="container">
        <h1>Finances</h1>

        {{-- Селект для выбора года --}}
        <div class="mb-3">
            <label for="yearSelect" class="form-label">Select Year:</label>
            <select id="yearSelect" class="form-select">
                <option value="">-- Select Year --</option>
            </select>
        </div>

        {{-- Таблица для месяцев --}}
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

        {{-- Таблица для проектов конкретного месяца --}}
        <h2 class="mt-5">Projects for Selected Month</h2>
        <table class="table table-bordered" id="projectsTable">
            <thead>
            <tr>
                <th>Project ID</th>
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

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){

            // Загружаем годы
            $.ajax({
                url: "{{ route('finances.getYears') }}",
                method: 'GET',
                success: function(data) {
                    // data - массив годов
                    var yearSelect = $('#yearSelect');
                    yearSelect.append('<option value="">-- Select Year --</option>');
                    data.forEach(function(y){
                        yearSelect.append('<option value="'+y+'">'+y+'</option>');
                    });
                }
            });

            // Событие при изменении года
            $('#yearSelect').on('change', function(){
                var year = $(this).val();
                if (!year) {
                    // Очистим таблицы
                    $('#monthsTable tbody').html('<tr><td colspan="2" class="text-center text-muted">No data</td></tr>');
                    $('#projectsTable tbody').html('<tr><td colspan="3" class="text-center text-muted">No data</td></tr>');
                    return;
                }

                // Загружаем месяцы
                $.ajax({
                    url: "{{ route('finances.getMonths') }}",
                    method: 'GET',
                    data: {year: year},
                    success: function(data) {
                        var tbody = $('#monthsTable tbody');
                        tbody.empty();
                        if (data.length === 0) {
                            tbody.html('<tr><td colspan="2" class="text-center text-muted">No data</td></tr>');
                            return;
                        }

                        data.forEach(function(row){
                            var tr = $('<tr></tr>');
                            tr.append('<td><a href="#" class="month-link" data-monthyear="'+row.monthYear+'">'+row.monthYear+'</a></td>');
                            tr.append('<td>'+row.amount+'</td>');
                            tbody.append(tr);
                        });
                    }
                });
            });

            // При клике на месяц, загружаем проекты
            $(document).on('click', '.month-link', function(e){
                e.preventDefault();
                var monthYear = $(this).data('monthyear');

                $.ajax({
                    url: "{{ route('finances.getProjects') }}",
                    method: 'GET',
                    data: {monthYear: monthYear},
                    success: function(data) {
                        var tbody = $('#projectsTable tbody');
                        tbody.empty();
                        if (data.length === 0) {
                            tbody.html('<tr><td colspan="3" class="text-center text-muted">No data</td></tr>');
                            return;
                        }

                        data.forEach(function(f){
                            var payUrl = "{{ route('payments.create', ':id') }}".replace(':id', f.finance_id);
                            var tr = $('<tr></tr>');
                            tr.append('<td>'+f.project_id+'</td>');
                            tr.append('<td>'+f.amount+'</td>');
                            tr.append('<td><a href="'+payUrl+'" class="btn btn-success btn-sm">Pay</a></td>');
                            tbody.append(tr);
                        });
                    }
                });
            });

        });
    </script>
@endsection
