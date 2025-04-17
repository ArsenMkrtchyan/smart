@extends('layouts')

@section('content')
    <div class="container">
        <h3>Unique ակտեր</h3>

        <a href="{{ route('uniques.create') }}" class="btn btn-primary mb-3">+ Create</a>

        @include('partials.flash')

        <table class="table table-bordered align-middle table-responsive">
            <thead class="table-light">
            <tr>
                <th>ID</th><th>Project</th><th>Գումար</th>
                <th>Export date</th><th style="width:210px">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($uniques as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->project->brand_name ?? '—' }}</td>
                    <td>{{ $u->gumar }}</td>
                    <td>{{ optional($u->export_date)->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('uniques.edit',$u) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('uniques.destroy',$u) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Del</button>
                        </form>

                        {{--  Экспорт --}}
                        @if($u->can_export)
                            <a href="{{ route('uniques.export',$u) }}"
                               class="btn btn-success btn-sm">Export</a>
                        @else
                            <button class="btn btn-success btn-sm" disabled>Export</button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $uniques->links() }}
    </div>
@endsection
