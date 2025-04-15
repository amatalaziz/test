<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\RequestPriority;
use App\Enums\RequestStatus;

class UpdateRequestRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->request);
    }

    public function rules()
    {
        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-0-9]+$/u', // 
            ],
            'description' => [
                'sometimes',
                'required',
                'string',
                'max:1000',
                'regex:/^[\pL\s\-0-9.,!?()\'"\r\n]+$/u', // السماح ببعض علامات الترقيم
            ],
            'priority' => [
                'sometimes',
                'required',
                'in:' . implode(',', RequestPriority::values()),
            ],
            'status' => [
                'sometimes',
                'required',
                'in:' . implode(',', RequestStatus::values()),
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required when present.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.regex' => 'The title may only contain letters, numbers, spaces, and hyphens.',
    
            'description.required' => 'The description field is required when present.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 1000 characters.',
            'description.regex' => 'The description may not contain invalid symbols or code.',
    
            'priority.required' => 'The priority field is required when present.',
            'priority.in' => 'The selected priority is invalid.',
    
            'status.required' => 'The status field is required when present.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
    
}
