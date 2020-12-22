<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }
}
