<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $authors = Author::all();
            return response()->json([
                'code' => 200,
                'data' => $authors,
                'success' => True,
                'message' => 'Successfully retrieved all authors data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Internal Server Error! Failed to retrieve authors data!'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        try{
            $validatedData = $request->validated();
            $author = Author::create([
                "name" => $validatedData['name'],
            ]); 

            if($author){
                return response()->json([
                    'code' => 201,
                    'data' => $author,
                    'success' => True,
                    'message' => 'Successfully saved a author data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to save the author data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to save author data. Internal Server error! ' . $e->getMessage(),
                'e' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $author = Author::find($id);
            if(!$author){
                return response()->json([
                'code' => 404,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the author data. The author data is not found!'
            ], 404);
            }
            return response()->json([
                'code' => 200,
                'data' => $author,
                'success' => True,
                'message' => 'Successfully retrieved the author data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the author data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, string $id)
    {
        try{
            $author = Author::find($id);
            if(!$author){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the author data. The author data is not found!'
                ], 404);
            }
            $validatedData = $request->validated();
            $updated = $author->update([
                "name" => $validatedData['name'],
            ]); 

            if($updated){
                return response()->json([
                    'code' => 201,
                    'data' => Author::find($id),
                    'success' => True,
                    'message' => 'Successfully updated a author data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to update the author data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to update the author data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $author = Author::find($id);
            if(!$author){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the author data. The author data is not found!'
                ], 404);
            }
            $deleted = $author->delete();
            if($deleted){
                return response()->json([
                    'code' => 200,
                    'data' => $author,
                    'success' => True,
                    'message' => 'Successfully deleted a author data!'
                ], 200);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => false,
                    'message' => 'Failed to delete the author data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to delete the author data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }
}
