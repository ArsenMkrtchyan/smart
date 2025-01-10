@extends('layouts')

@section('content')
    <div class="container card">
        <h1 class="text-center mb-4">Добавить новое оборудование</h1>
        <form action="{{ route('hardwares.store') }}" method="POST" class="card-body">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название оборудования</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="serial" class="form-label">Серийный номер</label>
                <input type="text" name="serial" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ident_number" class="form-label">Идентификационный номер</label>
                <input type="text" name="ident_number" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kargavichak" class="form-label">Количество</label>
                <input type="number" name="kargavichak" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="worker_id" class="form-label">Ответственный работник</label>
                <select name="worker_id" class="form-select" required>
                    <option value="">Выберите работника</option>
                    @foreach($workers as $worker)
                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Поле project_id не отображается, поскольку оно всегда будет null -->

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
