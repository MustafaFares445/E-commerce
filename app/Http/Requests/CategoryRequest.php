<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CategoryRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') ){
            $response = $this->returnValidationError($validator);
            throw new ValidationException($validator , $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('category');

        return [
            'name' => "required|string|min:3|max:225|unique:categories,name,'$id'",
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => 'image|max:5500880|dimensions:min_width:100,min_height:100',
            'status' => 'in:active,archived'
        ];
    }



}
