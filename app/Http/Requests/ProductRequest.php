<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'type' => ['required', 'string', 'in:men,female,kids,unisex,accessories'],
            'image_url' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Category is required',
            'name.required' => 'Name is required',
            'name.max' => 'Name must be less than 255 characters',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'stock.required' => 'Stock is required',
            'stock.numeric' => 'Stock must be a number',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be one of: men, female, kids, unisex, accessories',
            'image_url.required' => 'Image is required',
            'image_url.image' => 'Image must be an image',
            'image_url.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF',
            'image_url.max' => 'Image must be less than 2MB',
        ];
    }
}
