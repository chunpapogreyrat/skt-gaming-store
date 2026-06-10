<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuuNhaPhanPhoiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã qua middleware 'admin'
    }

    public function rules(): array
    {
        return [
            'ten' => ['required', 'string', 'max:150'],
            'mo_ta' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'],
            'sdt' => ['nullable', 'string', 'max:30'],
            'quoc_gia' => ['nullable', 'string', 'max:80'],
            'so_sku' => ['nullable', 'integer', 'min:0'],
            'hop_dong_den' => ['nullable', 'date'],
            'trang_thai' => ['required', 'in:active,paused,ended'],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'Vui lòng nhập tên nhà phân phối.',
            'email.email' => 'Email không hợp lệ.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'so_sku' => $this->so_sku === null || $this->so_sku === '' ? 0 : $this->so_sku,
        ]);
    }
}
