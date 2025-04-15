<?php

namespace App\Http\Requests;

use App\Enums\RequestPriority;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\d\-،.؟?!]+$/u', // يمنع الرموز الغريبة والأكواد
            ],
            'description' => [
                'required',
                'string',
                'regex:/^[\pL\s\d\-،.؟?!\r\n]+$/u', // يسمح بالسطر الجديد + يمنع الأكواد
            ],
            'priority' => [
                'required',
                'in:' . implode(',', RequestPriority::values()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'title.regex' => 'The title must not contain special characters or code.',
    
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.regex' => 'The description must not contain special characters or code.',
    
            'priority.required' => 'The priority field is required.',
            'priority.in' => 'The selected priority is invalid.',
        ];
    }
    
}
