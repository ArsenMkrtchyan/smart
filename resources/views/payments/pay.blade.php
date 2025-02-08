@extends('layouts')

@section('content')
    <div class="container">
        <h1>Search & Pay</h1>

        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search by project brand name...">
        </div>

        <table class="table table-bordered" id="projectsTable">
            <thead>
            <tr>
                <th>Brand Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="2" class="text-center">Start typing to search for a project...</td>
            </tr>
            </tbody>
        </table>

        <form action="{{ route('payments.storeForProject') }}" method="POST" style="display: none;" id="paymentForm">
            @csrf
            <input type="hidden" name="project_id" id="project_id">

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Payment Date</label>
                <input type="date" class="form-control" name="date">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <input type="text" class="form-control" name="description">
            </div>

            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const tableBody = document.querySelector('#projectsTable tbody');
        const paymentForm = document.getElementById('paymentForm');
        const projectIdInput = document.getElementById('project_id');

        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);

            const query = this.value.trim();

            if (query.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="2" class="text-center">Start typing to search for a project...</td></tr>';
                return;
            }

            timeout = setTimeout(() => {
                fetch('{{ route('payments.search') }}?query=' + query)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(project => {
                                tableBody.innerHTML += `
                                    <tr>
                                        <td>${project.brand_name ?? 'Project #' + project.id}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm selectProject" data-id="${project.id}" data-name="${project.brand_name ?? 'Project #' + project.id}">
                                                Select
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            document.querySelectorAll('.selectProject').forEach(button => {
                                button.addEventListener('click', function () {
                                    const projectId = this.getAttribute('data-id');
                                    const projectName = this.getAttribute('data-name');

                                    paymentForm.style.display = 'block';
                                    projectIdInput.value = projectId;

                                    alert(`Selected Project: ${projectName}`);
                                });
                            });
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="2" class="text-center">No projects found.</td></tr>';
                        }
                    });
            }, 300); // Задержка перед отправкой запроса
        });
    </script>
@endsection
