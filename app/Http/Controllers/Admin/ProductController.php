<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;

use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::query();

        $field = request("field", "created_at");
        $direction = request("direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%".request("name")."%");
        }
        if (request("model")) {
            $query->where("model", "like", "%".request("model")."%");
        }
        if (request("status")) {
            $query->where("status", "like", "%".request("status")."%");
        }
        if (request("brand_id")) {
            $query->where("brand_id", request("brand_id"));
        }

        $products = $query->orderBy($field, $direction)
            ->paginate(10)->onEachSide(1)
        ;

        $brands = Brand::query()->where("status", "enabled")->orderBy("sort", "asc")->get();

        return inertia("Admin/Product/Index", [
            "products" => ProductResource::collection($products),
            "brands" => BrandResource::collection($brands),
            "queryParams" => request()->query() ?: null,
            "success" => session("success")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::query()->where("status", "enabled")->orderBy("sort", "asc")->get();
        $categories = Category::query()->where("status", "enabled")->orderBy("name", "asc")->get();

        return inertia("Admin/Product/Create", [
            "categories" => CategoryResource::collection($categories),
            "brands" => BrandResource::collection($brands)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $image = $data['image'] ?? null;
        $banner = $data['banner'] ?? null;
        $data['sort'] = $data['sort'] ?? 1;

        if ($image) {
            $data['image'] = $image->store('product/image/' . Str::random(), 'public');
        }
        if ($banner) {
            $data['banner'] = $banner->store('product/banner/' . Str::random(), 'public');
        }

        $product = Product::create($data);
        $product->categories()->attach($data['category_id']);

        return to_route("product.index")->with('success', 'Product was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::query()->where("status", "enabled")->orderBy("sort", "asc")->get();
        $categories = Category::query()->where("status", "enabled")->orderBy("name", "asc")->get();

        return inertia("Admin/Product/Edit", [
            "product" => new ProductResource($product),
            "categories" => CategoryResource::collection($categories),
            "brands" => BrandResource::collection($brands)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $banner = $data['banner'] ?? null;

        $data['sort'] = $data['sort'] ?? 1;

        if ($image) {
            if ($product->image) {
                Storage::disk('public')->deleteDirectory(dirname($product->image));
            }
            $data['image'] = $image->store('product/image/' . Str::random(), 'public');
        } else {
            unset($data['image']);
        }
        if ($banner) {
            if ($product->banner) {
                Storage::disk('public')->deleteDirectory(dirname($product->banner));
            }
            $data['banner'] = $banner->store('product/banner/' . Str::random(), 'public');
        } else {
            unset($data['banner']);
        }

        $product->update($data);
        $product->categories()->detach();
        $product->categories()->attach($data['category_id']);

        return to_route("product.index")->with("success", "Product \"$product->name\" was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        if ($product->image) {
            Storage::disk('public')->deleteDirectory(dirname($product->image));
        }
        if ($product->banner) {
            Storage::disk('public')->deleteDirectory(dirname($product->banner));
        }

        $product->categories()->detach();

        $product->delete();

        return to_route("product.index")->with("success", "Product \"$name\" was deleted.");
    }
}
