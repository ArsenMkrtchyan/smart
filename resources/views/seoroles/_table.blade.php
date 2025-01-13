
<button class="btn btn-success" onclick="openCreateSeorole()">
    Create new seorole
</button>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($seoroles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>
                <button class="btn btn-sm btn-primary"
                        onclick="openEditSeorole({{ $role->id }})">
                    Edit
                </button>
                <button class="btn btn-sm btn-danger"
                        onclick="deleteSeorole({{ $role->id }})">
                    Delete
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

