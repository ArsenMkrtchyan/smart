@extends('layouts')

@section('content')
    <div class="container">
        <h1>Add Deposit Payment for {{ $project->firm_name ?? 'Project #'.$project->id }}</h1>
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="finance_id" value="">
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" name="amount" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <input type="text" class="form-control" name="description">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
   
@endsection
