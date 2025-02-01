<table class="table my-0">
    <thead>
    <tr>
        <th><strong>Օբ․ ID</strong></th>
        <th><strong>Ident</strong></th>
        <th><strong>ֆիզ/իրավ</strong></th>
        <th><strong>Անվանում</strong></th>
        <th><strong>օբ.Հասցե</strong></th>
        <th><strong>Տնօրեն</strong></th>
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
        <tr>
            <td>
                <img class="rounded-circle me-2"
                     width="30" height="30"
                     src="/image/{{$project->nkar}}"
                >
                &nbsp;{{ $project->id }}
            </td>
            <td>{{$project->ident_id}}</td>
            @if($project->hvhh == null)
                <td>ֆիզ</td>
            @else
                <td>իրավ</td>
            @endif
            <td>{{$project->firm_name}}</td>
            {{-- $project->state->name - $project->state->district - $project->w_address --}}
            <td>
                @if($project->w_marz_id)
                    {{ $project->wMarz->name }} - {{ $project->wMarz->district }} - {{ $project->w_address }}
                @else
                    {{ $project->w_address }}
                @endif
            </td>

            <td>{{ $project->ceo_name }}</td>
            <td>{{ $project->ceo_phone }}</td>
            @if($project->type_id == null)
              <td>-</td>
            @else
                <td>{{ $project->object_type->name }}</td>

            @endif



            @if($project->object_check == 1)
                <td>սպասվող</td>
                @elseif($project->object_check == 2)
                    <td>Հրաժարված</td>
                    @elseif($project->object_check == 3)
                        <td>այմանագիրը լուծարված<</td>
                        @elseif($project->object_check == 4)
                            <td>Պայմանագրի ընդացք</td>
                            @elseif($project->object_check == 5)
                                <td>կարգավորման ընդացք</td>
                                @elseif($project->object_check == 6)
                                    <td>911-ին միացված</td>
            @endif


            <td>   <a href="{{ route('projects.edit', $project->id) }}">
                    <button class="btn btn-warning">Edit</button>
                </a></td>
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
            <td>
                @if($project->paymanagir_start)
                    <form action="{{ route('projects.exportact', $project->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary">Export</button>
                    </form>
                @else
                    <button class="btn btn-secondary" disabled>Export</button>
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
