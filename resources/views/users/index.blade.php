@extends('layouts')
@section('content')
<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                   <div class="container-fluid">
                    <h3 class="text-dark mb-4">USERS</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Employee Info</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap"> <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 190.078px;">Name</th>
                                            <th style="width: 70.688px;">gmail</th>
                                            <th>number</th>
                                            <th style="padding-top: 0px;padding-left: 169px;">actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }} {{ $user->female }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td style="width: 144.031px;">{{ $user->number }}</td>
                                            <td style="width: 287.234px;">
                                                <form action="{{ route('users.destroy',$user->id) }}" method="POST">

                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">edit</a>
                                                <button class="btn btn-primary" type="button" style="margin-left: 23px;background: rgb(227,48,37);">delete</button>
                                                </form>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong><strong>gmail</strong></strong></td>
                                            <td><strong><strong>number</strong></strong></td>
                                            <td style="padding-left: 169px;"><strong>actions</strong></td>
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
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

</body>
@endsection
