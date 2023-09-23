<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        //select * from category
        //preparing category query
        $query = Category::query();

        if ($name = $request->query('name')){
            $query->where('name' , 'LIKE' , "%{$name}%");
        }

        if ($status = $request->query('status')){
            $query->where('status' , $status);
        }

        $categories = $query->paginate(10);

        return $this->successResponse('categories' , $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {

        $request->merge(['slug' => Str::slug($request->name) , 'status' => Category::STATUS_ACTIVE] );

        $this->uploadFile($request , 'Categories-images' , 'image');

        Category::create($request->all());

        return $this->showMessage('category has been created' , 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        $id = $category->id;

        //select * from `categories` where `id` <> ?
        // and (`parent_id` is null or `parent_id` <> ?)
        $parents = Category::where('id' , '!=', $id)
             ->where(function ($query) use ($id){
                $query->whereNull('parent_id')
                    ->orwhere('parent_id' , '!=' ,$id);
            })->get();

        return $this->successResponse('category' , CategoryResource::make($category , $parents));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $this->deleteFile($category , 'image');
        $this->uploadFile($request , 'Categories-images' , 'image');

        $category->update($request->all());

        $category->save();

        return $this->showMessage('category has been updated' , 203);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->deleteFile($category , 'image');
        $category->delete();

        return $this->showMessage('category has been deleted' , 200);
    }
}
