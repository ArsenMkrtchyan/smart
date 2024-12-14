
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Create Project - Brand</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Data-Table-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Data-Table.css') }}">
</head>
<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Brand</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
            </div>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="navbar-nav flex-nowrap ms-auto">
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                    <span class="d-none d-lg-inline me-2 text-gray-600 small">Hello</span>
                                </a>
                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>{{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <h3 class="text-dark mb-4">Create Project</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Project Details</p>
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

                        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Section Navigation -->
                            <div class="mb-4 text-center">
                                <button type="button" class="btn btn-secondary section-btn" data-section="1">Section 1</button>
                                <button type="button" class="btn btn-secondary section-btn" data-section="2">Section 2</button>
                                <button type="button" class="btn btn-secondary section-btn" data-section="3">Section 3</button>
                            </div>

                            <!-- Section 1 -->
                            <!-- Section 1 -->
                            <div class="section" id="section-1">
                                <h3>Section 1</h3>
                                <div class="form-group mb-3">
                                    <label for="firm_type" class="form-label" >Firm Type</label>
                                    <select class="form-control @error('firm_type') is-invalid @enderror" name="firm_type" id="firm_type">
                                        <option value="0" {{ old('firm_type') == '0' ? 'selected' : '' }}>Legal</option>
                                        <option value="1" {{ old('firm_type') == '1' ? 'selected' : '' }}>Physical</option>
                                    </select>
                                    @error('firm_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="brand_name" class="form-label">brand_name</label>
                                    <input class="form-control @error('brand_name') is-invalid @enderror" type="text" name="brand_name" value="{{ old('brand_name') }}">
                                    @error('brand_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="firm_name" class="form-label">firm_name</label>
                                    <input class="form-control @error('firm_name') is-invalid @enderror" type="text" name="firm_name" value="{{ old('firm_name') }}">
                                    @error('firm_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="hvhh_group" class="form-group mb-3">
                                    <label for="hvhh" class="form-label">hvhh</label>
                                    <input class="form-control @error('hvhh') is-invalid @enderror" type="text" name="hvhh" value="{{ old('hvhh') }}">
                                    @error('hvhh')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="i_marz_id" class="form-label">i_marz_id</label>
                                    <select class="form-control @error('i_marz_id') is-invalid @enderror" name="i_marz_id">
                                        <option value="">Select Marz</option>

                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ old('i_marz_id') == $state->id ? 'selected' : '' }} >{{$state->name}}</option>
                                        @endforeach
                                        {{--                        <option value="Lori" {{ old('w_marz') == 'Lori' ? 'selected' : '' }}>Lori</option>--}}
                                        {{--                        <option value="Ararat" {{ old('w_marz') == 'Ararat' ? 'selected' : '' }}>Ararat</option>--}}
                                        {{--                        <!-- Add other marzes here -->--}}
                                    </select>
                                    @error('i_marz_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="i_address_group" class="form-group mb-3">
                                    <label for="i_address" class="form-label">i_address</label>
                                    <input class="form-control @error('i_address') is-invalid @enderror" type="text" name="i_address" value="{{ old('i_address') }}">
                                    @error('i_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="w_marz_id" class="form-label">w_marz_id</label>
                                    <select class="form-control @error('w_marz') is-invalid @enderror" name="w_marz_id">
                                        <option value="">Select Marz</option>

                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ old('w_marz_id') == $state->id ? 'selected' : '' }} >{{$state->name}}</option>
                                        @endforeach
                                        {{--                        <option value="Lori" {{ old('w_marz') == 'Lori' ? 'selected' : '' }}>Lori</option>--}}
                                        {{--                        <option value="Ararat" {{ old('w_marz') == 'Ararat' ? 'selected' : '' }}>Ararat</option>--}}
                                        {{--                        <!-- Add other marzes here -->--}}
                                    </select>
                                    @error('w_marz_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div id="W_address_group" class="form-group mb-3">
                                    <label for="w_address" class="form-label">w_address</label>
                                    <input class="form-control @error('w_address') is-invalid @enderror" type="text" name="w_address" value="{{ old('w_address') }}">
                                    @error('w_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ceo_name" class="form-label">CEO Name</label>
                                    <input class="form-control @error('ceo_name') is-invalid @enderror" type="text" name="ceo_name" value="{{ old('ceo_name') }}">
                                    @error('ceo_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ceo_phone" class="form-label">CEO Phone</label>
                                    <input class="form-control @error('ceo_phone') is-invalid @enderror" type="text" name="ceo_phone" value="{{ old('ceo_phone') }}">
                                    @error('ceo_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="firm_email" class="form-label">Firm Email</label>
                                    <input class="form-control @error('firm_email') is-invalid @enderror" type="email" name="firm_email" value="{{ old('firm_email') }}">
                                    @error('firm_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="firm_bank" class="form-label">firm_bank</label>
                                    <select class="form-control @error('firm_bank') is-invalid @enderror" type="text" name="firm_bank" >

                                    <option value="AmeriaBank">Ameria Bank</option>
                                        <option value="InecoBank">Ineco Bank</option>
                                    </select>
                                    @error('firm_bank')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group mb-3">
                                    <label for="firm_bank_hh" class="form-label">firm_bank_hh</label>
                                    <input class="form-control @error('firm_bank_hh') is-invalid @enderror" type="text" name="firm_bank_hh" value="{{ old('firm_bank_hh') }}">
                                    @error('firm_bank_hh')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="price_id" class="form-label">price_id</label>
                                    <select class="form-control @error('price_id') is-invalid @enderror" name="price_id">
                                        <option value="">Select price</option>

                                        @foreach($prices as $price)
                                            <option value="{{$price->id}}" >{{$price->detail}} - {{$price->amount}}</option>
                                        @endforeach
                                        {{--                        <option value="Lori" {{ old('w_marz') == 'Lori' ? 'selected' : '' }}>Lori</option>--}}
                                        {{--                        <option value="Ararat" {{ old('w_marz') == 'Ararat' ? 'selected' : '' }}>Ararat</option>--}}
                                        {{--                        <!-- Add other marzes here -->--}}
                                    </select>
                                    @error('price_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="paymanagir_start" class="form-label">Paymanagir Start</label>
                                    <input class="form-control @error('paymanagir_start') is-invalid @enderror" type="date" name="paymanagir_start" value="{{ old('paymanagir_start') }}">
                                    @error('paymanagir_start')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group mb-3">
                                    <label for="signed" class="form-label">Signed</label>
                                    <input class="form-check-input" type="checkbox" name="signed" value="1" {{ old('signed') ? 'checked' : '' }}>
                                    @error('signed')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                                    @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>



                                {{--                <div class="form-group mb-3">--}}
                                {{--                    <label for="simlist_1" class="form-label">SIM Card 1</label>--}}
                                {{--                    <select name="simlist_1" id="simlist_1" class="form-control @error('simlist_1') is-invalid @enderror">--}}
                                {{--                        <option value="">Select SIM Card</option>--}}
                                {{--                        @foreach($simlists as $simlist)--}}
                                {{--                            <option value="{{ $simlist->id }}" {{ old('simlist_1') == $simlist->id ? 'selected' : '' }}>--}}
                                {{--                                {{ $simlist->sim_number }} ({{ $simlist->sim_code }})--}}
                                {{--                            </option>--}}
                                {{--                        @endforeach--}}
                                {{--                    </select>--}}
                                {{--                    @error('simlist_1')--}}
                                {{--                    <span class="invalid-feedback">{{ $message }}</span>--}}
                                {{--                    @enderror--}}
                                {{--                </div>--}}

                                {{--                <div class="form-group mb-3">--}}
                                {{--                    <label for="simlist_2" class="form-label">SIM Card 2</label>--}}
                                {{--                    <select name="simlist_2" id="simlist_2" class="form-control @error('simlist_2') is-invalid @enderror">--}}
                                {{--                        <option value="">Select SIM Card</option>--}}
                                {{--                        @foreach($simlists as $simlist)--}}
                                {{--                            <option value="{{ $simlist->id }}" {{ old('simlist_2') == $simlist->id ? 'selected' : '' }}>--}}
                                {{--                                {{ $simlist->sim_number }} ({{ $simlist->sim_code }})--}}
                                {{--                            </option>--}}
                                {{--                        @endforeach--}}
                                {{--                    </select>--}}
                                {{--                    @error('simlist_2')--}}
                                {{--                    <span class="invalid-feedback">{{ $message }}</span>--}}
                                {{--                    @enderror--}}
                                {{--                </div>--}}

                            </div>

                            <!-- Section 2 -->
                            <div class="section" id="section-2" style="display: none;">
                                <h3>Section 2</h3>



                                <div class="form-group mb-3">
                                    <label for="x_gps" class="form-label">X GPS</label>
                                    <input class="form-control @error('x_gps') is-invalid @enderror" type="text" name="x_gps" value="{{ old('x_gps') }}">
                                    @error('x_gps')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="y_gps" class="form-label">Y GPS</label>
                                    <input class="form-control @error('y_gps') is-invalid @enderror" type="text" name="y_gps" value="{{ old('y_gps') }}">
                                    @error('y_gps')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nkar" class="form-label">Nkar (Image)</label>
                                    <input class="form-control @error('nkar') is-invalid @enderror" type="file" name="nkar">
                                    @error('nkar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="their_hardware" class="form-label">their_hardware</label>
                                    <input class="form-control @error('their_hardware') is-invalid @enderror" type="text" name="their_hardware" value="{{ old('their_hardware') }}">
                                    @error('their_hardware')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="patasxanatu" class="form-label">patasxanatu</label>
                                    <input class="form-control @error('patasxanatu') is-invalid @enderror" type="text" name="patasxanatu" value="{{ old('patasxanatu') }}">
                                    @error('patasxanatu')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="patasxanatu_phone" class="form-label">patasxanatu_phone</label>
                                    <input class="form-control @error('patasxanatu_phone') is-invalid @enderror" type="text" name="patasxanatu_phone" value="{{ old('patasxanatu_phone') }}">
                                    @error('patasxanatu_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="patasxanatu_date" class="form-label">patasxanatu_date</label>
                                    <input class="form-control @error('patasxanatu_date') is-invalid @enderror" type="date" name="patasxanatu_date" value="{{ old('patasxanatu_date') }}">
                                    @error('patasxanatu_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="section" id="section-3" style="display: none;">
                                <h3>Section 3</h3>


                                <div class="form-group mb-3">
                                    <label for="building_type" class="form-label">building_type</label>
                                    <input class="form-control @error('building_type') is-invalid @enderror" type="text" name="building_type" value="{{ old('building_type') }}">
                                    @error('building_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="paymanagir_end" class="form-label">Paymanagir End</label>
                                    <input class="form-control @error('paymanagir_end') is-invalid @enderror" type="date" name="paymanagir_end" value="{{ old('paymanagir_end') }}">
                                    @error('paymanagir_end')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="paymnanagir_received" class="form-label">paymnanagir_received</label>
                                    <input class="form-check-input" type="checkbox" name="activepaymnanagir_received" value="1" {{ old('paymnanagir_received') ? 'checked' : '' }}>
                                    @error('paymnanagir_received')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input type="checkbox" name="send_to_api" id="send_to_api" class="form-check-input">
                                    <label for="send_to_api" class="form-check-label">Send to API</label>
                                </div>
                            </div>

                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>

<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sectionButtons = document.querySelectorAll('.section-btn');
        const sections = document.querySelectorAll('.section');

        sectionButtons.forEach(button => {
            button.addEventListener('click', function () {
                const sectionId = this.getAttribute('data-section');
                sections.forEach(section => section.style.display = 'none');
                document.getElementById('section-' + sectionId).style.display = 'block';
            });
        });

        const firmType = document.getElementById('firm_type');
        const hvhhGroup = document.getElementById('hvhh_group');
        const iAddressGroup = document.getElementById('i_address_group');

        function toggleFields() {
            if (firmType.value == '1') {
                hvhhGroup.style.display = 'none';
                iAddressGroup.style.display = 'none';
            } else {
                hvhhGroup.style.display = 'block';
                iAddressGroup.style.display = 'block';
            }
        }
        firmType.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
</body>
</html>
