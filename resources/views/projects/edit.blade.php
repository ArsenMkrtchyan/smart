


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
                            <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" style="width: 964px; margin: 34px;">
                                @csrf
                                @method('PUT')
                                <h2 class="text-center">Edit Project Details</h2>

                                <!-- Section Navigation -->
                                <div class="mb-4 text-center">
                                    <button type="button" class="btn btn-secondary section-btn" data-section="1">Ֆիրմայի տվյալներ</button>
                                    <button type="button" class="btn btn-secondary section-btn" data-section="2">տեխնիկական տվյալներ</button>
                                    <button type="button" class="btn btn-secondary section-btn" data-section="3">Section 3</button>
                                </div>

                                <!-- Section 1 -->
                                <div class="section" id="section-1">
                                    <h3>Section 1</h3>
                                    <div class="form-group mb-3">
                                        <label for="firm_type" class="form-label">Firm Type</label>
                                        <select class="form-control" name="firm_type" id="firm_type">
                                            <option value="0" {{ $project->firm_type == '0' ? 'selected' : '' }}>Իրավաբանական</option>
                                            <option value="1" {{ $project->firm_type == '1' ? 'selected' : '' }}>Ֆիզիկական</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="brand_name" class="form-label">Բրենդի անվանում(եթե ունի)</label>
                                        <input class="form-control" type="text" name="brand_name" value="{{ $project->brand_name }}">
                                    </div>
                                    <div id="hvhh_group" class="form-group mb-3">
                                        <label for="hvhh" class="form-label">ՀՎՀՀ</label>
                                        <input class="form-control" type="text" name="hvhh" value="{{ $project->hvhh }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="i_marz_id" class="form-label">Մարզի անվանում</label>
                                        <select class="form-control" name="i_marz_id">
                                            <option value="">Ընտրել Մարզը</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" {{ $project->i_marz_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="i_address_group" class="form-group mb-3">
                                        <label for="i_address" class="form-label">Իրավաբանական հասցե</label>
                                        <input class="form-control" type="text" name="i_address" value="{{ $project->i_address }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="w_marz_id" class="form-label">Գործունեության հասցեի Մարզ</label>
                                        <select class="form-control" name="w_marz_id">
                                            <option value="">ընտրել մարզը</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" {{ $project->w_marz_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="W_address_group" class="form-group mb-3">
                                        <label for="w_address" class="form-label">Գործունեության հասցե</label>
                                        <input class="form-control" type="text" name="w_address" value="{{ $project->w_address }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="ceo_name" class="form-label">Տնօենի անուն ազգանուն</label>
                                        <input class="form-control" type="text" name="ceo_name" value="{{ $project->ceo_name }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="ceo_phone" class="form-label">տնօրենի հառախոսահամար</label>
                                        <input class="form-control" type="text" name="ceo_phone" value="{{ $project->ceo_phone }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="firm_email" class="form-label">E-mail հասցե </label>
                                        <input class="form-control" type="email" name="firm_email" value="{{ $project->firm_email }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="firm_bank" class="form-label">բանկի անվանում</label>
                                        <input class="form-control" type="text" name="firm_bank" value="{{ $project->firm_bank }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="firm_bank_hh" class="form-label">բանկային հաշվի համար</label>
                                        <input class="form-control" type="text" name="firm_bank_hh" value="{{ $project->firm_bank_hh }}">
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="section" id="section-2" style="display: none;">
                                    <h3>Section 2</h3>
                                    <div class="form-group mb-3">
                                        <label for="x_gps" class="form-label">X GPS</label>
                                        <input class="form-control" type="text" name="x_gps" value="{{ $project->x_gps }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="y_gps" class="form-label">Y GPS</label>
                                        <input class="form-control" type="text" name="y_gps" value="{{ $project->y_gps }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nkar" class="form-label">Նկար (Image)</label>
                                        <input class="form-control" type="file" name="nkar">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="their_hardware" class="form-label">Their Hardware</label>
                                        <input class="form-control" type="text" name="their_hardware" value="{{ $project->their_hardware }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="patasxanatu" class="form-label">Patasxanatu</label>
                                        <input class="form-control" type="text" name="patasxanatu" value="{{ $project->patasxanatu }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="patasxanatu_phone" class="form-label">Patasxanatu Phone</label>
                                        <input class="form-control" type="text" name="patasxanatu_phone" value="{{ $project->patasxanatu_phone }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="patasxanatu_date" class="form-label">Patasxanatu Date</label>
                                        <input class="form-control" type="date" name="patasxanatu_date" value="{{ $project->patasxanatu_date }}">
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="section" id="section-3" style="display: none;">
                                    <h3>Section 3</h3>
                                    <div class="form-group mb-3">
                                        <label for="building_type" class="form-label">Օբեկտի տեսակ</label>
                                        <input class="form-control" type="text" name="building_type" value="{{ $project->building_type }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="paymanagir_start" class="form-label">Paymanagir Start</label>
                                        <input class="form-control" type="date" name="paymanagir_start" value="{{ $project->paymanagir_start }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="paymanagir_end" class="form-label">Paymanagir End</label>
                                        <input class="form-control" type="date" name="paymanagir_end" value="{{ $project->paymanagir_end }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="price_id" class="form-label">Price ID</label>
                                        <select class="form-control" name="price_id">
                                            @foreach ($prices as $price)
                                                <option value="{{ $price->id }}" {{ $project->price_id == $price->id ? 'selected' : '' }}>
                                                    {{ $price->detail }} - {{ $price->amount }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="signed" class="form-label">Signed</label>
                                        <input class="form-check-input" type="checkbox" name="signed" value="1" {{ $project->signed ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input class="form-check-input" type="checkbox" name="status" value="1" {{ $project->status ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
