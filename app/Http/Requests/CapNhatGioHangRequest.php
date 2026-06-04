<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatGioHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'so_luong' => 'required|integer|min:0|max:99',
        ];
    }

    public function messages(): array
    {
        return [
            'so_luong.required' => 'Vui lòng nhập số lượng',
            'so_luong.min' => 'Số lượng không được âm',
            'so_luong.max' => 'Số lượng tối đa là 99',
        ];
    }
}
