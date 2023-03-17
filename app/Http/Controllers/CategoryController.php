<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $this->authorize('view categories', Category::class);
        return response()->json([
            'status' => 'success',
            'message' => 'all categories',
            'data' => Category::all()
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create categories', Category::class);
        $calidated_category = $request->validated();
        $category = Category::create($calidated_category);
        return response()->json([
            'status' => 'success',
            'message' => 'category created',
            'data' => $category
        ], 201);
    }

    public function show($category_id)
    {
        $this->authorize('view categories', Category::class);
        $category = Category::find($category_id);
        if ($category) {
            return response()->json([
                'status' => 'success',
                'message' => 'category found',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'category not found',
                'data' => null
            ], 404);
        }
    }




    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update categories', Category::class);
        $request->validated();
        $category->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'category updated',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category)
    {
        $this->authorize('delete categories', Category::class);
        $category = Category::find($category);
        if (!$category) return response()->json(['message' => 'Category not found'], 404);
        $category->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }

    public function getPlantesByCategory($category_id){
        $this->authorize('view categories', Category::class);
        $category = Category::find($category_id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'category not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'all plants by category',
            'data' => $category->plantes
        ], 200);
    }

}
