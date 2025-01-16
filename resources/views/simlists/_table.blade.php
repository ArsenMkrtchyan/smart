<table class="table my-0">
    <thead>
    <tr>
        <th><strong>SIM Համար</strong></th>
        <th><strong>SIM Կոդ ICMC</strong></th>
        <th><strong>Օպերատոր</strong></th>
        <th><strong>Պահեստ</strong></th>
        <th><strong>Իդենտ համարը</strong></th>
        <th>Կարգավիճակ</th>
        <th><strong>ամսաթիվ</strong></th>
        <th><strong>Գործողություն</strong></th>
    </tr>
    </thead>
    <tbody>
        @foreach($simlists as $simlist)
            <tr>
                <td> {{$simlist->number}}</td>
                <td> {{$simlist->sim_info}}</td>
                <td> {{$simlist->sim_id}}</td>

                <td> {{$simlist->worker->name}} - {{$simlist->worker->female}}</td>
                @if($simlist->ident_id == null)
                    <td>-</td>
                    <td>pahest</td>
                @else
                    <td>{{$simlist->ident_id}}</td>
                    <td>texadrvac</td>
                @endif
                <td>{{ $simlist->created_at ? \Carbon\Carbon::parse($simlist->created_at)->format('d,m,Y') : '-' }}</td>




                <td>
                    <form  method="POST" >
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('simlists.edit', $simlist->id) }}" class="btn btn-primary">Edit</a>

                    </form>
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
            @if ($simlists->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $simlists->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($simlists->links()->elements[0] as $page => $url)
                @if ($page == $simlists->currentPage())
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
            @if ($simlists->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $simlists->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
