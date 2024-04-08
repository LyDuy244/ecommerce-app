<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
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
            'name' => 'required',
            'canonical' => 'required|unique:languages,canonical,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Ban chua nhap tên",
            'canonical.required' => "Ban chua nhap từ khóa của ngôn ngữ",
            'canonical.unique' => "Từ khóa đã tồn tại hãy chọn từ khóa khác",
        ];
    }
}
