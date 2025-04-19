<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool returns true if the user is authorized to make this request, false otherwise.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array An array of validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name',
            'permissions' => 'required',
        ];
    }
}
