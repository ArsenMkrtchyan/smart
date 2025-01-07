<table class="table my-0">
    <thead>
    <tr>
        <th><strong>Օբ․ ID</strong></th>
        <th><strong>Անվանում</strong></th>
        <th><strong>օբ.Հասցե</strong></th>
        <th><strong>Տնօրեն</strong></th>
        <th>Հեռախոս</th>
        <th>Տեսակ</th>
        <th>Կարգավիճակ</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($projects as $project)
        <tr>
            <td>
                <img class="rounded-circle me-2"
                     width="30" height="30"
                     src="{{ asset('assets/img/avatars/avatar1.jpeg') }}"
                >
                &nbsp;{{ $project->id }}
            </td>
            <td>{{ $project->brand_name }}</td>

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
            <td>{{ $project->i_address }}</td>
            <td>{{ $project->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Пагинация --}}
<div class="mt-3">
    {{ $projects->links() }}
</div>
