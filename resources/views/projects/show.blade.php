<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>View Project - Brand</title>
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
                <h3 class="text-dark mb-4">Project Details</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Details of Project ID: {{ $project->paymanagir_id_marz }}</p>
                    </div>
                    <div class="card-body">
                        <!-- Section Navigation -->
                        <div class="mb-4 text-center">
                            <button type="button" class="btn btn-secondary section-btn" data-section="1">Firm Details</button>
                            <button type="button" class="btn btn-secondary section-btn" data-section="2">Technical Details</button>
                            <button type="button" class="btn btn-secondary section-btn" data-section="3">Other Details</button>
                        </div>

                        <!-- Section 1 -->
                        <div class="section" id="section-1">
                            <h3>Firm Details</h3>
                            <p><strong>Firm Type:</strong> {{ $project->firm_type == 0 ? 'Legal' : 'Physical' }}</p>
                            <p><strong>Firm Name:</strong> {{ $project->firm_name }}</p>
                            <p><strong>Brand Name:</strong> {{ $project->brand_name }}</p>
                            <p><strong>HVHH:</strong> {{ $project->hvhh ?? 'N/A' }}</p>
                            <p><strong>Marz (Legal Address):</strong> {{ optional($project->iMarz)->name ?? 'N/A' }}</p>
                            <p><strong>Legal Address:</strong> {{ $project->i_address ?? 'N/A' }}</p>
                            <p><strong>Marz (Work Address):</strong> {{ optional($project->wMarz)->name ?? 'N/A' }}</p>
                            <p><strong>Work Address:</strong> {{ $project->w_address ?? 'N/A' }}</p>
                        </div>

                        <!-- Section 2 -->
                        <div class="section" id="section-2" style="display: none;">
                            <h3>Technical Details</h3>
                            <p><strong>X GPS:</strong> {{ $project->x_gps }}</p>
                            <p><strong>Y GPS:</strong> {{ $project->y_gps }}</p>
                            <p><strong>Building Type:</strong> {{ $project->building_type }}</p>
                            <p><strong>Firm Bank:</strong> {{ $project->firm_bank }}</p>
                            <p><strong>Firm Bank HH:</strong> {{ $project->firm_bank_hh }}</p>
                        </div>

                        <!-- Section 3 -->
                        <div class="section" id="section-3" style="display: none;">
                            <h3>Other Details</h3>
                            <p><strong>CEO Name:</strong> {{ $project->ceo_name }}</p>
                            <p><strong>CEO Phone:</strong> {{ $project->ceo_phone }}</p>
                            <p><strong>Firm Email:</strong> {{ $project->firm_email }}</p>
                            <p><strong>Price:</strong> {{ optional($project->price)->amount ?? 'N/A' }}</p>
                            <p><strong>Contract Start:</strong> {{ $project->paymanagir_start }}</p>
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
    });
</script>
</body>
</html>
