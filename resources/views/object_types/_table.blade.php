<button class="btn btn-success" onclick="openCreateObjectType()">
    Create
</button>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($objectTypes as $obj)
        <tr>
            <td>{{ $obj->id }}</td>
            <td>{{ $obj->name }}</td>
            <td>
                <!-- Кнопка Edit -->
                <button class="btn btn-primary btn-sm"
                        data-id="{{ $obj->id }}"
                        onclick="openEditObjectType({{ $obj->id }})">
                    Edit
                </button>
                <!-- Кнопка Delete -->
                <button class="btn btn-danger btn-sm"
                        onclick="deleteObjectType({{ $obj->id }})">
                    Delete
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Кнопка Create -->
