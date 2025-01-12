@extends('layouts')
@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Object</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Object info</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <a class="btn btn-success" href="{{ route('simlists.create') }}">Create New Sim info</a>
                    </div>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                            <tr>
                                <th><strong>SIM Համար</strong></th>
                                <th><strong>SIM Կոդ ICMC</strong></th>
                                <th><strong>Օպերատոր</strong></th>
                                <th><strong>Պահեստ</strong></th>
                                <th><strong>Իդենտ համարը</strong></th>
                                <th><strong>ամսաթիվ</strong></th>
                                <th><strong>Գործողություն</strong></th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($simlists as $simlist)
                                <tr>
                                    <td> {{$simlist->number}}</td>
                                    <td> {{$simlist->sim_info}}</td>
                                    <td> {{$simlist->sim_id}}</td>

                                    <td> {{$simlist->worker->name}} - {{$simlist->worker->female}}</td>
                                    @if($simlist->ident_id == null)

                                        <td>-</td>
                                    @else
                                        <td>{{$simlist->ident_id}}</td>
                                    @endif
                                    <td> {{$simlist->number}}</td>
                                    <td style="padding-left: 169px;">
                                        <form  method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('simlists.edit', $simlist->id) }}" class="btn btn-primary">Edit</a>
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td><strong>Sim Number</strong></td>
                                <td><strong>Sim Code</strong></td>
                                <td><strong> Action</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                <ul class="pagination">
                                    <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                </ul>
                            </nav>
                        </div>
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
