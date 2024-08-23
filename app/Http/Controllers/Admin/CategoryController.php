<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Http\Resources\CategoryResource;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Category::query();

        $field = request("field", "created_at");
        $direction = request("direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%".request("name")."%");
        }
        if (request("status")) {
            $query->where("status", "like", "%".request("status")."%");
        }
        if (request("parent_id")) {
            $query->where("parent_id", request("parent_id"));
        }

        $categories = $query->orderBy($field, $direction)
            ->paginate(10)->onEachSide(1)
        ;

        $parents = Category::query()->where("parent_id", "0")->orderBy("name", "asc")->get();

        return inertia("Admin/Category/Index", [
            "categories" => CategoryResource::collection($categories),
            "parents" => CategoryResource::collection($parents),
            "queryParams" => request()->query() ?: null,
            "success" => session("success")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::query()->where("parent_id", "0")->orderBy("name", "asc")->get();

        return inertia("Admin/Category/Create", [
            "parents" => CategoryResource::collection($parents)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $banner = $data['banner'] ?? null;
        $data['sort'] = $data['sort'] ?? 1;
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if ($image) {
            $data['image'] = $image->store('category/image/' . Str::random(), 'public');
        }
        if ($banner) {
            $data['banner'] = $image->store('category/banner/' . Str::random(), 'public');
        }

        Category::create($data);

        return to_route("category.index")->with('success', 'Category was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = Category::query()->where("parent_id", "0")->orderBy("name", "asc")->get();

        return inertia("Admin/Category/Edit", [
            "category" => new CategoryResource($category),
            "parents" => CategoryResource::collection($parents)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $banner = $data['banner'] ?? null;

        $data['sort'] = $data['sort'] ?? 1;
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if ($image) {
            if ($category->image) {
                Storage::disk('public')->deleteDirectory(dirname($category->image));
            }
            $data['image'] = $image->store('category/image/' . Str::random(), 'public');
        } else {
            unset($data['image']);
        }
        if ($banner) {
            if ($category->banner) {
                Storage::disk('public')->deleteDirectory(dirname($category->banner));
            }
            $data['banner'] = $banner->store('category/banner/' . Str::random(), 'public');
        } else {
            unset($data['banner']);
        }

        $category->update($data);

        return to_route("category.index")->with("success", "Category \"$category->name\" was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $name = $category->name;
        if ($category->image) {
            Storage::disk('public')->deleteDirectory(dirname($category->image));
        }
        if ($category->banner) {
            Storage::disk('public')->deleteDirectory(dirname($category->banner));
        }

        $relation = $category->products;

        foreach ($relation as $key => $value) {
            $value->product->delete();
            $value->category->delete();
            $value->delete();
        }

        $category->delete();

        return to_route("category.index")->with("success", "Category \"$name\" was deleted.");
    }
}
