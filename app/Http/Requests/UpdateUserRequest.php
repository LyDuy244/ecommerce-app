<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users,email,'.$this->id,
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => "Ban chua nhap email",
            'email.email' => "Ban phai nhap dung dinh dang email",
            'email.unique' => "Email đã tồn tại. Hãy chọn email khác",
            'email.string' => "Email phải là dạng ký tự",
            'email.max' => "Độ dài tối đa của email là 191",
            'name.required' => "Bạn chưa nhập họ tên.",
            'name.string' => "Họ tên phải là dạng ký tự",
            'user_catalogue_id.gt' => 'Bạn chưa chọn nhóm thành viên',
        ];
    }
}
