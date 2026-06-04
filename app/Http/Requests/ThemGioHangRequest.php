<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemGioHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'san_pham_id' => 'required|integer|exists:san_phams,id',
            'so_luong' => 'sometimes|integer|min:1|max:99',
            'mau_sac' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'san_pham_id.required' => 'Vui lòng chọn sản phẩm',
            'san_pham_id.exists' => 'Sản phẩm không tồn tại',
            'so_luong.min' => 'Số lượng tối thiểu là 1',
            'so_luong.max' => 'Số lượng tối đa là 99',
        ];
    }
}
