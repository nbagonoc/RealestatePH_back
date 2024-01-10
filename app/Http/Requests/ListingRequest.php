<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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
            'status_id' => 'nullable|exists:statuses,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|size:2',
            'zip' => 'required|string|size:5',
            'photo' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'nullable|exists:types,id',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'sqft' => 'required|numeric',
            'lot_size' => 'required|numeric',
            'year_built' => 'required|integer',
            'parking' => 'required|integer',
        ];
    }
}
