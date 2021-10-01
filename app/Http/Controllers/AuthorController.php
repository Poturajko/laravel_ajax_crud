<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authorQuery = Author::query();
        if ($request->filled('search_name')){
            $authorQuery->where('last_name','like',"%$request->search_name%");
        }
        if ($request->filled('order_by')){
            switch ($request->order_by){
                case 'name-a-z':
                    $authorQuery->orderBy('last_name');
                    break;
                case 'name-z-a':
                    $authorQuery->orderBy('last_name','desc');
                    break;
            }
        }

        $authors = $authorQuery->paginate(15)->withPath('?' . $request->getQueryString());

        return response(view('author.index', compact('authors')));
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
            ['first_name' => 'required', 'last_name' => 'required|min:3'],
            [
                'required' => 'Поле :attribute обязательно для ввода',
                'min' => 'Поле :attribute должно иметь минимум :min символов'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }

        Author::create($request->all());

        return response()->json(['status' => 200, 'message' => 'Author Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Author $author)
    {
        return response()->json(['status' => 200, 'author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(),
            ['first_name' => 'required', 'last_name' => 'required|min:3'],
            [
                'required' => 'Поле :attribute обязательно для ввода',
                'min' => 'Поле :attribute должно иметь минимум :min символов'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }

        $author->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Author Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response(redirect()->route('authors.index'));
    }
}
