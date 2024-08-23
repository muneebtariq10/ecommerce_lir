<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

use App\Http\Resources\BrandResource;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Brand::query();

        $field = request("field", "created_at");
        $direction = request("direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%".request("name")."%");
        }
        if (request("status")) {
            $query->where("status", "like", "%".request("status")."%");
        }

        $brands = $query->orderBy($field, $direction)
            ->paginate(10)->onEachSide(1)
        ;

        return inertia("Admin/Brand/Index", [
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
        return inertia("Admin/Brand/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
    
        $data['sort'] = $data['sort'] ?? 1;

        if ($image) {
            $data['image'] = $image->store('brand/' . Str::random(), 'public');
        }

        Brand::create($data);

        return to_route("brand.index")->with('success', 'Brand was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return inertia("Admin/Brand/Edit", [
            "brand" => new BrandResource($brand)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;

        $data['sort'] = $data['sort'] ?? 1;

        if ($image) {
            if ($brand->image) {
                Storage::disk('public')->deleteDirectory(dirname($brand->image));
            }
            $data['image'] = $image->store('brand/' . Str::random(), 'public');
        } else {
            unset($data['image']);
        }

        $brand->update($data);

        return to_route("brand.index")->with("success", "Brand \"$brand->name\" was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $name = $brand->name;
        if ($brand->image) {
            Storage::disk('public')->deleteDirectory(dirname($brand->image));
        }

        $relation = $brand->products;

        foreach ($relation as $key => $value) {
            $value->delete();
        }

        $brand->delete();

        return to_route("brand.index")->with("success", "Brand \"$name\" was deleted.");
    }
}
