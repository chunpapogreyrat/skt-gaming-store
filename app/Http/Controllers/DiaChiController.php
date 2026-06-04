<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DiaChiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validatedAddress($request);
        $user = $request->user();

        DB::transaction(function () use ($user, $validated, $request): void {
            $makeDefault = $request->boolean('is_mac_dinh') || ! $user->diaChi()->exists();

            if ($makeDefault) {
                $user->diaChi()->update(['is_mac_dinh' => false]);
            }

            $user->diaChi()->create($validated + [
                'is_mac_dinh' => $makeDefault,
            ]);
        });

        return back()->with('success', 'Dia chi moi da duoc them.')->with('active_tab', 'addresses');
    }

    public function update(Request $request, DiaChi $diaChi)
    {
        $this->authorizeOwner($request, $diaChi);

        $validated = $this->validatedAddress($request);

        DB::transaction(function () use ($request, $diaChi, $validated): void {
            if ($request->boolean('is_mac_dinh')) {
                $request->user()->diaChi()->where('id', '!=', $diaChi->id)->update(['is_mac_dinh' => false]);
            }

            $diaChi->update($validated + [
                'is_mac_dinh' => $request->boolean('is_mac_dinh') || $diaChi->is_mac_dinh,
            ]);
        });

        return back()->with('success', 'Dia chi da duoc cap nhat.')->with('active_tab', 'addresses');
    }

    public function destroy(Request $request, DiaChi $diaChi)
    {
        $this->authorizeOwner($request, $diaChi);

        $wasDefault = $diaChi->is_mac_dinh;
        $diaChi->delete();

        if ($wasDefault) {
            $request->user()->diaChi()
                ->orderByDesc('id')
                ->first()
                ?->update(['is_mac_dinh' => true]);
        }

        return back()->with('success', 'Dia chi da duoc xoa.')->with('active_tab', 'addresses');
    }

    public function makeDefault(Request $request, DiaChi $diaChi)
    {
        $this->authorizeOwner($request, $diaChi);

        DB::transaction(function () use ($request, $diaChi): void {
            $request->user()->diaChi()->update(['is_mac_dinh' => false]);
            $diaChi->update(['is_mac_dinh' => true]);
        });

        return back()->with('success', 'Da chon dia chi mac dinh.')->with('active_tab', 'addresses');
    }

    private function validatedAddress(Request $request): array
    {
        return $request->validate([
            'ten_nguoi_nhan' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['required', 'string', 'max:15'],
            'tinh_thanh' => ['required', 'string', 'max:100'],
            'quan_huyen' => ['required', 'string', 'max:100'],
            'phuong_xa' => ['nullable', 'string', 'max:100'],
            'dia_chi_cu_the' => ['required', 'string', 'max:255'],
            'loai_dia_chi' => ['required', Rule::in(['nha', 'cong_ty', 'khac'])],
        ], [
            'ten_nguoi_nhan.required' => 'Vui long nhap ten nguoi nhan.',
            'so_dien_thoai.required' => 'Vui long nhap so dien thoai.',
            'tinh_thanh.required' => 'Vui long nhap tinh thanh.',
            'quan_huyen.required' => 'Vui long nhap quan huyen.',
            'dia_chi_cu_the.required' => 'Vui long nhap dia chi cu the.',
        ]);
    }

    private function authorizeOwner(Request $request, DiaChi $diaChi): void
    {
        abort_unless($diaChi->tai_khoan_id === $request->user()->id, 403);
    }
}
