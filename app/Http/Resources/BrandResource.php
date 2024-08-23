<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            "image" => $this->image && !(str_starts_with($this->image, 'http')) ?
            Storage::url($this->image) : $this->image,
            "status" => $this->status,
            "short_url" => $this->short_url,
            "created_at" => (new Carbon($this->created_at))->format("Y-m-d"),
        ];
    }
}
