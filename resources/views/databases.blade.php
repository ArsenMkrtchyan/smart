@extends('layouts')
{{-- Или ваш другой layout --}}
@section('content')
    <div class="container mt-4">
        <h1>Databases Backup</h1>

        {{-- Кнопка Backup DB --}}
        <form action="{{ route('db.backup') }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary">
                Backup DB
            </button>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Таблица --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                <tr>
                    <th style="width: 70%">Name</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($files as $file)
                    @php
                        $filename = basename($file);
                    @endphp
                    <tr>
                        <td>{{ $filename }}</td>
                        <td>
                            <a href="{{ route('db.download', ['file' => $file]) }}"
                               class="btn btn-sm btn-success">
                                Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No backup files found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
