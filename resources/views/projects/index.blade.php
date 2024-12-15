<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Data-Table-styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Data-Table.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body id="page-top">
<div id="wrapper">
    <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
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
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="navbar-nav flex-nowrap ms-auto">
                        <li class="nav-item dropdown no-arrow mx-1"></li>
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                    <span class="d-none d-lg-inline me-2 text-gray-600 small">Valerie Luna</span>
                                </a>
                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                    <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Log Out</a></li>
                    </ul>
                </div>
            </nav>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('statusReport'))
                <div class="alert alert-info">
                    {{ session('statusReport') }}
                </div>
            @endif
            <div class="container-fluid">
                <h3 class="text-dark mb-4">Object</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Object info</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-nowrap">
                                <a class="btn btn-success" href="{{ route('projects.create') }}">Ստեղծել Նոր Օբեկտ</a>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th style="width: 190.078px;">ID</th>
                                        <th>Ամսաթիվ</th>
                                        <th style="width: 70.688px;">իրավ/ֆիզ</th>
                                        <th>Անվանում</th>
                                        <th>գ.հասցե</th>
                                        <th>տնօրեն</th>
                                        <th>հեռախոս</th>
                                        <th>օբ. տեսակ</th>
                                        <th>sim/hard</th>
                                        <th>պայմանագիր</th>
                                    </tr>
                                    </thead>







                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>

                                                <form action="{{ route('projects.generatePaymanagirIdMarz', $project->id) }}" method="POST">
                                                    @csrf
                                                   @if($project->paymanagir_start == null)
                                                        <button class="btn btn-secondary" disabled>ստորագրել</button>


                                                    @elseif($project->paymanagir_id_marz)
                                                        <a href="{{ route('projects.show', $project->id) }}">
                                                            <button class="btn btn-success" disabled>{{ $project->paymanagir_id_marz }}</button>

                                                        </a>
                                                    @else
                                                        <button class="btn btn-primary">ստորագրել</button>
                                                   @endif






{{--                                                    @if ($project->paymanagir_id_marz)--}}
{{--                                                         <a href="{{ route('projects.show', $project->id) }}">--}}
{{--                                                             <button class="btn btn-success" disabled>{{ $project->paymanagir_id_marz }}</button>--}}

{{--                                                         </a>--}}
{{--                                                    @else--}}
{{--                                                        <button class="btn btn-primary">ստորագրել</button>--}}
{{--                                                    @endif--}}
                                                </form>
                                            </td>
                                            <td>{{ $project->paymanagir_start }} </td>

                                            @if($project->firm_type == 1)
                                            <td>Ֆիզիկական</td>
                                            @elseif($project->firm_type == 0)
                                            <td>Իրավաբանական</td>
                                            @endif

                                            <td>{{ $project->firm_name }}</td>
                                            <td>{{ $project->w_address }}</td>
                                            <td>{{ $project->ceo_name }}</td>
					    <td>{{ $project->ceo_phone }}</td>

                                            <td>{{ $project->building_type }}</td>
                                            <td>
                                                <!-- Открытие модального окна -->
                                                <button onclick="openModal({{ $project->id }})" class="w3-button w3-green">սարքեր</button>
                                            </td>
                                            <td>
                                                @if($project->paymanagir_start)
                                                    <form action="{{ route('projects.export', $project->id) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-secondary">Export</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary" disabled>Export</button>
                                                @endif
                                            </td>
                                            <td>{{ $project->active ? 'Yes' : 'No' }}</td>


                                                 <td>
                                                @if($project->status == 1 && $project->status_edit == 1)
                                                    <button class="btn btn-success" disabled>✔</button>
                                                @else
                                                    @if($project->status == 1 && $project->status_edit == 0)
                                                        <span style="color: red;">(Обновление не успешно для сервера)</span>
                                                        <button class="btn btn-danger open-modal" data-error="Обновление не успешно для сервера" data-id="{{ $project->id }}">✘</button>
                                                    @elseif($project->status == 0 && $project->status_edit == 1)
                                                        <span style="color: red;">(В базе данных сейчас отсутствует данный объект)</span>
                                                        <button class="btn btn-danger open-modal" data-error="В базе данных сейчас отсутствует данный объект" data-id="{{ $project->id }}">✘</button>
                                                    @elseif($project->status == 0 && $project->status_edit == 0)
                                                        <button class="btn btn-danger open-modal" data-error=" 0 0" data-id="{{ $project->id }}">✘</button>

                                                    @endif
                                                @endif
                                            </td>

                                            <td>

                                                <a href="{{ route('projects.edit', $project->id) }}">
                                                    <button class="btn btn-warning">Edit</button>
                                                </a>
                                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">Delete</button>
                                    	        </form>
                                            </td>



                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>



                                     <tr>
                                        <th style="width: 190.078px;">ID</th>
                                        <th>Ամսաթիվ</th>
                                        <th style="width: 70.688px;">իրավ/ֆիզ</th>
                                        <th>Անվանում</th>
                                        <th>գ.հասցե</th>
                                        <th>տնօրեն</th>
                                        <th>հեռախոս</th>
                                        <th>օբ. տեսակ</th>
                                        <th>sim/hard</th>
                                        <th>պայմանագիր</th>
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
                <footer class="bg-white sticky-footer">
                    <div class="container my-auto">
                        <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
                    </div>
                </footer>
            </div>
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="projectModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
        <div class="w3-center">
            <span onclick="closeModal()" class="w3-button w3-xlarge w3-hover-red w3-display-topright">&times;</span>
            <h3>Update Items for Project</h3>
        </div>
        <form id="updateItemsForm" method="POST">
            @csrf
            <div class="w3-container">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" class="w3-input" placeholder="Enter serial or number" oninput="performSearch()">

                <div id="searchResults" class="w3-margin-top">
                    <!-- Результаты поиска будут загружены сюда -->
                </div>

                <button type="submit" class="w3-button w3-green w3-margin-top">Submit</button>
            </div>
        </form>


    </div>
</div>
<!-- Модальное окно для отображения ошибок -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Ошибка</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
            <div class="modal-footer">
                <form id="retryForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Попробовать заново</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset('assets/js/theme.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Открытие модального окна с передачей данных об ошибке
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', function () {
                const error = this.dataset.error;
                const id = this.dataset.id;
                const formAction = "{{ url('projects') }}/" + id + "/check-status";

                document.getElementById('errorMessage').innerText = error;
                document.getElementById('retryForm').setAttribute('action', formAction);

                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        });
    });
</script>
<script>
    function performSearch() {
        const query = document.getElementById('search').value;

        fetch(`/search-items?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = '';

                if (data.simlists.length === 0 && data.hardwares.length === 0) {
                    resultsContainer.innerHTML = '<p>No results found.</p>';
                    return;
                }

                if (data.simlists.length > 0) {
                    const simlistHeader = document.createElement('h4');
                    simlistHeader.innerText = 'Simlists:';
                    resultsContainer.appendChild(simlistHeader);

                    data.simlists.forEach(simlist => {
                        const option = document.createElement('div');
                        option.classList.add('w3-padding');
                        option.innerHTML = `
                            <input type="checkbox" name="simlists[]" value="${simlist.id}"
                                   ${simlist.project_id !== null ? 'checked' : ''}>
                            <label>${simlist.number} ${simlist.project_id !== null ? '(linked)' : ''}</label>
                        `;
                        resultsContainer.appendChild(option);
                    });
                }

                if (data.hardwares.length > 0) {
                    const hardwareHeader = document.createElement('h4');
                    hardwareHeader.innerText = 'Hardwares:';
                    resultsContainer.appendChild(hardwareHeader);

                    data.hardwares.forEach(hardware => {
                        const option = document.createElement('div');
                        option.classList.add('w3-padding');
                        option.innerHTML = `
                            <input type="checkbox" name="hardwares[]" value="${hardware.id}"
                                   ${hardware.project_id !== null ? 'checked' : ''}>
                            <label>${hardware.serial} ${hardware.project_id !== null ? '(linked)' : ''}</label>
                        `;
                        resultsContainer.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    }
</script>


<script>
    function openModal(projectId) {
        const form = document.getElementById('updateItemsForm');
        form.action = `/projects/${projectId}/update-items`; // Устанавливаем корректный маршрут
        document.getElementById('projectModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('projectModal').style.display = 'none';
    }
</script>
</body>
</html>

{{--    <!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Projects</title>--}}
{{--    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="w3-container">--}}
{{--    <h2>Projects</h2>--}}

{{--    <table class="w3-table w3-bordered w3-striped">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Firm Bank</th>--}}
{{--            <th>Actions</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach ($projects as $project)--}}
{{--            <tr>--}}
{{--                <td>{{ $project->firm_bank }}</td>--}}
{{--                <td>--}}
{{--                    <!-- Открытие модального окна -->--}}
{{--                    <button onclick="openModal({{ $project->id }})" class="w3-button w3-green">Update</button>--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    <!-- Кнопка для сброса project_id -->--}}
{{--                    <form action="{{ route('projects.restore', $project->id) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="w3-button w3-red">Reset</button>--}}
{{--                    </form>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}

{{--<!-- Modal -->--}}
{{--<div id="projectModal" class="w3-modal" style="display: none;">--}}
{{--    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">--}}
{{--        <div class="w3-center">--}}
{{--            <span onclick="closeModal()" class="w3-button w3-xlarge w3-hover-red w3-display-topright">&times;</span>--}}
{{--            <h3>Update Items for Project</h3>--}}
{{--        </div>--}}
{{--        <form id="updateItemsForm" method="POST">--}}
{{--            @csrf--}}
{{--            <div class="w3-container">--}}
{{--                <label for="search">Search:</label>--}}
{{--                <input type="text" id="search" name="search" class="w3-input" placeholder="Enter serial or number" oninput="performSearch()">--}}

{{--                <div id="searchResults" class="w3-margin-top">--}}
{{--                    <!-- Результаты поиска будут загружены сюда -->--}}
{{--                </div>--}}

{{--                <button type="submit" class="w3-button w3-green w3-margin-top">Submit</button>--}}
{{--            </div>--}}
{{--        </form>--}}


{{--    </div>--}}
{{--</div>--}}
{{--<script>--}}
{{--    function performSearch() {--}}
{{--        const query = document.getElementById('search').value;--}}

{{--        fetch(`/search-items?query=${query}`)--}}
{{--            .then(response => response.json())--}}
{{--            .then(data => {--}}
{{--                const resultsContainer = document.getElementById('searchResults');--}}
{{--                resultsContainer.innerHTML = '';--}}

{{--                if (data.simlists.length === 0 && data.hardwares.length === 0) {--}}
{{--                    resultsContainer.innerHTML = '<p>No results found.</p>';--}}
{{--                    return;--}}
{{--                }--}}

{{--                if (data.simlists.length > 0) {--}}
{{--                    const simlistHeader = document.createElement('h4');--}}
{{--                    simlistHeader.innerText = 'Simlists:';--}}
{{--                    resultsContainer.appendChild(simlistHeader);--}}

{{--                    data.simlists.forEach(simlist => {--}}
{{--                        const option = document.createElement('div');--}}
{{--                        option.classList.add('w3-padding');--}}
{{--                        option.innerHTML = `--}}
{{--                            <input type="checkbox" name="simlists[]" value="${simlist.id}"--}}
{{--                                   ${simlist.project_id !== null ? 'checked' : ''}>--}}
{{--                            <label>${simlist.number} ${simlist.project_id !== null ? '(linked)' : ''}</label>--}}
{{--                        `;--}}
{{--                        resultsContainer.appendChild(option);--}}
{{--                    });--}}
{{--                }--}}

{{--                if (data.hardwares.length > 0) {--}}
{{--                    const hardwareHeader = document.createElement('h4');--}}
{{--                    hardwareHeader.innerText = 'Hardwares:';--}}
{{--                    resultsContainer.appendChild(hardwareHeader);--}}

{{--                    data.hardwares.forEach(hardware => {--}}
{{--                        const option = document.createElement('div');--}}
{{--                        option.classList.add('w3-padding');--}}
{{--                        option.innerHTML = `--}}
{{--                            <input type="checkbox" name="hardwares[]" value="${hardware.id}"--}}
{{--                                   ${hardware.project_id !== null ? 'checked' : ''}>--}}
{{--                            <label>${hardware.serial} ${hardware.project_id !== null ? '(linked)' : ''}</label>--}}
{{--                        `;--}}
{{--                        resultsContainer.appendChild(option);--}}
{{--                    });--}}
{{--                }--}}
{{--            })--}}
{{--            .catch(error => {--}}
{{--                console.error('Error fetching search results:', error);--}}
{{--            });--}}
{{--    }--}}
{{--</script>--}}


{{--<script>--}}
{{--    function openModal(projectId) {--}}
{{--        const form = document.getElementById('updateItemsForm');--}}
{{--        form.action = `/projects/${projectId}/update-items`; // Устанавливаем корректный маршрут--}}
{{--        document.getElementById('projectModal').style.display = 'block';--}}
{{--    }--}}

{{--    function closeModal() {--}}
{{--        document.getElementById('projectModal').style.display = 'none';--}}
{{--    }--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}

