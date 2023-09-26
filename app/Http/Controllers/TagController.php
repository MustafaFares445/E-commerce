<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tags = Tag::all();

        return $this->successResponse('tags' , $tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $tags = explode(',' , $request->input('tags'));

        foreach ($tags as $tag_name){

                $tag  = Tag::create([
                    'name' => $tag_name,
                    'slug' => Str::slug($tag_name),
                ]);
        }

        return $this->showMessage('All Tags has been created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): JsonResponse
    {
        return $this->successResponse('tag' , $tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag): JsonResponse
    {
        $tag->update($request->all());

        return $this->showMessage('Tag has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();
        return $this->showMessage('Tag has been deleted successfully');

    }
}
