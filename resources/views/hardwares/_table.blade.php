<table class="table my-0">
    <thead>
    <tr>
        <th><strong>Անվանում</strong></th>
        <th><strong>Serial</strong></th>
        <th>Պահեստ</th>
        <th>Իդենտ․ համար</th>
        <th>Ամսաթիվ</th>
        <th>Կարգավիճակ</th>
        <th>Գործողություն</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($hardwares as $hardware)
        <tr>
            <td>{{$hardware->name}}</td>
            <td>{{$hardware->serial}}</td>
            <td>{{$hardware->worker->name}} {{$hardware->worker->female}}</td>
            <td>-</td>
            <td>{{ $hardware->created_at ? \Carbon\Carbon::parse($hardware->created_at)->format('d,m,Y') : '-' }}</td>
            <td>Վաճառված</td>


            <td>   <a href="{{ route('hardwares.edit', $hardware->id) }}">
                    <button class="btn btn-warning">Edit</button>
                </a></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Пагинация --}}
<div class="mt-3 d-flex justify-content-center">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($hardwares->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $hardwares->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($hardwares->links()->elements[0] as $page => $url)
                @if ($page == $hardwares->currentPage())
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
            @if ($hardwares->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $hardwares->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
