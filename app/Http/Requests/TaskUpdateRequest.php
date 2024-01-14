<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|max:255',
            'is_done' => 'sometimes|boolean',
            'content' => 'nullable',
            'owner_id' => 'sometimes|required',
            'project_id' => [
                'sometimes', 'required',
                // 'exists:projects,id'
                // The task updated by the project owner
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('owner_id', Auth::id());
                })
            ],
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
            'is_done.boolean' => 'Boolean value required',
            'owner_id.required' => 'The owner id is required field',
            'project_id.required' => 'The project id is required field',
        ];
    }
}