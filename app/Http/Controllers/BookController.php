<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bookQuery = Book::query()
            ->join('author_book', 'books.id', '=', 'author_book.book_id')
            ->join('authors', 'author_id', '=', 'authors.id');

        if ($request->filled('search_name')) {
            $bookQuery->where('name', 'like', "%$request->search_name%")
                ->orWhere('last_name', 'like', "%$request->search_name%");
        }
        if ($request->filled('order_by')) {
            switch ($request->order_by) {
                case 'name-a-z':
                    $bookQuery->orderBy('name');
                    break;
                case 'name-z-a':
                    $bookQuery->orderBy('name', 'desc');
                    break;
            }
        }
        $books = $bookQuery->with('authors')->paginate(15)->withPath('?' . $request->getQueryString());
        $authors = Author::all();

        return response()->view('book.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required', 'image' => 'mimes:jpg,png|max:2048', 'author' => 'required|array'],
            [
                'required' => 'Поле :attribute обязательно для ввода',
                'mimes' => 'Поле :attribute поддерживает файлы типа :jpg,png',
                'max' => 'Поле :attribute должно быть не больше :max килобайт',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }

        $book = new Book();
        $book->name = $request->input('name');
        $book->description = $request->input('description');

        if ($request->input('is_published') == 1) {
            $book->is_published = 1;
            $book->published_at = Carbon::now();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books');
            $book->image = $path;
        }
        $book->save();

        $book->authors()->attach($request->input('author'));

        return response()->json(['status' => 200, 'message' => 'Book Successfully Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Book $book)
    {
        return response()->json(['status' => 200, 'book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required', 'author' => 'required|array'],
            ['required' => 'Поле :attribute обязательно для ввода']
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }

        $book->name = $request->input('name');
        $book->description = $request->input('description');

        if ($request->input('is_published') == 1) {
            $book->is_published = 1;
            $book->published_at = Carbon::now();
        }

        if ($request->hasFile('image')) {
            Storage::delete($book->image);
            $path = $request->file('image')->store('books');
            $book->image = $path;
        }
        $book->update();
        $book->authors()->detach();
        if ($request->input('author')) {
            $book->authors()->attach($request->input('author'));
        }

        return response()->json(['status' => 200, 'message' => 'Book Successfully Added']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Storage::delete($book->image);
        $book->delete();

        return response(redirect()->route('books.index'));
    }
}
