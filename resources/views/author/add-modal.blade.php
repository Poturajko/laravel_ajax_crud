<!-- Add Modal -->
<div class="modal fade" id="AddAuthorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="AddAuthorForm" method='POST' enctype="multipart/form-data">
                <div class="modal-body">

                    <ul class="alert alert-warning d-none" id="save_errorList"></ul>

                    <div class="form-group mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End - Add Modal -->
