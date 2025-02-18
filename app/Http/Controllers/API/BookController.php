<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $books = Book::with(['authors', 'categories'])->get();
            return response()->json([
                'code' => 200,
                'data' => $books,
                'success' => True,
                'message' => 'Successfully retrieved all books data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Internal Server Error! Failed to retrieve books data!'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
        try{
            $validatedData = $request->validated();
            $book = Book::create([
                "title" => $validatedData['title'],
                "description" => $validatedData['description']
            ]); 

            foreach ($validatedData['categories'] as $categoryIds) {
                $categoryExists = Category::where('id', $categoryIds)->exists();
                if(!$categoryExists){
                    return response()->json([
                        'code' => 404,
                        'success' => False,
                        'message' => 'Failed to save book data!, the specified book category is not found'
                    ], 404);
                }
            }
            $authorIds = [];
            foreach ($validatedData['authors'] as $authorName) {
                $author = Author::firstOrCreate(['name' => $authorName]);
                $authorIds[] = $author->id;
            }
            $book->authors()->sync($authorIds);
            $book->categories()->sync($validatedData['categories']);

            if($book){
                return response()->json([
                    'code' => 201,
                    'data' => Book::with(['authors', 'categories'])->find($book->id),
                    'success' => True,
                    'message' => 'Successfully saved a book data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to save the book data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to save book data. Internal Server error! ' . $e->getMessage(),
                'e' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $book = Book::with(['authors', 'categories'])->find($id);
            if(!$book){
                return response()->json([
                'code' => 404,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the book data. The book data is not found!'
            ], 404);
            }
            return response()->json([
                'code' => 200,
                'data' => $book,
                'success' => True,
                'message' => 'Successfully retrieved the book data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the book data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        //
        try{
            $book = Book::find($id);
            if(!$book){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the book data. The book data is not found!'
                ], 404);
            }
            $validatedData = $request->validated();
            $updated = $book->update([
                "title" => $validatedData['title'],
                "description" => $validatedData['description']
            ]); 

            foreach ($validatedData['categories'] as $categoryIds) {
                $categoryExists = Category::where('id', $categoryIds)->exists();
                if(!$categoryExists){
                    return response()->json([
                        'code' => 404,
                        'success' => False,
                        'message' => 'Failed to update book data!, the specified book category is not found'
                    ], 404);
                }
            }
            $authorIds = [];
            foreach ($validatedData['authors'] as $authorName) {
                $author = Author::firstOrCreate(['name' => $authorName]);
                $authorIds[] = $author->id;
            }
            $book->authors()->sync($authorIds);
            $book->categories()->sync($validatedData['categories']);

            if($updated){
                return response()->json([
                    'code' => 201,
                    'data' => Book::with(['authors', 'categories'])->find($id),
                    'success' => True,
                    'message' => 'Successfully updated a book data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to update the book data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to update the book data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $book = Book::with(['authors', 'categories'])->find($id);
            if(!$book){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the book data. The book data is not found!'
                ], 404);
            }
            $deleted = $book->delete();
            if($deleted){
                return response()->json([
                    'code' => 200,
                    'data' => $book,
                    'success' => True,
                    'message' => 'Successfully deleted a book data!'
                ], 200);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => false,
                    'message' => 'Failed to delete the book data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to delete the book data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }
}
