@extends('layouts')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Редактировать пользователя</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="col">
                    <label for="female" class="form-label">Пол</label>
                    <input type="text" name="female" class="form-control" value="{{ $user->female }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="firm_name" class="form-label">Название компании</label>
                    <input type="text" name="firm_name" class="form-control" value="{{ $user->firm_name }}">
                </div>
                <div class="col">
                    <label for="address" class="form-label">Адрес</label>
                    <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="balance" class="form-label">Баланс</label>
                <input type="number" name="balance" class="form-control" value="{{ $user->balance }}">
            </div>

            <div class="mb-3">
                <label for="number" class="form-label">Номер телефона</label>
                <input type="text" name="number" class="form-control" value="{{ $user->number }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Роль</label>
                <select name="role_id" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(auth()->user()->role_id === 4 && auth()->user()->is_admin)
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_admin" class="form-check-input" value="1" id="is_admin" {{ $user->is_admin ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">Администратор</label>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="havayrole" class="form-check-input" value="1" id="havayrole" {{ $user->havayrole ? 'checked' : '' }}>
                    <label class="form-check-label" for="havayrole">Активировать роль</label>
                </div>
            @endif

            <div class="mb-3">
                <label for="password" class="form-label">Пароль (оставьте пустым, чтобы не изменять)</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection
