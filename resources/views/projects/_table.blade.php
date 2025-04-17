@php
    // Читаем человеко‑читаемые подписи статусов once
    $statusLabels = [
        1 => 'սպասվող',
        2 => 'Հրաժարված',
        3 => 'Պայմանագիրը լուծարված',
        4 => 'Պայմանագրի ընդացք',
        5 => 'կարգավորման ընդացք',
        6 => '911-ին միացված',
    ];
@endphp

<table class="table table-hover align-middle">
    <thead class="table-light">
    <tr>
        <th>Օբ․ ID</th>
        <th>Ident</th>
        <th>ֆիզ/իրավ</th>
        <th>Անվանում</th>
        <th>օբ. Հասցե</th>
        <th>Տնօրեն</th>
        <th>Հեռախոս</th>
        <th>Տեսակ</th>
        <th>Կարգավիճակ</th>
        <th>edit</th>
        <th>paymanagir</th>
        <th>act</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($projects as $project)

        @php
            /* -------------------------------------------------------------
             * 1) «Красный» (= table‑danger) если чего‑то важного нет
             * -----------------------------------------------------------*/
            $isIncomplete = empty($project->ident_id)
                         || empty($project->paymanagir_start)
                         || empty($project->price_id)
                         || empty($project->x_gps)
                         || empty($project->y_gps)
                         || empty($project->nkar);

            /* -------------------------------------------------------------
             * 2) «Жёлтый» (= table‑warning) если object_check == 5
             *    ИЛИ type_id == 1, но только если НЕ красный
             * -----------------------------------------------------------*/
            $isWarning = !$isIncomplete && (
                            $project->object_check == 1

                         );

            $rowClass = $isIncomplete ? 'table-danger'
                      : ($isWarning   ? 'table-warning' : 'table-success');
        @endphp

        <tr class="{{ $rowClass }}">

            {{-- === ID + фото/карта === --}}
            <td>
                @if($project->x_gps && $project->y_gps)
                    <a href="https://www.google.com/maps?q={{ $project->y_gps }},{{ $project->x_gps }}" target="_blank">
                        <img class="rounded-circle me-2" width="30" height="30"
                             src="/image/{{ $project->nkar ?? 'nophoto.png' }}">
                    </a>
                @else
                    <img class="rounded-circle me-2" width="30" height="30"
                         src="/image/{{ $project->nkar ?? 'nophoto.png' }}">
                @endif
                {{ $project->id }}
            </td>

            {{-- Остальные колонки --}}
            <td>{{ $project->ident_id ?? '—' }}</td>
            <td>{{ $project->hvhh ? 'իրավ' : 'ֆիզ' }}</td>
            <td>{{ $project->firm_name }}</td>
            <td>
                @if($project->w_marz_id)
                    {{ $project->wMarz->name }} – {{ $project->wMarz->district }} – {{ $project->w_address }}
                @else
                    {{ $project->w_address }}
                @endif
            </td>
            <td>{{ $project->ceo_name }}</td>
            <td>{{ $project->ceo_phone }}</td>
            <td>{{ $project->object_type->name ?? '—' }}</td>
            <td>{{ $statusLabels[$project->object_check] ?? '—' }}</td>

            {{-- ==== действия ==== --}}
            <td>
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
            </td>

            {{-- paymanagir export --}}
            <td>
                @if($project->paymanagir_start)
                    <form action="{{ route('projects.export', $project) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-secondary btn-sm">Export</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>Export</button>
                @endif
            </td>

            {{-- act export (если разрешён) --}}
            <td>
                @if($project->act_enable && $project->paymanagir_start)
                    <form action="{{ route('projects.exportact', $project) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-secondary btn-sm">Export</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>Export</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Пагинация --}}
<div class="mt-3 d-flex justify-content-center">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($projects->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $projects->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($projects->links()->elements[0] as $page => $url)
                @if ($page == $projects->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($projects->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $projects->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
