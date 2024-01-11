<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'nullable',
            'owner_id' => 'required',
            'project_id' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors' => $validator->errors(),
        ]));
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is a required field.',
            'title.max' => 'The title shouldn\'t exceed 255 characters',
            'owner_id.required' => 'The owner id is required field',
            'project_id.required' => 'The project id is required field',
        ];
    }
}
