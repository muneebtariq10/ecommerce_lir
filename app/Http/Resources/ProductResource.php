<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "sort" => $this->sort,
            "model" => $this->model,
            "price" => $this->price,
            "image" => $this->image && !(str_starts_with($this->image, 'http')) ?
            Storage::url($this->image) : $this->image,
            "banner" => $this->banner && !(str_starts_with($this->banner, 'http')) ?
            Storage::url($this->banner) : $this->banner,
            "points" => $this->points,
            "status" => $this->status,
            "trending" => $this->trending,
            "subtract" => $this->subtract,
            "quantity" => $this->quantity,
            "brand" => $this->brand,
            "brand_id" => $this->brand_id,
            "short_url" => $this->short_url,
            "min_quantity" => $this->min_quantity,
            "category" => $this->categories,
            "category_id" => $this->categories[0]->id,
            "description" => $this->description,
            "created_at" => (new Carbon($this->created_at))->format("Y-m-d"),
        ];
    }
}
