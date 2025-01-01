@extends('layouts')
@section('content')


    <div class="container-fluid">
        <h3 class="text-dark mb-4">Նոր Օբեկտ</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="btn-group d-xxl-flex justify-content-xxl-end" role="group" aria-label="Basic radio toggle button group"><a class="btn btn-outline-primary text-end d-xxl-flex justify-content-xxl-end" role="button" href="i_page-1.html">Update</a></div>
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
                            <th><strong>Օբ․ ID</strong></th>
                            <th><strong>Անվանում</strong></th>
                            <th><strong>Մարզ</strong></th>
                            <th><strong>օբ.Հասցե</strong></th>
                            <th><strong>Տեխ կոնտակտ</strong></th>
                            <th>Տեսակ</th>
                            <th>detals</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg">&nbsp;1001</td>
                            <td>Վանարմկոմպ ՍՊԸ</td>
                            <td>Լոռու մ․</td>
                            <td>ք․ Վանաձոր, Շինարարների 14</td>
                            <td>Գարիկ-093756055</td>
                            <td>Կարի արտադրամաս</td>
                            <td>link to</td>
                        </tr>
                        <tr>
                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar2.jpeg">&nbsp;1002</td>
                            <td>Մաջիք կոմպ ՍՊԸ</td>
                            <td>Երևան.,</td>
                            <td>Փարաքյար համայնք, Մաշտոցի 1/2</td>
                            <td>Վարդուհի Փաշոյան-094777041</td>
                            <td>Բենզալցակայան</td>
                            <td>link to</td>
                        </tr>
                        <tr>
                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar3.jpeg">&nbsp;<span style="color: rgb(255, 1, 1);">1003</span></td>
                            <td>Արմեն Մկրտչյան</td>
                            <td>Լոռու մ</td>
                            <td>ք․ Վանաձոր, Կնունյանց 43</td>
                            <td>Արսեն Մկրտչյան-094555002&nbsp;</td>
                            <td>Խանութ</td>
                            <td>link to</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td><strong>Օբ․ ID</strong></td>
                            <td><strong>Անվանում</strong></td>
                            <td><strong>Մարզ</strong></td>
                            <td><strong>օբ.Հասցե</strong></td>
                            <td><strong>Տեխ կոնտակտ</strong></td>
                            <td><strong>Տեսակ</strong></td>
                            <td><strong>detals</strong></td>
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
@endsection
