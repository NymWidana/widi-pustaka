<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::with('books')->get();
            return response()->json([
                'code' => 200,
                'data' => $categories,
                'success' => True,
                'message' => 'Successfully retrieved all categories data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Internal Server Error! Failed to retrieve categories data!'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try{
            $validatedData = $request->validated();
            $category = Category::create([
                "name" => $validatedData['name'],
            ]); 

            if($category){
                return response()->json([
                    'code' => 201,
                    'data' => $category,
                    'success' => True,
                    'message' => 'Successfully saved a category data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to save the category data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to save category data. Internal Server error! ' . $e->getMessage(),
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
            $category = Category::with('books')->find($id);
            if(!$category){
                return response()->json([
                'code' => 404,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the category data. The category data is not found!'
            ], 404);
            }
            return response()->json([
                'code' => 200,
                'data' => $category,
                'success' => True,
                'message' => 'Successfully retrieved the category data!'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'data' => NULL,
                'success' => False,
                'message' => 'Failed to retrieve the category data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try{
            $category = Category::find($id);
            if(!$category){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the category data. The category data is not found!'
                ], 404);
            }
            $validatedData = $request->validated();
            $updated = $category->update([
                "name" => $validatedData['name'],
            ]); 

            if($updated){
                return response()->json([
                    'code' => 201,
                    'data' => Category::find($id),
                    'success' => True,
                    'message' => 'Successfully updated a category data!'
                ], 201);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => False,
                    'message' => 'Failed to update the category data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to update the category data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::find($id);
            if(!$category){
                return response()->json([
                    'code' => 404,
                    'success' => False,
                    'message' => 'Failed to retrieve the category data. The category data is not found!'
                ], 404);
            }
            $deleted = $category->delete();
            if($deleted){
                return response()->json([
                    'code' => 200,
                    'data' => $category,
                    'success' => True,
                    'message' => 'Successfully deleted a category data!'
                ], 200);
            }
            else{
                return response()->json([
                    'code' => 500,
                    'success' => false,
                    'message' => 'Failed to delete the category data!'
                ], 500);
            }
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'success' => False,
                'message' => 'Failed to delete the category data. Internal Server Error!'. $e->getMessage()
            ], 500);
        }
    }
}
