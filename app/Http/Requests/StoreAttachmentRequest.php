<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'attachments' => 'sometimes|array|max:5',
            'attachments.*' => [
                'file',
                File::types(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif'])
                    ->max(5 * 1024) // 5MB
            ]
        ];
    }

    public function messages()
    {
        return [
            'attachments.max' => 'You can upload maximum 5 files',
            'attachments.*.max' => 'File size must be less than 5MB',
            'attachments.*.mimes' => 'Allowed file types: pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif'
        ];
    }
}