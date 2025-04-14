<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->request);
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'priority' => 'sometimes|in:' . implode(',', RequestPriority::values()),
            'status' => 'sometimes|in:' . implode(',', RequestStatus::values()),
        ];
    }
}