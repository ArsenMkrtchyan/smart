<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Create Coin - Brand</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Data-Table-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Data-Table.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
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
{{--            <ul class="navbar-nav text-light" id="accordionSidebar">--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('clients.index') }}"><i class="fas fa-table"></i><span>Clients</span></a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('finances.index') }}"><i class="fas fa-table"></i><span>Finance</span></a></li>--}}
{{--                @if(Auth::check() && Auth::user()->is_admin == 1)--}}
{{--                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users"></i><span>Users</span></a></li>--}}
{{--                @endif--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--                        <i class="fas fa-sign-out-alt"></i><span>Logout</span></a>--}}
{{--                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>--}}
{{--                </li>--}}
{{--            </ul>--}}
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
                <h3 class="text-dark mb-4">Create Sim info</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">New Sim </p>
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

                        <form action="{{ route('simlists.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="sim_info">sim_info:</label>
                                <input type="text" name="sim_info" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="number">number:</label>
                                <input type="text" name="number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="sim_id">sim_id:</label>
                                <input type="text" name="sim_id" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="price">price:</label>
                                <input type="text" name="price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="mb">MB:</label>
                                <input type="number" name="mb" class="form-control" required>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="project_id">Project:</label>--}}
{{--                                <select id="project_id" name="project_id" required>--}}
{{--                                    @foreach ($projects as $project)--}}
{{--                                        <option value="{{ $project->id }}">{{ $project->firm_bank }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}


{{--                            </div>--}}

                            <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>
