<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LuuMaGiamGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'ma_code' => ['required', 'string', 'max:50', Rule::unique('ma_giam_gias', 'ma_code')->ignore($id)],
            'loai' => 'required|in:phan_tram,so_tien',
            'gia_tri' => 'required|numeric|min:0',
            'gia_tri_don_toi_thieu' => 'nullable|numeric|min:0',
            'so_lan_su_dung_toi_da' => 'nullable|integer|min:1',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_het_han' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'trang_thai' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ma_code.required' => 'Vui lòng nhập mã code',
            'ma_code.unique' => 'Mã code đã tồn tại',
            'loai.in' => 'Loại giảm giá không hợp lệ',
            'gia_tri.required' => 'Vui lòng nhập giá trị giảm',
            'ngay_het_han.after_or_equal' => 'Ngày hết hạn phải sau ngày bắt đầu',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ma_code' => strtoupper((string) $this->ma_code),
            'trang_thai' => $this->boolean('trang_thai'),
        ]);
    }
}
