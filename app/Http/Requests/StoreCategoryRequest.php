<?php

namespace App\Http\Requests;

use App\Models\Category;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'image' => ['nullable', "image"],
            'banner' => ['nullable', "image"],
            "status" => ["required", Rule::in(["disabled", "enabled"])],
            'parent_id' => ['nullable'],
            'short_url' => ['required', 'string', 'unique:categories,short_url'],
            "description" => ["nullable", "string"]
        ];
    }
}
