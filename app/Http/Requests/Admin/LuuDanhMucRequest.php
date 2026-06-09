<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LuuDanhMucRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã qua middleware 'admin'
    }

    protected function prepareForValidation(): void
    {
        // Tự sinh slug từ tên nếu để trống
        $this->merge([
            'slug' => Str::slug($this->slug ?: $this->ten),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'ten' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:120', Rule::unique('danh_mucs', 'slug')->ignore($id)],
            'icon' => ['nullable', 'string', 'max:60'],
            'mo_ta' => ['nullable', 'string', 'max:255'],
            'hinh_anh' => ['nullable', 'string', 'max:255'],
            'thu_tu' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'Vui lòng nhập tên danh mục.',
            'slug.unique' => 'Slug này đã tồn tại, đổi tên hoặc slug khác.',
        ];
    }
}
