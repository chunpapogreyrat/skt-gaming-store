<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'so_sao' => ['required', 'integer', 'min:1', 'max:5'],
            'noi_dung' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'so_sao.required' => 'Vui lòng chọn số sao.',
            'so_sao.integer' => 'Số sao không hợp lệ.',
            'so_sao.min' => 'Số sao tối thiểu là 1.',
            'so_sao.max' => 'Số sao tối đa là 5.',
            'noi_dung.max' => 'Nội dung đánh giá tối đa 1000 ký tự.',
        ];
    }
}
