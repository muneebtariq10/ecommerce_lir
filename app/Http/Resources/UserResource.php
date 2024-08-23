<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\RoleResource;

class UserResource extends JsonResource
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
            "role" => new RoleResource($this->role),
            "email" => $this->email,
            "role_id" => $this->role_id,
            "created_at" => (new Carbon($this->created_at))->format("Y-m-d"),
        ];
    }
}
