@extends('layouts')

@section('content')
    <div class="container">
        <h3>Создать акт</h3>

        <form action="{{ route('uniques.store') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label">Проект (act_enable = 1)</label>
                <select name="project_id" class="form-select" required>
                    <option value="">— выберите —</option>
                    @foreach($projects as $id=>$name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-2">
                <div class="col"><input class="form-control" name="paymanagir_hamar"  placeholder="№ договора"></div>
                <div class="col"><input class="form-control" type="date" name="paymanagir_date"  placeholder="Дата договора"></div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col"><input class="form-control" type="date" name="matucman_date" placeholder="Дата вступления"></div>
                <div class="col"><input class="form-control" name="carayutyan_anun" placeholder="Наименование услуги"></div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col"><input class="form-control" name="gumar" placeholder="Сумма"></div>
                <div class="col"><input class="form-control" type="date" name="export_date" placeholder="Export date"></div>
            </div>

            <button class="btn btn-success mt-3">Сохранить</button>
            <a href="{{ route('uniques.index') }}" class="btn btn-secondary mt-3">Отмена</a>
        </form>
    </div>
@endsection
