@extends('layouts')
@section('content')

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Prices</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Price Info</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <a class="btn btn-success" href="{{ route('prices.create') }}">Create New Price</a>
                    </div>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                            <tr>
                                <th>Price Name</th>
                                <th>Detail</th>
                                <th>Amount</th>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prices as $price)
                                <tr>
                                    <td>{{ $price->price_name }}</td>
                                    <td>{{ $price->detail }}</td>
                                    <td>{{ $price->amount }}</td>
                                    <td>{{ optional($price->user)->name ?? 'N/A' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('prices.destroy', $price->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-primary">Edit</a>
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Price Name</th>
                                <th>Detail</th>
                                <th>Amount</th>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
            </div>
        </footer>
    </div>
@endsection
