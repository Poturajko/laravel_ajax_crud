@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Books Data
                            <a href="#" data-bs-toggle="modal" data-bs-target="#AddBookModal"
                               class="btn btn-primary btn-sm float-end">Add Book</a>
                        </h4>
                    </div>

                    <div class="card-header">
                        <form action="{{route('books.index')}}" method="GET">
                            @csrf
                            <div class="row justify-content-end">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="order_by" type="checkbox" value="name-a-z" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Name: A-Z
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="order_by" type="checkbox" value="name-z-a" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Name: Z-A
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="search" name="search_name" class="form-control rounded" placeholder="Search" aria-label="Search"
                                               aria-describedby="search-addon" />
                                        <button type="submit" class="btn btn-primary">Search</button>

                                        <a href="{{route('books.index')}}" class="btn btn-warning">Reset</a>
                                        <a href="{{route('index')}}" class="btn btn-success">Main Page</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book name</th>
                                <th>Description</th>
                                <th>Author name</th>
                                <th>Image</th>
                                <th>Published at</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td>{{$book->id}}</td>
                                    <td>{{$book->name}}</td>
                                    <td>{{$book->description}}</td>
                                    <td>
                                        @foreach($book->authors as $author)
                                            <p>{{$author->getFioAttribute()}}</p>
                                        @endforeach
                                    </td>
                                    <td><img src="{{\Illuminate\Support\Facades\Storage::url($book->image)}}"
                                             width="50px" height="50px" alt="Image"></td>
                                    <td>{{ \Carbon\Carbon::parse($book->published_at)->format('d-m-Y')}}</td>
                                    <td>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#EditBookModal"
                                                value="{{$book->id}}" class="edit_btn btn btn-success btn-sm">Edit
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input class="delete_btn btn btn-danger btn-sm" type="submit" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $books->links('components.paginate') }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @extends('book.add-modal')
    @extends('book.edit-modal')
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('submit', '#AddBookForm', function (e) {
                e.preventDefault();

                let formData = new FormData($('#AddBookForm')[0])

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{route('books.store')}}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == 400) {
                            $('#save_errorList').html("");
                            $('#save_errorList').removeClass('d-none');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_errorList').append('<li>' + err_value + '</li>')
                            })
                        } else if (response.status == 200) {
                            $('#save_errorList').html("");
                            $('#save_errorList').addClass('d-none');

                            $('#AddBookForm').find('input').val('')
                            $('#AddBookModal').modal('hide')

                            alert(response.message)
                        }
                    }
                })
            })
        })

        $(document).on('click', '.edit_btn', function (e) {
            e.preventDefault();

            let book_id = $(this).val()

            $('#EditBookModal').modal('show')

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/books/' + book_id + '/edit',
                success: function (response) {
                    $('#edit_name').val(response.book.name)
                    $('#edit_description').val(response.book.description)
                    $('#edit_published_at').val(response.book.is_published)
                    $('#book_id').val(book_id)

                }
            })

        })

        $(document).on('submit', '#UpdateBookForm', function (e) {
            e.preventDefault();

            let id = $('#book_id').val()

            let EditFormData = new FormData($('#UpdateBookForm')[0])

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/books/" + id,
                data: EditFormData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 400) {
                        $('#update_errorList').html("");
                        $('#update_errorList').removeClass('d-none');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_errorList').append('<li>' + err_value + '</li>')
                        })
                    } else if (response.status == 200) {
                        $('#update_errorList').html("");
                        $('#update_errorList').addClass('d-none');

                        $('#EditBookModal').modal('hide');
                        alert(response.message);
                    }
                }
            })
        })
    </script>
@endsection
