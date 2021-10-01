<!-- Add Modal -->
<div class="modal fade" id="AddBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="AddBookForm" method='POST' enctype="multipart/form-data">
                <div class="modal-body">

                    <ul class="alert alert-warning d-none" id="save_errorList"></ul>

                    <div class="form-group mb-3">
                        <label>Book Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Author Name</label>
                        @foreach($authors as $author)
                            <div class="form-check">
                                <input class="form-check-input" name="author[]" type="checkbox"
                                       value="{{$author->id}}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$author->getFioAttribute()}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Is Published</label>
                        <select class="form-select" name="is_published" aria-label="Default select example">
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </select>
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
