<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
        $brand = $this->route('brand');
        return [
            'name' => ['required', 'string', 'max:255'],
            'sort' => ['nullable', 'numeric'],
            'image' => ['nullable', "image"],
            "status" => ["required", Rule::in(["disabled", "enabled"])],
            'short_url' => ['required', 'string', Rule::unique('brands')->ignore($brand->id)]
        ];
    }
}