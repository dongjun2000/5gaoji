<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|between:2,25|regex:/^[A-Za-z0-9\_]+$/|unique:users,name,' . Auth::id(),
            'email'  => 'required|email',
            'intro'  => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,jpg|dimensions:min_width=250,min_height=250'
        ];
    }

    public function messages()
    {
        return [
            'name.regex'        => '姓名只能包含大小写字母、数字和下划线，不能包含中文',
            'avatar.mimes'      => '头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 250px 以上',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '昵称'
        ];
    }
}
