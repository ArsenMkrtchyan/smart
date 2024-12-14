<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Blank Page - Brand</title>

    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Data-Table-styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Data-Table.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
</head>

<body id="page-top">
<div id="wrapper">
    <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
        <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Brand</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link" href="table.html"><i class="fas fa-table"></i><span>Table</span></a></li>
                <li class="nav-item"><a class="nav-link" href="login.html"><i class="far fa-user-circle"></i><span>Login</span></a></li>
            </ul>
            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <ul class="navbar-nav flex-nowrap ms-auto">
                        <li class="nav-item dropdown no-arrow mx-1"></li>
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Valerie Luna</span></a>
                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Log Out</a></li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <h3 class="text-dark mb-1">Blank Page</h3>
            </div>
            <form class="bootstrap-form-with-validation" style="margin-left: 49px;" action="{{ route('users.store') }}" method="POST">
                @csrf
                <h2 class="text-center">create</h2>
                <div class="form-group mb-3"><label class="form-label" for="text-input">name</label><input class="form-control" type="text" name="name"></div>
                <div class="form-group mb-3"><label class="form-label" for="text-input">female</label><input class="form-control" type="text" name="female"></div>
                <div class="form-group mb-3"><label class="form-label" for="text-input">number</label><input class="form-control" type="text" name="number"></div>
                <div class="form-group mb-3"><label class="form-label" for="password-input">Password </label><input class="form-control" type="password" id="password-input" name="password"></div>
                <div class="form-group mb-3"><label class="form-label" for="email-input">Email </label><input class="form-control" type="email" name="email"></div>
                <div class="form-group mb-3">
                    <label class="form-label" for="role-id">Role</label>
                    <select class="form-control" id="role-id" name="role_id" onchange="setIsAdmin()">
                        <option value="1">Worker</option>
                        <option value="2">Engineer</option>
                        <option value="3">Financist</option>
                        <option value="4">Admin</option>
                    </select>
                </div>
                <input type="hidden" id="is-admin" name="is_admin" value="0">
                <div class="form-group mb-3"><button class="btn btn-primary" type="submit">Submit</button></div>
            </form>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>

<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset('assets/js/theme.js')}}"></script>
<script>
    function setIsAdmin() {
        const roleId = document.getElementById('role-id').value;
        const isAdminInput = document.getElementById('is-admin');
        isAdminInput.value = roleId == 4 ? 1 : 0;
    }
</script>
</body>

</html>
