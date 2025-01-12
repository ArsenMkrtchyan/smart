@extends('layouts')
{{-- Или ваш другой базовый макет --}}
@section('content')

    <div class="container mt-4">
        <h3>Список инвойсов (invoices_...)</h3>
        <form action="{{ route('invoice.download') }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary">
                Make invoice
            </button>
        </form>
        @if(count($invoices) === 0)
            <div class="alert alert-info mt-3">
                Нет файлов, начинающихся на "invoices_".
            </div>
        @else
            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Название файла</th>
                        <th scope="col" style="width: 150px;">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $index => $filename)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $filename }}</td>
                            <td>
                                <a href="{{ route('projects.downloadInvoice', ['filename' => $filename]) }}"
                                   class="btn btn-sm btn-primary">
                                    Скачать
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
