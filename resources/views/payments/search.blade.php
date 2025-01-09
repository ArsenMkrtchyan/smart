@extends('layouts')

@section('content')
    <div class="container">
        <h1>Search & Pay</h1>

        {{-- Уведомление об успешной оплате --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Форма поиска --}}
        <form action="{{ route('payments.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search by brand name..." value="{{ $query ?? '' }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        @if(!empty($projects))
            {{-- Таблица результатов поиска --}}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Brand Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->brand_name ?? 'Project #'.$project->id }}</td>

                            {{-- Кнопка "Pay" --}}
{{--                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#payModal"--}}
{{--                                    data-project-id="{{ $project->id }}" data-brand-name="{{ $project->brand_name }}">--}}
{{--                                Pay--}}
{{--                            </button>--}}
                        <td>
                            <a href="{{ route('payments.createForProject', ['project' => $project->id]) }}" class="btn btn-success btn-sm">Pay</a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No projects found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        @else
            <p class="text-muted">Enter a query to search for projects.</p>
        @endif
    </div>

    {{-- Модальное окно для оплаты --}}
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('payments.storeForProject') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="payModalLabel">Make a Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="project_id" id="modalProjectId">

                    <div class="mb-3">
                        <label for="modalBrandName" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="modalBrandName" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" name="amount" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optional)</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const payModal = document.getElementById('payModal');
        payModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const projectId = button.getAttribute('data-project-id');
            const brandName = button.getAttribute('data-brand-name');

            document.getElementById('modalProjectId').value = projectId;
            document.getElementById('modalBrandName').value = brandName;
        });
    </script>
@endsection
