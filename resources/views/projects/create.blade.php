@extends('layouts')
@section('content')



    <div class="container-fluid">
        <h3 class="text-dark mb-4">Profile</h3>





<form action="{{route('projects.storeAll')}}" method="POST" enctype="multipart/form-data">
@csrf
        {{-- Группа радиокнопок (Гլխավոր / Տեխնիկական / ադմին տեխնիկական) --}}
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" autocomplete="off" class="btn-check" id="btnradio1" name="btnradio" checked>
            <label class="form-label btn btn-outline-primary" for="btnradio1">Գլխավոր</label>

            <input type="radio" autocomplete="off" class="btn-check" id="btnradio2" name="btnradio">
            <label class="form-label btn btn-outline-primary" for="btnradio2">Տեխնիկական</label>

            <input type="radio" autocomplete="off" class="btn-check" id="btnradio2-1" name="btnradio">
            <label class="form-label btn btn-outline-primary" for="btnradio2-1">ադմին տեխնիկական</label>
        </div>

        {{-- Форма --}}


            {{-- --------------------- ГЛАВНАЯ (Ֆիզիկական лицо) --------------------- --}}

            <input type="hidden" name="phy_jur" id="phy_jur" value="0">
            <div id="physicalMain" style="display: block;"><!-- Сразу показываем -->
                <div class="col-lg-8 col-xxl-11">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    {{-- Селекты и поля для физ. лица --}}
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-4">
                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                        <option value="1">Իրավաբանական</option>
                                                        <option value="0" selected>Ֆիզիկական</option>
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select">Իրավաբանական/Ֆիզիկական</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5" name="type_id" >
                                                    <option value="" selected="">Ընտրեք</option>

                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                      @foreach($types as $type)

                                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                                      @endforeach

                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5">Օբեկտի տիպ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="first_name-1" name="ceo_name" placeholder=" ">
                                                <label for="first_name-3">անուն ազգանուն</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-1" name="andznagir" placeholder=" ">
                                                <label for="last_name-3">Անձնագիր</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-3" name="soc" placeholder=" ">
                                                <label for="last_name-3">Սոց քարտ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-2" name="id_card" placeholder=" ">
                                                <label for="last_name-2">ID քարտ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-7" name="ceo_phone" placeholder=" ">
                                                <label for="last_name-3">հեռախոսահամար</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-4" name="firm_email" placeholder=" ">
                                                <label for="last_name-3"><strong>email</strong></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select name="firm_bank" class="form-select form-select" id="bank-select-1" >
                                                    <optgroup label="Ընտրել">

                                                        <option value="konvers">Կոնվերս բանկ ԲԲԸ</option>
                                                        <option value="ameria">Ամերիաբանկ ԲԲԸ</option>
                                                    </optgroup>
                                                </select>
                                                <label for="bank-select">բանկ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-5" name="brand_name" placeholder=" ">
                                                <label for="last_name-5">Բրենդի անվանում</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <!-- Пусто -->
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-5" name="firm_bank_hh" placeholder=" ">
                                                <label for="last_name-5">հաշվեհամար</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /card-body -->
                            </div> <!-- /card -->
                        </div> <!-- /col -->
                    </div> <!-- /row -->

                    <div class="row mb-3">
                        <div class="col">
                            <div class="card">
                                <!-- Первый набор: i_ -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="i_region_select_phy">
                                                <option value="" selected="">Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="i_region_select">i մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="i_district_select_phy" name="i_marz_id">
                                                <option value="" selected="">Ընտրեք</option>
                                                <!-- AJAX заполнит опции вида <option value="ID">district</option> -->
                                            </select>
                                            <label for="i_district_select">i Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="i_address_phy" name="i_address" placeholder=" ">
                                            <label for="i_address"><strong>i հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                {{-- ========== Блок w_  (например, "w" = work address?) ========== --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_region_select_phy">
                                                <option value="" selected="">Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="w_region_select">w մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_district_select_phy" name="w_marz_id">
                                                <option value="" selected="">Ընտրեք</option>
                                                <!-- AJAX заполнит опции вида <option value="ID">district</option> -->
                                            </select>
                                            <label for="w_district_select">w Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="w_address_phy" name="w_address" placeholder=" ">
                                            <label for="w_address"><strong>w հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>




                                <!-- JS-скрипт тот же, только дублируем логику для i_ и w_ -->
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


                            </div>
                        </div>
                    </div> <!-- /row -->
                </div> <!-- /col-lg-8 -->
            </div> <!-- /#physicalMain -->

            {{-- --------------------- ГЛАВНАЯ (Իրավաբանական лицо) --------------------- --}}

            <div id="juridicalMain" style="display: none;"><!-- Скрываем изначально -->
                <div class="col-lg-8 col-xxl-11">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    {{-- Селекты и поля для юр. лица --}}
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
{{--                                                <select class="form-select form-select" id="entity-select-4-j" >--}}

{{--                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">--}}
{{--                                                        <option selected value="12">Իրավաբանական</option>--}}
{{--                                                        <option value="13">Ֆիզիկական</option>--}}
{{--                                                    </optgroup>--}}
{{--                                                </select>--}}
                                                <select class="form-select" id="entity-select-4-j">
                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                        <option value="1" selected>Իրավաբանական</option>
                                                        <option value="0">Ֆիզիկական</option>
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select">Իրավաբանական/Ֆիզիկական</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5" name="type_id" >
                                                    <option value="" selected="">Ընտրեք</option>

                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                        @foreach($types as $type)

                                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                                        @endforeach

                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5">Օբեկտի տիպ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="first_name-1-j" name="firm_name" placeholder=" ">
                                                <label for="first_name-3">Ֆիրմայի անվանումը</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5-j" >

                                                    <optgroup label="roles">
                                                        @foreach($seoroles as $seorole)

                                                            <option value="{{$seorole->id}}">{{$seorole->name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5">Role</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-11-j" name="ceo_name" placeholder=" ">
                                                <label for="last_name-3">տնօրեն</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-3-j" name="hvhh" placeholder=" ">
                                                <label for="last_name-3">հարկային կոդ</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-2-j" name="brand_name" placeholder=" ">
                                                <label for="last_name-2">Բրենդի անվանում</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-4-j" name="ceo_phone" placeholder=" ">
                                                <label for="last_name-3">տնօրենի հեռ․</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="bank-select-1-j" name="firm_bank" >
                                                    <optgroup label="Ընտրել">
                                                        <option value="Կոնվերս">Կոնվերս բանկ ԲԲԸ</option>
                                                        <option value="Ամերիաբանկ">Ամերիաբանկ ԲԲԸ</option>
                                                    </optgroup>
                                                </select>
                                                <label for="bank-select">բանկ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-5-j" name="fin_contact" placeholder=" ">
                                                <label for="last_name-5">ֆին պատասխանատու հեռ․</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-6-j" name="firm_email" placeholder=" ">
                                                <label for="last_name-6">e-mail</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control form-control" type="text" id="last_name-5-j2" name="firm_bank_hh" placeholder=" ">
                                                <label for="last_name-5">հաշվեհամար</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /card-body -->
                            </div> <!-- /card -->
                        </div> <!-- /col -->
                    </div> <!-- /row -->

                    <div class="row mb-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body"></div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="i_region_select_jur">
                                                <option value="" selected="">Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="i_region_select">i մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <!-- Теперь id="i_district_select_jur" -->
                                            <select class="form-select" id="i_district_select_jur" name="i_marz_id">
                                                <option value="" selected="">Ընտրեք</option>
                                                <!-- AJAX заполнит опции вида <option value="ID">district</option> -->
                                            </select>
                                            <label for="i_district_select_jur">i Համայնք (district)</label>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="i_address_jur" name="i_address" placeholder=" ">
                                            <label for="i_address"><strong>i հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                {{-- ========== Блок w_  (например, "w" = work address?) ========== --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_region_select_jur">
                                                <option value="" selected="">Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="w_region_select">w մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_district_select_jur" name="w_marz_id">
                                                <option value="" selected="">Ընտրեք</option>
                                                <!-- AJAX заполнит опции вида <option value="ID">district</option> -->
                                            </select>
                                            <label for="w_district_select">w Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="w_address_jur" name="w_address" placeholder=" ">
                                            <label for="w_address"><strong>w հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="card-body">--}}
{{--                                    <button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button>--}}
{{--                                </div>--}}
                            </div> <!-- /card -->
                        </div>
                    </div> <!-- /row -->
                </div> <!-- /col-lg-8 -->
            </div> <!-- /#juridicalMain -->

            {{-- --------------------- ՏԵԽՆԻԿԱԿԱՆ --------------------- --}}
            <div id="technicalSection" style="display: none;"><!-- Скрыто до выбора radio -->
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-body text-center shadow">



                                <div class="col">
                                    <div class="mb-3 floating-label">
                                        <label>Метод идентификации:</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="hidden" name="identification" id="manual_ident" value="manual" checked >
                                            <label class="form-check-label" for="manual_ident">Ввести вручную</label>
                                        </div>
                                        <div class="form-check form-check-inline">
{{--                                            <input class="form-check-input" type="radio" name="identification" id="auto_ident" value="auto">--}}
{{--                                            <label class="form-check-label" for="auto_ident">Автоматически</label>--}}
                                        </div>
                                    </div>

                                    {{-- Контейнер для ввода ident_id --}}
                                    <div id="ident_id_container" class="mb-3">
                                        <label for="ident_id" class="form-label">Идентификатор:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="ident_id" name="ident_id" placeholder="Введите идентификатор">
                                            <button type="button" class="btn btn-outline-secondary" id="auto_ident_btn">Идентифицировать</button>
                                        </div>
                                        @error('ident_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>




                                <div class="col">
                                    <div class="mb-3 floating-label">
                                        <label for="last_name-3"><strong>Սարքի ID</strong></label>
                                    </div>
                                    <div class="mb-3 floating-label">
{{--                                        <input type="text" class="form-control" id="last_name-3" name="last_name" placeholder=" ">--}}
{{--                                        <label for="last_name-3"><strong>Select Hardware</strong></label>--}}
                                        <select class="form-select" id="entity-select-4-j">
                                            <optgroup label="hardwares">
                                                @foreach($hardwares as $hardware)
                                                    <option value="{{$hardware->id}}" >{{$hardware->name}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 floating-label">
                                        <button type="button" class="btn btn-secondary" id="openSimModal">
                                            Выбрать SIM-карты
                                        </button>

                                        {{-- Контейнер для отображения выбранных SIM-карт --}}
                                        <div id="selectedSimContainer" class="mt-3">
                                            {{-- Выбранные SIM-карты будут добавлены здесь --}}
                                        </div>
                                    </div>
                                </div>












                                <div class="col">
                                    <div class="mb-3 floating-label">
                                        <select class="form-select" id="entity-select-4-j">
                                            <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                @foreach($workers as $worker)
                                                    <option value="{{$worker->id}}" >{{$worker->name}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/image2.jpeg" width="160" height="160">
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="button">ավելացնել նկար</button>
                                </div>

                            </div>
                        </div>
                        <div class="card shadow mb-4"></div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row mb-3 d-none">
                            <div class="col">
                                <div class="card text-white bg-primary shadow">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <p class="m-0">Peformance</p>
                                                <p class="m-0"><strong>65.2%</strong></p>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                        </div>
                                        <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card text-white bg-success shadow">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <p class="m-0">Peformance</p>
                                                <p class="m-0"><strong>65.2%</strong></p>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                        </div>
                                        <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">User Settings</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control form-control" type="text" id="last_name-1" name="x_gps" placeholder=" ">
                                            <label for="last_name-3"><strong>GPS X</strong></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control form-control" type="text" id="last_name-2" name="y_gps" placeholder=" ">
                                            <label for="last_name-3"><strong>GPS Y</strong></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-6">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control form-control" type="text" id="last_name-5" name="their_hardware" placeholder=" ">
                                            <label for="last_name-3">օբեկտի սարքի անվանում</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select form-select" id="entity-select-5"  name="connection_type">
                                                <option value="" selected="">Ընտրեք</option>
                                                <optgroup label="Տեխնիկական կարգավիճակ">
                                                    <option value="12">GSM, Dialer</option>
                                                    <option value="13">GPRS, Internet</option>
                                                    <option value="13">wifi</option>
                                                </optgroup>
                                            </select>
                                            <label for="entity-select-5">Միացման ձև</label>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="row">--}}
{{--                                    <div class="col">--}}
{{--                                        <!-- Кнопка "ավելացնել Պատասխանատու" -->--}}
{{--                                        <button class="btn btn-outline-primary text-truncate float-none float-sm-none add-another-btn" data-bss-hover-animate="pulse" type="button" style="text-align: center;">--}}
{{--                                            ավելացնել Պատասխանատու<i class="fas fa-plus-circle edit-icon"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div id="patasxanatus-container">
                                    {{-- Динамически добавляемые поля будут здесь --}}
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!-- Кнопка "ավելացնել Պատասխանատու" -->
                                        <button class="btn btn-outline-primary text-truncate float-none float-sm-none add-another-btn" data-bss-hover-animate="pulse" type="button" style="text-align: center;">
                                            ավելացնել Պատասխանատու <i class="fas fa-plus-circle edit-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- /card-body -->
                        </div> <!-- /card shadow -->

                        <div class="card shadow">
                            <div class="mb-3"></div>
                            <div class="card-body">
                                <div class="col">
                                    <div class="mb-3 floating-label"></div>
                                    <div class="mb-3 floating-label"></div>
                                    <div class="form-check">
                                        <input type="hidden" name="activepaymnanagir_received" value="0">
                                        <input class="form-check-input" type="checkbox" name="activepaymnanagir_received" value="1" {{ old('paymnanagir_received') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="formCheck-2">Պայմանագիրը ստացել ենք</label>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- /card shadow -->
                    </div> <!-- /col-lg-8 -->
                </div> <!-- /row -->
            </div> <!-- /#technicalSection -->

            {{-- --------------------- ադմին տեխնիկական --------------------- --}}
            <div id="adminTechnicalSection" style="display: none;"><!-- Скрыто до выбора radio -->
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3"></div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="text-primary fw-bold m-0">Լուծարել պայմանագիրը</h6>
                            </div>
                            <div class="card-body">
                                <input type="date" name="paymanagir_start"><small>Դիմումի օր</small>
                                <div></div>
                                <input type="date" name="paymanagir_end">
                                <div></div>
                                <input type="date" name="end_dimum">


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Settings</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 floating-label">
                                                    <select class="form-select form-select" id="entity-select-1" name="tech_check" >
                                                        <option value="" selected="">Ընտրեք</option>
                                                        <optgroup label="Տեխնիկական կարգավիճակ">
                                                            <option value="12">Հսկման տակ</option>
                                                            <option value="13">Հսկողությունից հանված</option>
                                                            <option value="13">Կապ չկա</option>
                                                            <option value="13">Անջատված է</option>
                                                            <option value="13">Չի աշխատում</option>
                                                        </optgroup>
                                                    </select>
                                                    <label for="entity-select-1">Տեխնիկական կարգավիճակ</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="hidden" name="status_edit" value="0">
                                                    <input class="form-check-input" type="checkbox" name="status_edit" value="1" id="formCheck-1">
                                                    <label class="form-check-label" for="formCheck-1">թույլատրել փոխել ձեռքով</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 floating-label">
                                                    <input class="form-control form-control" type="text" id="last_name-3" name="check_time" placeholder=" ">
                                                    <label for="last_name-3">կապի ստուգման ժամանակ</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="card shadow">
                                    <div class="mb-3"></div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 floating-label">
                                                    <select class="form-select form-select"  name="object_check"  id="entity-select-2" >
                                                        <option value="" selected="">Ընտրեք</option>
                                                        <optgroup label="object կարգավիճակ">
                                                            <option value="12">սպասվող</option>
                                                            <option value="13">Հրաժարված</option>
                                                            <option value="13">Պայմանագիրը լուծարված</option>
                                                            <option value="13">Պայմանագրի ընդացք</option>
                                                            <option value="13">կարգավորման ընդացք</option>
                                                            <option value="13">911-ին միացված</option>
                                                        </optgroup>
                                                    </select>
                                                    <label for="entity-select-1">object կարգավիճակ</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 floating-label">
                                                    <select class="form-select form-select"  name="price_id"  id="entity-select-2" >
                                                        <option value="" selected="">Ընտրեք</option>
                                                        <optgroup label="object կարգավիճակ">

                                                           @foreach($prices as $price)
                                                                <option value="{{$price->id}}">{{$price->name}}</option>
                                                           @endforeach
                                                        </optgroup>
                                                    </select>
                                                    <label for="entity-select-1">object կարգավիճակ</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div> <!-- /col -->
                        </div> <!-- /row -->
                    </div> <!-- /col-lg-8 -->
                </div> <!-- /row -->
            </div> <!-- /#adminTechnicalSection -->

        <div class="mb-3">
            <button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button>
        </div>

</form>
    </div>
    <div id="simModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center">
                <span onclick="closeSimModal()" class="w3-button w3-xlarge w3-hover-red w3-display-topright">&times;</span>
                <h3>Выбрать SIM-карты для проекта</h3>
            </div>
            <form id="simSearchForm" method="POST">
                @csrf
                <div class="w3-container">
                    <label for="simSearch">Поиск по номеру:</label>
                    <input type="text" id="simSearch" name="simSearch" class="w3-input" placeholder="Введите номер" oninput="performSearch()">

                    <div id="simSearchResults" class="w3-margin-top">
                        <p>Введите номер для поиска...</p>
                    </div>

                    <button type="button" onclick="saveSimSelection()" class="w3-button w3-green w3-margin-top">Сохранить выбор</button>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Добавляем дополнительные стили при необходимости -->
    <style>
        /* Стилизация выбранных SIM-карт */
        #selectedSimContainer {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 50px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        #selectedSimContainer span {
            display: inline-block;
            background-color: #e7f3fe;
            border: 1px solid #2196F3;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 4px;
            position: relative;
        }
        #selectedSimContainer span .remove-sim {
            margin-left: 10px;
            color: red;
            cursor: pointer;
            font-weight: bold;
            position: absolute;
            top: 0;
            right: 0;
        }
        .patasxanatu-input {
            position: relative;
            margin-bottom: 10px;
        }
        .remove-patasxanatu-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: red;
            font-size: 1.2em;
            cursor: pointer;
        }
    </style>
    {{-- Подключаем jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            const phySection = document.querySelector("#physicalMain");
            const jurSection = document.querySelector("#juridicalMain");
            const phyJurSelect = document.querySelector("#entity-select-4");
            const technicalSection = document.querySelector("#technicalSection");
            const adminTechnicalSection = document.querySelector("#adminTechnicalSection");

            function toggleSections() {
                const selectedValue = phyJurSelect.value;

                if (selectedValue === "0") {
                    // Физическое лицо выбрано
                    enableInputs(phySection);
                    disableInputs(jurSection);
                } else if (selectedValue === "1") {
                    // Юридическое лицо выбрано
                    enableInputs(jurSection);
                    disableInputs(phySection);
                }

                // Обе технические секции остаются включенными
                enableInputs(technicalSection);
                enableInputs(adminTechnicalSection);
            }

            function disableInputs(section) {
                const inputs = section.querySelectorAll("input, select, textarea");
                inputs.forEach((input) => {
                    input.disabled = true;
                });
            }

            function enableInputs(section) {
                const inputs = section.querySelectorAll("input, select, textarea");
                inputs.forEach((input) => {
                    input.disabled = false;
                });
            }

            // Событие при изменении селектора физ/юр
            phyJurSelect.addEventListener("change", toggleSections);

            // Событие перед отправкой формы
            form.addEventListener("submit", function (event) {
                const selectedValue = phyJurSelect.value;

                // Отключить неактивную секцию перед отправкой формы
                if (selectedValue === "0") {
                    disableInputs(jurSection); // Отключить юридическую секцию
                } else if (selectedValue === "1") {
                    disableInputs(phySection); // Отключить физическую секцию
                }
            });

            // Инициализация
            toggleSections();
        });

    </script>

    <script>
        $(function(){
            // 1) По умолчанию phy_jur = 0 (Физ).
            $('#phy_jur').val('0');

            // 2) При переключении "Глхавор/Технический/Админ" (radio)
            //    показываем/скрываем нужные блоки
            $('#btnradio1').on('change', function(){
                if ($(this).is(':checked')) {
                    // Смотрим, какой сейчас phy_jur
                    let curVal = $('#phy_jur').val(); // "0" или "1"
                    if (curVal === '0') {
                        // физ
                        $('#physicalMain').show();
                        $('#juridicalMain').hide();
                    } else {
                        // юр
                        $('#physicalMain').hide();
                        $('#juridicalMain').show();
                    }
                    $('#technicalSection').hide();
                    $('#adminTechnicalSection').hide();
                }
            });
            $('#btnradio2').on('change', function(){
                if ($(this).is(':checked')) {
                    $('#physicalMain').hide();
                    $('#juridicalMain').hide();
                    $('#technicalSection').show();
                    $('#adminTechnicalSection').hide();
                }
            });
            $('#btnradio2-1').on('change', function(){
                if ($(this).is(':checked')) {
                    $('#physicalMain').hide();
                    $('#juridicalMain').hide();
                    $('#technicalSection').hide();
                    $('#adminTechnicalSection').show();
                }
            });

            // 3) При смене #entity-select-4 (физ/юр) в физическом блоке
            $('#entity-select-4').on('change', function(){
                let val = $(this).val(); // "0" или "1"
                $('#phy_jur').val(val);
                if ($('#btnradio1').is(':checked')) {
                    if (val === '1') {
                        // юр
                        $('#physicalMain').hide();
                        $('#juridicalMain').show();
                    } else {
                        // физ
                        $('#physicalMain').show();
                        $('#juridicalMain').hide();
                    }
                }
            });

            // 4) При смене #entity-select-4-j (физ/юр) в юр. блоке
            $('#entity-select-4-j').on('change', function(){
                let val = $(this).val(); // "0" или "1"
                $('#phy_jur').val(val);
                if ($('#btnradio1').is(':checked')) {
                    if (val === '1') {
                        $('#physicalMain').hide();
                        $('#juridicalMain').show();
                    } else {
                        $('#physicalMain').show();
                        $('#juridicalMain').hide();
                    }
                }
            });

            // Остальные скрипты (AJAX для i_/w_) — те же
        });
    </script>

    <script>
        $(function(){
            // i_ (Physical)
            $('#i_region_select_phy').on('change', function(){
                let name = $(this).val();
                if(!name) {
                    $('#i_district_select_phy').html('<option value="">Ընտրեք</option>');
                    return;
                }

                $.ajax({
                    url: '/get-districts/' + encodeURIComponent(name),
                    method: 'GET',
                    success: function(data) {
                        let sel = $('#i_district_select_phy');
                        sel.empty();
                        sel.append('<option value="">Ընտրեք</option>');
                        $.each(data, function(stateId, districtName){
                            sel.append('<option value="'+stateId+'">'+districtName+'</option>');
                        });
                    }
                });
            });

            // w_ (Physical)
            $('#w_region_select_phy').on('change', function(){
                let name = $(this).val();
                if(!name) {
                    $('#w_district_select_phy').html('<option value="">Ընտրեք</option>');
                    return;
                }

                $.ajax({
                    url: '/get-districts/' + encodeURIComponent(name),
                    method: 'GET',
                    success: function(data) {
                        let sel = $('#w_district_select_phy');
                        sel.empty();
                        sel.append('<option value="">Ընտրեք</option>');
                        $.each(data, function(stateId, districtName){
                            sel.append('<option value="'+stateId+'">'+districtName+'</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(function(){
            // i_ (Juridical)
            $('#i_region_select_jur').on('change', function(){
                let name = $(this).val();
                if(!name) {
                    $('#i_district_select_jur').html('<option value="">Ընտրեք</option>');
                    return;
                }

                $.ajax({
                    url: '/get-districts/' + encodeURIComponent(name),
                    method: 'GET',
                    success: function(data) {
                        let sel = $('#i_district_select_jur');
                        sel.empty();
                        sel.append('<option value="">Ընտրեք</option>');
                        $.each(data, function(stateId, districtName){
                            sel.append('<option value="'+stateId+'">'+districtName+'</option>');
                        });
                    }
                });
            });

            // w_ (Juridical)
            $('#w_region_select_jur').on('change', function(){
                let name = $(this).val();
                if(!name) {
                    $('#w_district_select_jur').html('<option value="">Ընտրեք</option>');
                    return;
                }

                $.ajax({
                    url: '/get-districts/' + encodeURIComponent(name),
                    method: 'GET',
                    success: function(data) {
                        let sel = $('#w_district_select_jur');
                        sel.empty();
                        sel.append('<option value="">Ընտրեք</option>');
                        $.each(data, function(stateId, districtName){
                            sel.append('<option value="'+stateId+'">'+districtName+'</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Функции для открытия и закрытия модального окна
        function openSimModal() {
            document.getElementById('simModal').style.display = 'block';
        }

        function closeSimModal() {
            document.getElementById('simModal').style.display = 'none';
        }

        // Добавляем обработчики для кнопок открытия модалки
        $(document).ready(function(){
            $('#openSimModal').on('click', function(){
                openSimModal();
            });

            // Удаление выбранной SIM-карты из контейнера
            $(document).on('click', '.remove-sim', function(){
                const simId = $(this).parent().data('sim-id');
                // Удаляем скрытый input
                $(`input[name="sim_ids[]"][value="${simId}"]`).remove();
                // Удаляем визуальный элемент
                $(this).parent().remove();
                // Также, если SIM-карта была отмечена в модалке, снимаем отметку
                $(`.sim-checkbox[value="${simId}"]`).prop('checked', false);
            });

            // Добавление нового поля "Պատասխանատու"
            $('.add-another-btn').on('click', function(){
                addPatasxanatuField();
            });
        });
        // <div class="patasxanatu-input" data-field="${fieldCount}">
        //     <input type="text" class="form-control" name="patasxanatus[]" placeholder="Պատասխանատու ${fieldCount}">
        //         <button type="button" class="remove-patasxanatu-btn">&times;</button>
        // </div>
        // Функция для добавления нового поля "Պատասխանատու"
        function addPatasxanatuField() {
            const container = $('#patasxanatus-container');
            const fieldCount = container.children().length + 1;
            const fieldHtml = `


  <div class="row">
                <div class="col">
                    <div class="mb-3 floating-label patasxanatu-input" data-field="${fieldCount}">
                        <input type="text" class="form-control" name="patasxanatus[]" placeholder="Պատասխանատու ${fieldCount}">
                        <button type="button" class="remove-patasxanatu-btn btn btn-danger btn-sm">&times;</button>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3 floating-label patasxanatu-input" data-field="${fieldCount}">
                        <input type="text" class="form-control" name="numbers[]" placeholder="Номер ${fieldCount}">
                        <button type="button" class="remove-patasxanatu-btn btn btn-danger btn-sm">&times;</button>
                    </div>
                </div>
            </div>

        `;
            container.append(fieldHtml);
        }

        // Обработчик удаления блока "Պատասխանատու"
        $(document).on('click', '.remove-patasxanatu-btn', function(){
            $(this).closest('.row').remove();
            // Опционально: обновить placeholder или нумерацию полей
            updateFieldPlaceholders();
        });

        // Функция для обновления нумерации placeholder после удаления
        function updateFieldPlaceholders(){
            $('#patasxanatus-container .row').each(function(index){
                $(this).find('input[name="patasxanatus[]"]').attr('placeholder', `Պատասխանատու ${index + 1}`);
                $(this).find('input[name="numbers[]"]').attr('placeholder', `Номер ${index + 1}`);
            });
        }

        // Функция для выполнения живого поиска
        function performSearch() {
            const query = $('#simSearch').val().trim();

            if (query.length < 1) {
                $('#simSearchResults').html('<p>Введите номер для поиска...</p>');
                return;
            }

            $.ajax({
                url: '{{ route("projects.searchSimlists") }}',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    let html = '';
                    if(data.simlists.length === 0){
                        html = '<p>Ничего не найдено.</p>';
                    } else {
                        data.simlists.forEach(function(sim){
                            // Проверяем, выбрана ли уже эта SIM-карта
                            const isSelected = $(`input[name="sim_ids[]"][value="${sim.id}"]`).length > 0;
                            html += `
                            <div class="w3-padding">
                                <input type="checkbox" class="sim-checkbox" value="${sim.id}" id="sim_${sim.id}" ${isSelected ? 'checked' : ''}>
                                <label for="sim_${sim.id}">${sim.number} ${isSelected ? '(выбрано)' : ''}</label>
                            </div>
                        `;
                        });
                    }
                    $('#simSearchResults').html(html);
                },
                error: function(xhr, status, error){
                    console.error('Ошибка при поиске SIM-карт:', error);
                    $('#simSearchResults').html('<p>Произошла ошибка при поиске.</p>');
                }
            });
        }

        // Функция для сохранения выбранных SIM-карт
        function saveSimSelection() {
            $('.sim-checkbox:checked').each(function(){
                const simId = $(this).val();
                const simNumber = $(this).next('label').text().replace(' (выбрано)', '');

                // Проверяем, есть ли уже скрытый input с этим simId
                if($(`input[name="sim_ids[]"][value="${simId}"]`).length === 0){
                    // Добавляем скрытый input в основную форму
                    const hiddenInput = `<input type="hidden" name="sim_ids[]" value="${simId}">`;
                    $('#selectedSimContainer').append(hiddenInput);

                    // Визуально отображаем выбранную SIM-карту с возможностью удаления
                    const simTag = `<span data-sim-id="${simId}">${simNumber} <span class="remove-sim">&times;</span></span>`;
                    $('#selectedSimContainer').append(simTag);
                }
            });

            // Закрываем модалку после сохранения
            closeSimModal();
            // Очистим результаты и поле поиска
            $('#simSearch').val('');
            $('#simSearchResults').html('<p>Введите номер для поиска...</p>');
        }
    </script>

{{--    <script>--}}
{{--        --}}
{{--        --}}
{{--        // Функции для открытия и закрытия модального окна--}}
{{--        function openSimModal() {--}}
{{--            document.getElementById('simModal').style.display = 'block';--}}
{{--        }--}}

{{--        function closeSimModal() {--}}
{{--            document.getElementById('simModal').style.display = 'none';--}}
{{--        }--}}

{{--        // Добавляем обработчики для кнопок открытия модалки--}}
{{--        $(document).ready(function(){--}}
{{--            $('#openSimModal').on('click', function(){--}}
{{--                openSimModal();--}}
{{--            });--}}

{{--            // Удаление выбранной SIM-карты из контейнера--}}
{{--            $(document).on('click', '.remove-sim', function(){--}}
{{--                const simId = $(this).parent().data('sim-id');--}}
{{--                // Удаляем скрытый input--}}
{{--                $(`input[name="sim_ids[]"][value="${simId}"]`).remove();--}}
{{--                // Удаляем визуальный элемент--}}
{{--                $(this).parent().remove();--}}
{{--                // Также, если SIM-карта была отмечена в модалке, снимаем отметку--}}
{{--                $(`.sim-checkbox[value="${simId}"]`).prop('checked', false);--}}
{{--            });--}}
{{--        });--}}

{{--        // Функция для выполнения живого поиска--}}
{{--        function performSearch() {--}}
{{--            const query = $('#simSearch').val().trim();--}}

{{--            if (query.length < 1) {--}}
{{--                $('#simSearchResults').html('<p>Введите номер для поиска...</p>');--}}
{{--                return;--}}
{{--            }--}}

{{--            $.ajax({--}}
{{--                url: '{{ route("projects.searchSimlists") }}',--}}
{{--                method: 'GET',--}}
{{--                data: { query: query },--}}
{{--                success: function(data) {--}}
{{--                    let html = '';--}}
{{--                    if(data.simlists.length === 0){--}}
{{--                        html = '<p>Ничего не найдено.</p>';--}}
{{--                    } else {--}}
{{--                        data.simlists.forEach(function(sim){--}}
{{--                            // Проверяем, выбрана ли уже эта SIM-карта--}}
{{--                            const isSelected = $(`input[name="sim_ids[]"][value="${sim.id}"]`).length > 0;--}}
{{--                            html += `--}}
{{--                            <div class="w3-padding">--}}
{{--                                <input type="checkbox" class="sim-checkbox" value="${sim.id}" id="sim_${sim.id}" ${isSelected ? 'checked' : ''}>--}}
{{--                                <label for="sim_${sim.id}">${sim.number} ${isSelected ? '(выбрано)' : ''}</label>--}}
{{--                            </div>--}}
{{--                        `;--}}
{{--                        });--}}
{{--                    }--}}
{{--                    $('#simSearchResults').html(html);--}}
{{--                },--}}
{{--                error: function(xhr, status, error){--}}
{{--                    console.error('Ошибка при поиске SIM-карт:', error);--}}
{{--                    $('#simSearchResults').html('<p>Произошла ошибка при поиске.</p>');--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        // Функция для сохранения выбранных SIM-карт--}}
{{--        function saveSimSelection() {--}}
{{--            $('.sim-checkbox:checked').each(function(){--}}
{{--                const simId = $(this).val();--}}
{{--                const simNumber = $(this).next('label').text().replace(' (выбрано)', '');--}}

{{--                // Проверяем, есть ли уже скрытый input с этим simId--}}
{{--                if($(`input[name="sim_ids[]"][value="${simId}"]`).length === 0){--}}
{{--                    // Добавляем скрытый input в основную форму--}}
{{--                    const hiddenInput = `<input type="hidden" name="sim_ids[]" value="${simId}">`;--}}
{{--                    $('#selectedSimContainer').append(hiddenInput);--}}

{{--                    // Визуально отображаем выбранную SIM-карту с возможностью удаления--}}
{{--                    const simTag = `<span data-sim-id="${simId}">${simNumber} <span class="remove-sim">&times;</span></span>`;--}}
{{--                    $('#selectedSimContainer').append(simTag);--}}
{{--                }--}}
{{--            });--}}

{{--            // Закрываем модалку после сохранения--}}
{{--            closeSimModal();--}}
{{--            // Очистим результаты и поле поиска--}}
{{--            $('#simSearch').val('');--}}
{{--            $('#simSearchResults').html('<p>Введите номер для поиска...</p>');--}}
{{--        }--}}
{{--    </script>--}}
    <script>
        $(document).ready(function(){
            // Переключение методов идентификации
            $('input[name="identification"]').on('change', function(){
                if ($(this).val() === 'manual') {
                    $('#ident_id').prop('readonly', false);
                    $('#auto_ident_btn').show();
                } else {
                    $('#ident_id').prop('readonly', true);
                    // Автоматически генерируем ident_id при выборе "Автоматически"
                    generateAutoIdentId();
                    $('#auto_ident_btn').hide();
                }
            });

            // Автоматическое форматирование ident_id при ручном вводе
            $('#ident_id').on('blur', function(){
                let val = $(this).val().trim();
                if(val.length > 0){
                    let num = parseInt(val, 10);
                    if(!isNaN(num) && num >=1 && num <=9999){
                        let padded = String(num).padStart(4, '0');
                        $(this).val(padded);
                    } else {
                        alert('Идентификатор должен быть числом от 1 до 9999');
                        $(this).val('');
                    }
                }
            });

            // Обработчик кнопки автоматической генерации ident_id
            $('#auto_ident_btn').on('click', function(){
                generateAutoIdentId();
            });

            function generateAutoIdentId() {
                $.ajax({
                    url: '{{ route("projects.getNextIdentId") }}',
                    method: 'GET',
                    success: function(data){
                        if(data.ident_id){
                            $('#ident_id').val(data.ident_id);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error('Ошибка при генерации ident_id:', error);
                        alert('Произошла ошибка при генерации идентификатора.');
                    }
                });
            }
        });
    </script>
@endsection
