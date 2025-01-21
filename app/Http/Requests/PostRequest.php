<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{



    public function rules(): array
    {
        return [

                'post_info' => ['required'],
                'post_image' => ['file', 'nullable'],
        ];
    }
}
