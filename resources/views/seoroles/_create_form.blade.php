<div class="modal-header">
    <h5 class="modal-title">Create Seorole</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form id="createSeoroleForm">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control" required>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary"
            data-bs-dismiss="modal">
        Cancel
    </button>
    <button type="button" class="btn btn-primary"
            onclick="submitCreateSeoroleForm()">
        Save
    </button>
</div>
