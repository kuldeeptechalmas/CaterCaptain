<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RawMaterialRequest extends FormRequest
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
            "name" => "required|string",
            "unit_id" => "required",
            "qty" => "required",
            "minqty" => "required",

        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Enter Raw Material Name is Required",
            "name.string" => "Enter String is Required",
            "unit_id.required" => "Enter Unit is Required",
            "qty.required" => "Enter Qty is Required",
            "minqty.required" => "Enter Min Qty is Required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
