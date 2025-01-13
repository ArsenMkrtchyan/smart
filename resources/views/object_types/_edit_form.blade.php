<div class="modal-header">
    <h5 class="modal-title">Edit Object Type #{{ $objectType->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form id="editObjectTypeForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" name="name" id="name"
                   class="form-control"
                   value="{{ $objectType->name }}" required>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary"
            onclick="submitEditObjectTypeForm({{ $objectType->id }})">
        Обновить
    </button>
</div>
