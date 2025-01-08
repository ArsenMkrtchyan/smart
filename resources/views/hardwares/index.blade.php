
@extends('layouts')
@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Սարքավորումներ</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group"><a class="btn btn-outline-primary" role="button" href="i_page-1.html"><strong>ավելացնել Սարք</strong></a><a class="btn btn-outline-primary" role="button" href="i_page-1.html"><strong>Տեղափոխել</strong></a></div>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group"><a class="btn btn-outline-primary" role="button" href="hardware-sim.html"><strong>Վաճառել</strong></a></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                    <option value="10" selected="">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>&nbsp;</label></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                        <tr>
                            <th><strong>Անվանում</strong></th>
                            <th><strong>Serial</strong></th>
                            <th>Պահեստ</th>
                            <th>Իդենտ․ համար</th>
                            <th>Ամսաթիվ</th>
                            <th>Կարգավիճակ</th>
                            <th>Գործողություն</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>NAVIGARD</td>
                            <td>0931778545</td>
                            <td>Գարիկ Ղուբաթյան</td>
                            <td>-</td>
                            <td>18,12,2024</td>
                            <td>Վաճառված</td>
                            <td>edit,</td>
                        </tr>
                        <tr>
                            <td>NAVIGARD 206</td>
                            <td>654546556</td>
                            <td>Վարդուհի Փաշոյան</td>
                            <td>1002</td>
                            <td>18,12,2024</td>
                            <td>տեղադրված</td>
                            <td>edit</td>
                        </tr>
                        <tr>
                            <td>Satel xz</td>
                            <td>1348844555</td>
                            <td>Արսեն Մկրտչյան</td>
                            <td></td>
                            <td>18,12,2024</td>
                            <td>պահեստում</td>
                            <td>edit</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td><strong>Անվանում</strong></td>
                            <td><strong>Serial</strong></td>
                            <td><strong>Պահեստ</strong></td>
                            <td><strong>Իդենտ․ համար</strong></td>
                            <td><strong>Ամսաթիվ</strong></td>
                            <td><strong>Կարգավիճակ</strong></td>
                            <td><strong>Գործողություն</strong></td>
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

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
@endsection


