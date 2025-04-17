@extends('layouts')

@section('content')
    <div class="container">
        <h3>Редактировать акт #{{ $unique->id }}</h3>

        <form action="{{ route('uniques.update',$unique) }}" method="post">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Проект</label>
                <select name="project_id" class="form-select" required>
                    @foreach($projects as $id=>$name)
                        <option value="{{ $id }}" {{ $unique->project_id==$id?'selected':'' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            @php
                $f = fn(string $field)=>old($field,$unique->$field);
            @endphp

            <div class="row g-2">
                <div class="col"><input class="form-control" name="paymanagir_hamar" value="{{ $f('paymanagir_hamar') }}" placeholder="№ договора"></div>
                <div class="col"><input class="form-control" type="date" name="paymanagir_date" value="{{ $f('paymanagir_date') }}"></div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col"><input class="form-control" type="date" name="matucman_date" value="{{ $f('matucman_date') }}"></div>
                <div class="col"><input class="form-control" name="carayutyan_anun" value="{{ $f('carayutyan_anun') }}" placeholder="Наименование услуги"></div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col"><input class="form-control" name="gumar" value="{{ $f('gumar') }}" placeholder="Сумма"></div>
                <div class="col"><input class="form-control" type="date" name="export_date" value="{{ $f('export_date') }}"></div>
            </div>

            <button class="btn btn-success mt-3">Сохранить</button>
            <a href="{{ route('uniques.index') }}" class="btn btn-secondary mt-3">Отмена</a>
        </form>
    </div>
@endsection
