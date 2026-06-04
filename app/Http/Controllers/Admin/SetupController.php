<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function index(): View
    {
        $setups = Setup::orderBy('thu_tu')->paginate(15);

        return view('admin.setup.index', compact('setups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        Setup::create($data);

        return redirect()->route('admin.setups.index')->with('success', 'Đã thêm setup');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $setup = Setup::findOrFail($id);
        $data = $this->validateData($request);
        $setup->update($data);

        return redirect()->route('admin.setups.index')->with('success', 'Đã cập nhật setup');
    }

    public function destroy(int $id): RedirectResponse
    {
        Setup::findOrFail($id)->delete();

        return redirect()->route('admin.setups.index')->with('success', 'Đã xóa setup');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'ten_setup' => 'required|string|max:150',
            'ten_game_thu' => 'nullable|string|max:100',
            'anh_chinh' => 'nullable|image|max:4096',
            'mo_ta' => 'nullable|string',
            'noi_bat' => 'sometimes|boolean',
            'thu_tu' => 'nullable|integer',
        ]);

        if ($request->hasFile('anh_chinh')) {
            $data['anh_chinh'] = $request->file('anh_chinh')->store('setups', 'public');
        }

        $data['noi_bat'] = $request->boolean('noi_bat');

        return $data;
    }
}
