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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string', 
            'description' => 'required|string|max:255',
            'base_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:men,female,kids,accessories,unisex',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size_id' => 'required|array',
            'size_id.*' => 'exists:sizes,id',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
            'stock' => 'required|array',
            'stock.*' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'name.required' => 'The product name field is required.',
            'type.required' => 'The product type field is required.',
            'type.in' => 'The selected product type is invalid.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'stock.required' => 'The stock field is required.',
            'stock.numeric' => 'The stock must be a number.',
            'base_image.required' => 'The base image field is required.',
            'base_image.image' => 'The base image must be an image file.',
            'base_image.mimes' => 'The base image must be a file of type: jpeg, png, jpg, gif, svg.',
            'base_image.max' => 'The base image may not be greater than 2048 kilobytes.',
            'images.required' => 'The images field is required.',
            'images.array' => 'The images must be an array of image files.',
            'images.*.image' => 'Each image must be an image file.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each image may not be greater than 2048 kilobytes.',
            'size_id.array' => 'The size field must be an array of sizes.',
            'size_id.*.exists' => 'One or more selected sizes are invalid.',
            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 255 characters.',
        ];
    }

    
}
