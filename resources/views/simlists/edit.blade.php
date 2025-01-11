@extends('layouts')
@section('content')

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Edit Sim info</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Update Sim</p>
            </div>
            <div class="card-body">
                {{-- Вывод ошибок валидации --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Сообщение об успехе (если есть) --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Форма редактирования --}}
                <form action="{{ route('simlists.update', $simlist->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Важно: метод PUT, а не POST -->

                    <div class="form-group">
                        <label for="number">SIM Համար</label>
                        <input
                            type="text"
                            name="number"
                            class="form-control"
                            required
                            value="{{ old('number', $simlist->number) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="sim_info">SIM Կոդ ICMC</label>
                        <input
                            type="text"
                            name="sim_info"
                            class="form-control"
                            required
                            value="{{ old('sim_info', $simlist->sim_info) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="sim_id">Օպերատոր</label>
                        <select class="form-control" name="sim_id">
                            {{-- Пустой вариант --}}
                            <option value="" {{ is_null(old('sim_id', $simlist->sim_id)) ? 'selected' : '' }}>
                                - ընտրել -
                            </option>
                            <optgroup label="operators">
                                <option value="Viva"
                                    {{ old('sim_id', $simlist->sim_id) === 'Viva' ? 'selected' : '' }}>
                                    Viva
                                </option>
                                <option value="Ucom"
                                    {{ old('sim_id', $simlist->sim_id) === 'Ucom' ? 'selected' : '' }}>
                                    Ucom
                                </option>
                                <option value="Team"
                                    {{ old('sim_id', $simlist->sim_id) === 'Team' ? 'selected' : '' }}>
                                    Team
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    {{-- Если вам нужно сохранить worker_id --}}
                    <div class="form-group">
                        <label for="sim_id">Օպերատոր</label>
                        <select class="form-control" name="sim_id">

                            {{-- Пустой вариант --}}

                            <optgroup label="operators">
                                @foreach($workers as $worker)
                                    <option  value="{{$worker->id}}" {{ $simlist->price_id == $worker->id ? 'selected' : '' }}  > {{$worker->name}}-{{$worker->female}} </option>
                            @endforeach
                            </optgroup>

                        </select>

                    </div>



                    <div class="form-group">
                        <label for="price">Գին</label>
                        <input
                            type="number"
                            name="price"
                            class="form-control"
                            value="{{ old('price', $simlist->price) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="mb">MB-ի Չափը</label>
                        <input
                            type="number"
                            name="mb"
                            class="form-control"
                            value="{{ old('mb', $simlist->mb) }}"
                        >
                    </div>

                    {{-- Кнопка отправки --}}
                    <button type="submit" class="btn btn-primary">
                        Update Sim
                    </button>
                </form>
            </div> <!-- /card-body -->
        </div> <!-- /card shadow -->
    </div> <!-- /container-fluid -->

@endsection
