<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sort' => ['nullable', 'numeric'],
            'model' => ['required', 'string', 'min:3', 'max:10'],
            'price' => ['required', 'decimal:2'],
            'image' => ['nullable', "image"],
            'banner' => ['nullable', "image"],
            'points' => ['nullable', 'numeric'],
            "status" => ["required", Rule::in(["disabled", "enabled"])],
            "trending" => ['required'],
            'brand_id' => ['nullable'],
            'subtract' => ['required'],
            'quantity' => ['nullable', 'numeric'],
            'short_url' => ['required', 'string', 'unique:products,short_url'],
            'category_id' => ['required'],
            "description" => ["nullable", "string"],
            "min_quantity" => ["nullable", "numeric"]
        ];
    }
}
