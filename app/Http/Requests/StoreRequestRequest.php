<?php

namespace App\Http\Requests;
use App\Enums\RequestPriority;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
'priority' => 'required|in:' . implode(',', RequestPriority::values()),
        ];
    }
}