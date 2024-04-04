<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Delete account : {{ $acct->acct }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                All statuses will be delete. Can't undo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('accounts.delete', $acct->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <input type="submit" class="btn btn-danger" value="Delete">

                </form>
            </div>
        </div>
    </div>
</div>
