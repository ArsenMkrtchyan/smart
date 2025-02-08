@extends('layouts')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h1>Add Payment</h1>
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <!-- Скрытое поле для передачи project_id -->
            <input type="hidden" name="project_id" value="{{ $finance->project_id }}">

            <div class="mb-3">
                <label for="finance_id" class="form-label">Finance ID</label>
                <input type="text" class="form-control" name="finance_id" value="{{ $finance->id }}" readonly>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Payment Date</label>
                <input type="date" class="form-control" name="date">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <input type="text" class="form-control" name="description">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
