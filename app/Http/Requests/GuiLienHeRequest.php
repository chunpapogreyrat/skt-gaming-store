<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuiLienHeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_ten' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'so_dien_thoai' => ['nullable', 'string', 'max:30'],
            'chu_de' => ['required', 'in:ho-tro-ky-thuat,bao-hanh,don-hang,hop-tac,khac'],
            'noi_dung' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'ho_ten.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'chu_de.in' => 'Chủ đề không hợp lệ.',
            'noi_dung.required' => 'Vui lòng nhập nội dung cần hỗ trợ.',
        ];
    }
}
