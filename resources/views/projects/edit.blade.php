@extends('layouts')
@section('content')

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Edit Project</h3>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Группа радиокнопок (Գլխավոր / Տեխնիկական / ադմին տեխնիկական) --}}
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" autocomplete="off" class="btn-check" id="btnradio1" name="btnradio" {{ $currentSection === 'main' ? 'checked' : '' }}>
                <label class="form-label btn btn-outline-primary" for="btnradio1">Գլխավոր</label>

                <input type="radio" autocomplete="off" class="btn-check" id="btnradio2" name="btnradio" {{ $currentSection === 'technical' ? 'checked' : '' }}>
                <label class="form-label btn btn-outline-primary" for="btnradio2">Տեխնիկական</label>

                <input type="radio" autocomplete="off" class="btn-check" id="btnradio2-1" name="btnradio" {{ $currentSection === 'adminTechnical' ? 'checked' : '' }}>
                <label class="form-label btn btn-outline-primary" for="btnradio2-1">ադմին տեխնիկական</label>
            </div>

            {{-- Форма --}}

            {{-- --------------------- Գլխավոր --------------------- --}}
            <input type="hidden" name="phy_jur" id="phy_jur" value="{{ $project->hvhh ? '1' : '0' }}">
            <div id="physicalMain" style="display: {{ $project->hvhh ? 'none' : 'block' }};">
                <div class="col-lg-8 col-xxl-11">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    {{-- Селекты и поля для физ. лица --}}
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-4" name="entity_type_main">
                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                        <option value="1" {{ $project->hvhh ? 'selected' : '' }}>Իրավաբանական</option>
                                                        <option value="0" {{ !$project->hvhh ? 'selected' : '' }}>Ֆիզիկական</option>
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-4">Իրավաբանական/Ֆիզիկական</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5" name="type_id">
                                                    <option value="" selected>Ընտրեք</option>
                                                    <optgroup label="Օբեկտի տիպ">
                                                        @foreach($types as $type)
                                                            <option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5">Օբեկտի տիպ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="first_name-1" name="firm_name" placeholder=" " value="{{ old('firm_name', $project->firm_name) }}">
                                                <label for="first_name-1">անուն ազգանուն</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-1" name="andznagir" placeholder=" " value="{{ old('andznagir', $project->andznagir) }}">
                                                <label for="last_name-1">Անձնագիր</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-3" name="soc" placeholder=" " value="{{ old('soc', $project->soc) }}">
                                                <label for="last_name-3">Սոց քարտ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-2" name="id_card" placeholder=" " value="{{ old('id_card', $project->id_card) }}">
                                                <label for="last_name-2">ID քարտ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-7" name="ceo_phone" placeholder=" " value="{{ old('ceo_phone', $project->ceo_phone) }}">
                                                <label for="last_name-7">հեռախոսահամար</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="email" id="last_name-4" name="firm_email" placeholder=" " value="{{ old('firm_email', $project->firm_email) }}">
                                                <label for="last_name-4"><strong>email</strong></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select name="firm_bank" class="form-select" required>
                                                    <option value="Ամերիաբանկ ՓԲԸ" {{ $project->firm_bank == 'Ամերիաբանկ ՓԲԸ' ? 'selected' : '' }}>Ամերիաբանկ ՓԲԸ</option>
                                                    <option value="Ինեկոբանկ ՓԲԸ" {{ $project->firm_bank == 'Ինեկոբանկ ՓԲԸ' ? 'selected' : '' }}>Ինեկոբանկ ՓԲԸ</option>
                                                    <option value="Այդի բանկ ՓԲԸ" {{ $project->firm_bank == 'Այդի բանկ ՓԲԸ' ? 'selected' : '' }}>Այդի բանկ ՓԲԸ</option>
                                                    <option value="Ակբա բանկ ՓԲԸ" {{ $project->firm_bank == 'Ակբա բանկ ՓԲԸ' ? 'selected' : '' }}>Ակբա բանկ ՓԲԸ</option>
                                                    <option value="Կոնվերս բանկ ՓԲԸ" {{ $project->firm_bank == 'Կոնվերս բանկ ՓԲԸ' ? 'selected' : '' }}>Կոնվերս բանկ ՓԲԸ</option>
                                                    <option value="Յունիբանկ ԲԲԸ" {{ $project->firm_bank == 'Յունիբանկ ԲԲԸ' ? 'selected' : '' }}>Յունիբանկ ԲԲԸ</option>
                                                    <option value="Արարատբանկ ԲԲԸ" {{ $project->firm_bank == 'Արարատբանկ ԲԲԸ' ? 'selected' : '' }}>Արարատբանկ ԲԲԸ</option>
                                                    <option value="Արդշինբանկ ՓԲԸ" {{ $project->firm_bank == 'Արդշինբանկ ՓԲԸ' ? 'selected' : '' }}>Արդշինբանկ ՓԲԸ</option>
                                                    <option value="Ամիօ բանկ ՓԲԸ" {{ $project->firm_bank == 'Ամիօ բանկ ՓԲԸ' ? 'selected' : '' }}>Ամիօ բանկ ՓԲԸ</option>
                                                    <option value="Ֆասթ բանկ ՓԲԸ" {{ $project->firm_bank == 'Ֆասթ բանկ ՓԲԸ' ? 'selected' : '' }}>Ֆասթ բանկ ՓԲԸ</option>
                                                    <option value="Հայէկոնոմբանկ ԲԲԸ" {{ $project->firm_bank == 'Հայէկոնոմբանկ ԲԲԸ' ? 'selected' : '' }}>Հայէկոնոմբանկ ԲԲԸ</option>
                                                    <option value="Էվոկաբանկ ՓԲԸ" {{ $project->firm_bank == 'Էվոկաբանկ ՓԲԸ' ? 'selected' : '' }}>Էվոկաբանկ ՓԲԸ</option>
                                                    <option value="ՎՏԲ-Հայաստան բանկ ՓԲԸ" {{ $project->firm_bank == 'ՎՏԲ-Հայաստան բանկ ՓԲԸ' ? 'selected' : '' }}>ՎՏԲ-Հայաստան բանկ ՓԲԸ</option>
                                                    <option value="Բիբլոս բանկ արմենիա ՓԲԸ" {{ $project->firm_bank == 'Բիբլոս բանկ արմենիա ՓԲԸ' ? 'selected' : '' }}>Բիբլոս բանկ արմենիա ՓԲԸ</option>
                                                    <option value="Արցախբանկ ՓԲԸ" {{ $project->firm_bank == 'Արցախբանկ ՓԲԸ' ? 'selected' : '' }}>Արցախբանկ ՓԲԸ</option>
                                                    <option value="Արմսվիսբանկ ՓԲԸ" {{ $project->firm_bank == 'Արմսվիսբանկ ՓԲԸ' ? 'selected' : '' }}>Արմսվիսբանկ ՓԲԸ</option>
                                                    <option value="ՀՀ ֆին․ նախ" {{ $project->firm_bank == 'ՀՀ ֆին․ նախ' ? 'selected' : '' }}>ՀՀ ֆին․ նախ</option>
                                                </select>
                                                <label for="bank-select-1">բանկ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-5" name="brand_name" placeholder=" " value="{{ old('brand_name', $project->brand_name) }}">
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
                                                <input class="form-control" type="text" id="last_name-5" name="firm_bank_hh" placeholder=" " value="{{ old('firm_bank_hh', $project->firm_bank_hh) }}">
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
                                            <select class="form-select" id="i_region_select_phy" name="i_region">
                                                <option value="" selected>Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}" {{ $project->iMarz && $project->iMarz->name == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="i_region_select_phy">i մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="i_district_select_phy" name="i_marz_id">
                                                <option value="" selected>Ընտրեք</option>
                                                @if($project->iMarz)
                                                    <option value="{{ $project->i_marz_id }}" selected>{{ $project->iMarz->district }}</option>
                                                @endif
                                            </select>
                                            <label for="i_district_select_phy">i Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="i_address_phy" name="i_address" placeholder=" " value="{{ old('i_address', $project->i_address) }}">
                                            <label for="i_address_phy"><strong>i հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                {{-- ========== Блок w_  ========== --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_region_select_phy" name="w_region">
                                                <option value="" selected>Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}" {{ $project->wMarz && $project->wMarz->name == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="w_region_select_phy">w մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_district_select_phy" name="w_marz_id">
                                                <option value="" selected>Ընտրեք</option>
                                                @if($project->wMarz)
                                                    <option value="{{ $project->w_marz_id }}" selected>{{ $project->wMarz->district }}</option>
                                                @endif
                                            </select>
                                            <label for="w_district_select_phy">w Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="w_address_phy" name="w_address" placeholder=" " value="{{ old('w_address', $project->w_address) }}">
                                            <label for="w_address_phy"><strong>w հասցե</strong></label>
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

            {{-- --------------------- Գլխավոր (Իրավաբանական лицо) --------------------- --}}
            <div id="juridicalMain" style="display: {{ $project->hvhh ? 'block' : 'none' }};">
                <div class="col-lg-8 col-xxl-11">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    {{-- Селекты и поля для юр. лица --}}
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-4-j" name="entity_type">
                                                    <optgroup label="Իրավաբանական/Ֆիզիկական">
                                                        <option value="1" {{ $project->hvhh ? 'selected' : '' }}>Իրավաբանական</option>
                                                        <option value="0" {{ !$project->hvhh ? 'selected' : '' }}>Ֆիզիկական</option>
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-4-j">Իրավաբանական/Ֆիզիկական</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5-j" name="type_id">
                                                    <option value="" selected>Ընտրեք</option>
                                                    <optgroup label="Օբեկտի տիպ">
                                                        @foreach($types as $type)
                                                            <option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5-j">Օբեկտի տիպ</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="first_name-1-j" name="firm_name" placeholder=" " value="{{ old('firm_name', $project->firm_name) }}">
                                                <label for="first_name-1-j">Ֆիրմայի անվանումը</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="entity-select-5-j" name="role_id">
                                                    <optgroup label="Roles">
                                                        @foreach($seoroles as $seorole)
                                                            <option value="{{ $seorole->id }}" {{ $project->role_id == $seorole->id ? 'selected' : '' }}>{{ $seorole->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <label for="entity-select-5-j">Role</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-11-j" name="ceo_name" placeholder=" " value="{{ old('ceo_name', $project->ceo_name) }}">
                                                <label for="last_name-11-j">տնօրեն</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-3-j" name="hvhh" placeholder=" " value="{{ old('hvhh', $project->hvhh) }}">
                                                <label for="last_name-3-j">հարկային կոդ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-2-j" name="brand_name" placeholder=" " value="{{ old('brand_name', $project->brand_name) }}">
                                                <label for="last_name-2-j">Բրենդի անվանում</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-4-j" name="ceo_phone" placeholder=" " value="{{ old('ceo_phone', $project->ceo_phone) }}">
                                                <label for="last_name-4-j">տնօրենի հեռ․</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <select class="form-select form-select" id="bank-select-1-j" name="firm_bank">
                                                    <optgroup label="Ընտրել">
                                                        <option value="Ամերիաբանկ ՓԲԸ" {{ $project->firm_bank == 'Ամերիաբանկ ՓԲԸ' ? 'selected' : '' }}>Ամերիաբանկ ՓԲԸ</option>
                                                        <option value="Ինեկոբանկ ՓԲԸ" {{ $project->firm_bank == 'Ինեկոբանկ ՓԲԸ' ? 'selected' : '' }}>Ինեկոբանկ ՓԲԸ</option>
                                                        <option value="Այդի բանկ ՓԲԸ" {{ $project->firm_bank == 'Այդի բանկ ՓԲԸ' ? 'selected' : '' }}>Այդի բանկ ՓԲԸ</option>
                                                        <option value="Ակբա բանկ ՓԲԸ" {{ $project->firm_bank == 'Ակբա բանկ ՓԲԸ' ? 'selected' : '' }}>Ակբա բանկ ՓԲԸ</option>
                                                        <option value="Կոնվերս բանկ ՓԲԸ" {{ $project->firm_bank == 'Կոնվերս բանկ ՓԲԸ' ? 'selected' : '' }}>Կոնվերս բանկ ՓԲԸ</option>
                                                        <option value="Յունիբանկ ԲԲԸ" {{ $project->firm_bank == 'Յունիբանկ ԲԲԸ' ? 'selected' : '' }}>Յունիբանկ ԲԲԸ</option>
                                                        <option value="Արարատբանկ ԲԲԸ" {{ $project->firm_bank == 'Արարատբանկ ԲԲԸ' ? 'selected' : '' }}>Արարատբանկ ԲԲԸ</option>
                                                        <option value="Արդշինբանկ ՓԲԸ" {{ $project->firm_bank == 'Արդշինբանկ ՓԲԸ' ? 'selected' : '' }}>Արդշինբանկ ՓԲԸ</option>
                                                        <option value="Ամիօ բանկ ՓԲԸ" {{ $project->firm_bank == 'Ամիօ բանկ ՓԲԸ' ? 'selected' : '' }}>Ամիօ բանկ ՓԲԸ</option>
                                                        <option value="Ֆասթ բանկ ՓԲԸ" {{ $project->firm_bank == 'Ֆասթ բանկ ՓԲԸ' ? 'selected' : '' }}>Ֆասթ բանկ ՓԲԸ</option>
                                                        <option value="Հայէկոնոմբանկ ԲԲԸ" {{ $project->firm_bank == 'Հայէկոնոմբանկ ԲԲԸ' ? 'selected' : '' }}>Հայէկոնոմբանկ ԲԲԸ</option>
                                                        <option value="Էվոկաբանկ ՓԲԸ" {{ $project->firm_bank == 'Էվոկաբանկ ՓԲԸ' ? 'selected' : '' }}>Էվոկաբանկ ՓԲԸ</option>
                                                        <option value="ՎՏԲ-Հայաստան բանկ ՓԲԸ" {{ $project->firm_bank == 'ՎՏԲ-Հայաստան բանկ ՓԲԸ' ? 'selected' : '' }}>ՎՏԲ-Հայաստան բանկ ՓԲԸ</option>
                                                        <option value="Բիբլոս բանկ արմենիա ՓԲԸ" {{ $project->firm_bank == 'Բիբլոս բանկ արմենիա ՓԲԸ' ? 'selected' : '' }}>Բիբլոս բանկ արմենիա ՓԲԸ</option>
                                                        <option value="Արցախբանկ ՓԲԸ" {{ $project->firm_bank == 'Արցախբանկ ՓԲԸ' ? 'selected' : '' }}>Արցախբանկ ՓԲԸ</option>
                                                        <option value="Արմսվիսբանկ ՓԲԸ" {{ $project->firm_bank == 'Արմսվիսբանկ ՓԲԸ' ? 'selected' : '' }}>Արմսվիսբանկ ՓԲԸ</option>
                                                        <option value="ՀՀ ֆին․ նախ" {{ $project->firm_bank == 'ՀՀ ֆին․ նախ' ? 'selected' : '' }}>ՀՀ ֆին․ նախ</option>


                                                    </optgroup>
                                                </select>
                                                <label for="bank-select-1-j">բանկ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-5-j" name="fin_contact" placeholder=" " value="{{ old('fin_contact', $project->fin_contact) }}">
                                                <label for="last_name-5-j">ֆին պատասխանատու հեռ․</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="email" id="last_name-6-j" name="firm_email" placeholder=" " value="{{ old('firm_email', $project->firm_email) }}">
                                                <label for="last_name-6-j">e-mail</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 floating-label">
                                                <input class="form-control" type="text" id="last_name-5-j2" name="firm_bank_hh" placeholder=" " value="{{ old('firm_bank_hh_jur', $project->firm_bank_hh) }}">
                                                <label for="last_name-5-j2">հաշվեհամար</label>
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
                                            <select class="form-select" id="i_region_select_jur" name="i_region">
                                                <option value="" selected>Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}" {{ $project->iMarz && $project->iMarz->name == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="i_region_select_jur">i մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="i_district_select_jur" name="i_marz_id">
                                                <option value="" selected>Ընտրեք</option>
                                                @if($project->iMarz)
                                                    <option value="{{ $project->i_marz_id }}" selected>{{ $project->iMarz->district }}</option>
                                                @endif
                                            </select>
                                            <label for="i_district_select_jur">i Համայնք (district)</label>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="i_address_jur" name="i_address" placeholder=" " value="{{ old('i_address', $project->i_address) }}">
                                            <label for="i_address_jur"><strong>i հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                {{-- ========== Блок w_  ========== --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_region_select_jur" name="w_region">
                                                <option value="" selected>Ընտրեք</option>
                                                <optgroup label="ՀՀ Մարզ">
                                                    @foreach($names as $row)
                                                        <option value="{{ $row->name }}" {{ $project->wMarz && $project->wMarz->name == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="w_region_select_jur">w մարզ (name)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="w_district_select_jur" name="w_marz_id">
                                                <option value="" selected>Ընտրեք</option>
                                                @if($project->wMarz)
                                                    <option value="{{ $project->w_marz_id }}" selected>{{ $project->wMarz->district }}</option>
                                                @endif
                                            </select>
                                            <label for="w_district_select_jur">w Համայնք (district)</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input type="text" class="form-control" id="w_address_jur" name="w_address" placeholder=" " value="{{ old('w_address', $project->w_address) }}">
                                            <label for="w_address_jur"><strong>w հասցե</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /card -->
                        </div>
                    </div> <!-- /row -->
                </div> <!-- /col-lg-8 -->
            </div> <!-- /#juridicalMain -->

            {{-- --------------------- ՏԵԽՆԻԿԱԿԱՆ --------------------- --}}
            <div id="technicalSection" style="display: none;">
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-body text-center shadow">
                                <div class="col">
                                    <div class="mb-3 floating-label">

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="hidden" name="identification" id="manual_ident" value="manual" {{ $project->identification == 'manual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="manual_ident">Ввести вручную</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="hidden" name="identification" id="auto_ident" value="auto" {{ $project->identification == 'auto' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="auto_ident">Автоматически</label>
                                        </div>
                                    </div>

                                    {{-- Контейнер для ввода ident_id --}}
                                    <div id="ident_id_container" class="mb-3">

                                        <div class="input-group">
                                            <input type="text" class="form-control" id="ident_id" name="ident_id" placeholder="Введите идентификатор" value="{{ old('ident_id', $project->ident_id) }}" {{ $project->identification == 'auto' ? 'readonly' : '' }}>
                                            <button type="button" class="btn btn-outline-secondary" id="auto_ident_btn" {{ $project->identification == 'auto' ? 'disabled' : '' }}>Идентифицировать</button>
                                        </div>
                                        @error('ident_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card mb-3"></div>
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="text-primary fw-bold m-0">start պայմանագիր</h6>
                                        </div>
                                        <div class="card-body">
                                            <input type="date" name="paymanagir_start" value="{{ old('paymanagir_start', $project->paymanagir_start) }}">
                                            <div></div>

                                        </div>
                                    </div>
                                </div>
                                @if($project->price_id == null)

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select form-select"  name="price_id"  id="entity-select-2" >
<option value="{{null}}" selected> yntreq </option>
                                                <optgroup label="object կարգավիճակ">

                                                    @foreach($prices as $price)
                                                        <option value="{{$price->id}}" {{ $project->price_id == $price->id ? 'selected' : '' }}>{{$price->price_name}}-{{$price->amount}}</option>
                                                    @endforeach

                                                </optgroup>
                                            </select>
                                            <label for="entity-select-1">object կարգավիճակ</label>
                                        </div>
                                    </div>
                                @else

                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select form-select"  name="price_id"  id="entity-select-2" >

                                                <optgroup label="object կարգավիճակ">

                                                    @foreach($prices as $price)
                                                        <option value="{{$price->id}}" {{ $project->price_id == $price->id ? 'selected' : '' }}>{{$price->price_name}}-{{$price->amount}}</option>
                                                    @endforeach

                                                </optgroup>
                                            </select>
                                            <label for="entity-select-1">object կարգավիճակ</label>
                                        </div>
                                    </div>
                                @endif

                                <div class="col">
                                    <div class="mb-3 floating-label">
                                        <select class="form-select" id="worker-select" name="worker_id">
                                            <optgroup label="Workers">
                                                @foreach($workers as $worker)
                                                    <option value="{{ $worker->id }}" {{ $project->worker_id == $worker->id ? 'selected' : '' }}>{{ $worker->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <img class="rounded-circle mb-3 mt-4" src="{{ asset('assets/img/dogs/image2.jpeg') }}" width="160" height="160">
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="button">ավելացնել նկար</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4"></div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row mb-3 d-none">
                            <!-- Оставьте этот блок как есть, если он вам нужен -->
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">User Settings</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <button type="button" class="btn btn-secondary" id="openSimModal">
                                                Выбрать SIM-карты
                                            </button>

                                            {{-- Контейнер для отображения выбранных SIM-карт --}}
                                            <div id="selectedSimContainer" class="mt-3">
                                                @foreach($project->simlists as $simlist)
                                                    <span data-sim-id="{{ $simlist->id }}">
                                                {{ $simlist->number }}
                                                <span class="remove-sim">&times;</span>
                                                <input type="hidden" name="sim_ids[]" value="{{ $simlist->id }}">
                                            </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <button type="button" class="btn btn-secondary" id="openHardwareModal">
                                                Выбрать Оборудование
                                            </button>

                                            {{-- Контейнер для отображения выбранного оборудования --}}
                                            <div id="selectedHardwareContainer" class="mt-3">
                                                @if($project->hardwares->count() > 0)
                                                    @foreach($project->hardwares as $hardware)
                                                        <span data-hardware-id="{{ $hardware->id }}">
                                                                {{ $hardware->serial }} ({{ $hardware->name }})
                                                            <span class="remove-hardware">&times;</span>
                                                     <input type="hidden" name="hardware_ids[]" value="{{ $hardware->id }}">
                                                         </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control" type="text" id="last_name-1" name="x_gps" placeholder=" " value="{{ old('x_gps', $project->x_gps) }}">
                                            <label for="last_name-1">GPS X</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control" type="text" id="last_name-2" name="y_gps" placeholder=" " value="{{ old('y_gps', $project->y_gps) }}">
                                            <label for="last_name-2">GPS Y</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-6">
                                        <div class="mb-3 floating-label">
                                            <input class="form-control" type="text" id="last_name-5" name="their_hardware" placeholder=" " value="{{ old('their_hardware', $project->their_hardware) }}">
                                            <label for="last_name-5">օբեկտի սարքի անվանում</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 floating-label">
                                            <select class="form-select" id="entity-select-5" name="connection_type">
                                                <option value="" selected>Ընտրեք</option>
                                                <optgroup label="Տեխնիկական կարգավիճակ">
                                                    <option value="GSM, Dialer" {{ $project->connection_type == 'GSM, Dialer' ? 'selected' : '' }}>GSM, Dialer</option>
                                                    <option value="GPRS, Internet" {{ $project->connection_type == 'GPRS, Internet' ? 'selected' : '' }}>GPRS, Internet</option>
                                                    <option value="wifi" {{ $project->connection_type == 'wifi' ? 'selected' : '' }}>wifi</option>
                                                </optgroup>
                                            </select>
                                            <label for="entity-select-5">Միացման ձև</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="patasxanatus-container">
                                    {{-- Выводим существующих Պատասխանատու --}}
                                    @if($project->patasxanatus)
                                        @foreach($project->patasxanatus as $index => $patasxanatu)
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3 floating-label patasxanatu-input" data-field="{{ $index + 1 }}">
                                                        <input type="text" class="form-control" name="patasxanatus[]" placeholder="Պատասխանատու {{ $index + 1 }}" value="{{ old('patasxanatus.'.$index, $patasxanatu->name) }}">
                                                        <button type="button" class="remove-patasxanatu-btn btn btn-danger btn-sm">&times;</button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3 floating-label patasxanatu-input" data-field="{{ $index + 1 }}">
                                                        <input type="text" class="form-control" name="numbers[]" placeholder="Номер {{ $index + 1 }}" value="{{ old('numbers.'.$index, $patasxanatu->number) }}">
                                                        <button type="button" class="remove-patasxanatu-btn btn btn-danger btn-sm">&times;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
                                        <input type="hidden" name="paymanagir_received" value="0">
                                        <input class="form-check-input" type="checkbox" name="paymanagir_received"  id="formCheck-2" {{ old('paymanagir_received', $project->paymanagir_received) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="formCheck-2">Պայմանագիրը ստացել ենք</label>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- /card shadow -->
                    </div> <!-- /col-lg-8 -->
                </div> <!-- /row -->
            </div> <!-- /#technicalSection -->

            {{-- --------------------- ադմին տեխնիկական --------------------- --}}
            <div id="adminTechnicalSection" style="display: none;">
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3"></div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="text-primary fw-bold m-0">Լուծարել պայմանագիրը</h6>
                            </div>
                            <div class="card-body">

                                <input type="date" name="paymanagir_end" value="{{ old('paymanagir_end', $project->paymanagir_end) }}">
                                <div></div>
                                <input type="date" name="end_dimum" value="{{ old('end_dimum', $project->end_dimum) }}">
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
                                                    <select class="form-select form-select" id="entity-select-1" name="tech_check">
                                                        <option value="" selected>Ընտրեք</option>
                                                        <optgroup label="Տեխնիկական կարգավիճակ">
                                                            <option value="1" {{ $project->tech_check == '1' ? 'selected' : '' }}>Հսկման տակ</option>
                                                            <option value="2" {{ $project->tech_check == '2' ? 'selected' : '' }}>Հսկողությունից հանված</option>
                                                            <option value="3" {{ $project->tech_check == '3' ? 'selected' : '' }}>Կապ չկա</option>
                                                            <option value="4" {{ $project->tech_check == '4' ? 'selected' : '' }}>Անջատված է</option>
                                                            <option value="5" {{ $project->tech_check == '5' ? 'selected' : '' }}>Չի աշխատում</option>
                                                        </optgroup>
                                                    </select>
                                                    <label for="entity-select-1">Տեխնիկական կարգավիճակ</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="hidden" name="status_edit" value="0">
                                                    <input class="form-check-input" type="checkbox" name="status_edit" value="1" id="formCheck-1" {{ old('status_edit', $project->status_edit) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="formCheck-1">թույլատրել փոխել ձեռքով</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 floating-label">
                                                    <input class="form-control" type="text" id="last_name-3" name="check_time" placeholder=" " value="{{ old('check_time', $project->check_time) }}">
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
                                                    <select class=" form-select" name="object_check" >

                                                        <optgroup label="Object կարգավիճակ">
                                                            <option value="1" {{ $project->object_check == '1' ? 'selected' : '' }}>սպասվող</option>
                                                            <option value="2" {{ $project->object_check == '2' ? 'selected' : '' }}>Հրաժարված</option>
                                                            <option value="3" {{ $project->object_check == '3' ? 'selected' : '' }}>Պայմանագիրը լուծարված</option>
                                                            <option value="4" {{ $project->object_check == '4' ? 'selected' : '' }}>Պայմանագրի ընդացք</option>
                                                            <option value="5" {{ $project->object_check == '5' ? 'selected' : '' }}>կարգավորման ընդացք</option>
                                                            <option value="6" {{ $project->object_check == '6' ? 'selected' : '' }}>911-ին միացված</option>
                                                        </optgroup>
                                                    </select>
                                                    <label for="entity-select-2">Object կարգավիճակ</label>
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

    {{-- Модальное окно для выбора SIM-карт --}}
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
    <div id="hardwareModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center">
                <span onclick="closeHardwareModal()" class="w3-button w3-xlarge w3-hover-red w3-display-topright">&times;</span>
                <h3>Выбрать Оборудование для проекта</h3>
            </div>
            <form id="hardwareSearchForm" method="POST">
                @csrf
                <div class="w3-container">
                    <label for="hardwareSearch">Поиск по серийному номеру:</label>
                    <input type="text" id="hardwareSearch" name="hardwareSearch" class="w3-input" placeholder="Введите серийный номер" oninput="performHardwareSearch()">

                    <div id="hardwareSearchResults" class="w3-margin-top">
                        <p>Введите серийный номер для поиска...</p>
                    </div>

                    <button type="button" onclick="saveHardwareSelection()" class="w3-button w3-green w3-margin-top">Сохранить выбор</button>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Добавляем дополнительные стили при необходимости -->
    <style>
        /* Стилизация выбранных SIM-карт */
        #selectedSimContainer  {
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
        #selectedHardwareContainer  {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 50px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        #selectedHardwareContainer span {
            display: inline-block;
            background-color: #e7f3fe;
            border: 1px solid #2196F3;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 4px;
            position: relative;
        }
        #selectedHardwareContainer span .remove-sim {
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
    {{-- Отдельный скрипт для обработки оборудования --}}
    <script>
        $(document).ready(function(){
            // Обработчик открытия модального окна оборудования
            $('#openHardwareModal').on('click', function(){
                openHardwareModal();
            });

            // Функции для открытия и закрытия модального окна оборудования
            function openHardwareModal() {
                $('#hardwareModal').show();
            }

            function closeHardwareModal() {
                $('#hardwareModal').hide();
            }

            // Закрытие модального окна при клике на крестик
            $(document).on('click', '#hardwareModal .w3-display-topright', function(){
                closeHardwareModal();
            });

            // Удаление выбранного оборудования из контейнера
            $(document).on('click', '.remove-hardware', function(){
                const hardwareId = $(this).parent().data('hardware-id');
                // Удаляем скрытый input
                $(`input[name="hardware_ids[]"][value="${hardwareId}"]`).remove();
                // Удаляем визуальный элемент
                $(this).parent().remove();
                // Также, если оборудование было отмечено в модалке, снимаем отметку
                $(`.hardware-checkbox[value="${hardwareId}"]`).prop('checked', false);
            });

            // Функция для выполнения живого поиска оборудования
            window.performHardwareSearch = function() {
                const query = $('#hardwareSearch').val().trim();

                if (query.length < 1) {
                    $('#hardwareSearchResults').html('<p>Введите серийный номер для поиска...</p>');
                    return;
                }

                $.ajax({
                    url: '{{ route("hardwares.searchHardwares") }}', // Убедитесь, что маршрут корректен
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        let html = '';
                        if(data.hardwares.length === 0){
                            html = '<p>Ничего не найдено.</p>';
                        } else {
                            data.hardwares.forEach(function(hardware){
                                // Проверяем, выбрано ли уже это оборудование
                                const isSelected = $(`input[name="hardware_ids[]"][value="${hardware.id}"]`).length > 0;
                                html += `
                                <div class="w3-padding">
                                    <input type="checkbox" class="hardware-checkbox" value="${hardware.id}" id="hardware_${hardware.id}" ${isSelected ? 'checked' : ''}>
                                    <label for="hardware_${hardware.id}">${hardware.serial} (${hardware.name}) ${isSelected ? '(выбрано)' : ''}</label>
                                </div>
                            `;
                            });
                        }
                        $('#hardwareSearchResults').html(html);
                    },
                    error: function(xhr, status, error){
                        console.error('Ошибка при поиске оборудования:', error);
                        $('#hardwareSearchResults').html('<p>Произошла ошибка при поиске.</p>');
                    }
                });
            }

            // Функция для сохранения выбранного оборудования
            window.saveHardwareSelection = function() {
                $('.hardware-checkbox:checked').each(function(){
                    const hardwareId = $(this).val();
                    const hardwareSerial = $(this).next('label').text().split(' (')[0].trim();
                    const hardwareName = $(this).next('label').text().split(' (')[1].replace(')', '').trim();

                    // Проверяем, есть ли уже скрытый input с этим hardwareId
                    if($(`input[name="hardware_ids[]"][value="${hardwareId}"]`).length === 0){
                        // Добавляем скрытый input в основную форму
                        const hiddenInput = `<input type="hidden" name="hardware_ids[]" value="${hardwareId}">`;
                        $('#selectedHardwareContainer').append(hiddenInput);

                        // Визуально отображаем выбранное оборудование с возможностью удаления
                        const hardwareTag = `
                        <span data-hardware-id="${hardwareId}">
                            ${hardwareSerial} (${hardwareName})
                            <span class="remove-hardware">&times;</span>
                        </span>
                    `;
                        $('#selectedHardwareContainer').append(hardwareTag);
                    }
                });

                // Закрываем модалку после сохранения
                closeHardwareModal();
                // Очистим результаты и поле поиска
                $('#hardwareSearch').val('');
                $('#hardwareSearchResults').html('<p>Введите серийный номер для поиска...</p>');
            }

            // Обработчик клика на кнопку "Сохранить выбор" в модальном окне оборудования
            $(document).on('click', '#hardwareModal button.w3-green', function(){
                saveHardwareSelection();
            });

            // Закрытие модального окна при клике вне его содержимого
            $(window).on('click', function(event){
                const modal = $('#hardwareModal');
                if ($(event.target).is(modal)) {
                    closeHardwareModal();
                }
            });
        });
    </script>

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

                // Технические секции остаются скрытыми
                technicalSection.style.display = "none";
                adminTechnicalSection.style.display = "none";
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

        $(function(){
            // 1) По умолчанию phy_jur = 0 или 1 в зависимости от проекта.
            $('#phy_jur').val('{{ $project->hvhh ? '1' : '0' }}');

            // 2) При переключении "Գլխավոր/Տեխնիկական/ադմին տեխնիկական" (radio)
            //    показываем/скрываем нужные блоки
            $('#btnradio1').on('change', function(){
                if ($(this).is(':checked')) {
                    // Смотрим, какой сейчас phy_jur
                    let curVal = $('#phy_jur').val(); // "0" или "1"
                    if (curVal === '1') {
                        // юр
                        $('#physicalMain').hide();
                        $('#juridicalMain').show();
                    } else {
                        // физ
                        $('#physicalMain').show();
                        $('#juridicalMain').hide();
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

            // 3) При смене #entity-select-4 (физ/юр) в главном блоке
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

            // 4) При смене #entity-select-4-j (физ/юр) в юридическом блоке
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
                    url: '{{ route("projects.getNextIdentId", $project->id) }}',
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
