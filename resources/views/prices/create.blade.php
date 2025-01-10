@extends('layouts')
@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Create Price</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">New Price</p>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('prices.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="price_name" class="form-label">Price Name:</label>
                        <input type="text" id="price_name" name="price_name" class="form-control @error('price_name') is-invalid @enderror" required>
                        @error('price_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail" class="form-label">Detail:</label>
                        <input type="text" id="detail" name="detail" class="form-control @error('detail') is-invalid @enderror" required>
                        @error('detail')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">Amount:</label>
                        <input type="number" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" required>
                        @error('amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Add Price</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
