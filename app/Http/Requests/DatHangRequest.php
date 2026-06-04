<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_nguoi_nhan' => 'required|string|max:100',
            'sdt_nguoi_nhan' => ['required', 'regex:/^(0|\+84)[0-9]{9,10}$/'],
            'email' => 'nullable|email|max:150',
            'dia_chi_giao_hang' => 'required|string|max:255',
            'tinh_thanh' => 'required|string|max:100',
            'quan_huyen' => 'required|string|max:100',
            'phuong_xa' => 'nullable|string|max:100',
            'phuong_thuc_thanh_toan' => 'required|in:cod,momo,vnpay',
            'phi_ship' => 'nullable|numeric|min:0',
            'ghi_chu' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_nguoi_nhan.required' => 'Vui lòng nhập họ tên',
            'sdt_nguoi_nhan.required' => 'Vui lòng nhập số điện thoại',
            'sdt_nguoi_nhan.regex' => 'Số điện thoại không hợp lệ',
            'dia_chi_giao_hang.required' => 'Vui lòng nhập địa chỉ',
            'tinh_thanh.required' => 'Vui lòng chọn tỉnh/thành',
            'quan_huyen.required' => 'Vui lòng chọn quận/huyện',
            'phuong_thuc_thanh_toan.in' => 'Phương thức thanh toán không hợp lệ',
        ];
    }
}
