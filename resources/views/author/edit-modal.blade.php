<!-- Edit Modal -->
<div class="modal fade" id="EditAuthorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="UpdateAuthorForm" method='POST' enctype="multipart/form-data">
                @method('PUT')
                <div class="modal-body">

                    <input type="hidden" name="author_id" id="author_id">

                    <ul class="alert alert-warning d-none" id="update_errorList"></ul>

                    <div class="form-group mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" id="edit_first_name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" id="edit_last_name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" id="edit_middle_name" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End - Edit Modal -->
