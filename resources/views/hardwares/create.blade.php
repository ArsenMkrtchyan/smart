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
                <label for="kargavichak" class="form-label">Количество</label>
                <input type="number" name="kargavichak" class="form-control" required>
            </div>

            <input value="1" type="hidden" name="worker_id">


            <!-- Поле project_id не отображается, поскольку оно всегда будет null -->

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
