<?php

namespace App\Http\Controllers;

use App\Models\HeadOfFamily;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Imports\HeadOfFamiliesImport;
use App\Exports\HeadOfFamiliesTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class HeadOfFamilyController extends Controller
{
    public function index(): View
    {
        $headOfFamilies = HeadOfFamily::paginate(10);
        return view('admin.head-of-families.index', compact('headOfFamilies'));
    }

    public function create(): View
    {
        return view('admin.head-of-families.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:head_of_families,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        HeadOfFamily::create($validated);

        return redirect()->route('admin.head-of-families.index')
            ->with('success', 'Kepala keluarga berhasil ditambahkan');
    }

    public function show(HeadOfFamily $headOfFamily): View
    {
        return view('admin.head-of-families.show', compact('headOfFamily'));
    }

    public function edit(HeadOfFamily $headOfFamily): View
    {
        return view('admin.head-of-families.edit', compact('headOfFamily'));
    }

    public function update(Request $request, HeadOfFamily $headOfFamily): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:head_of_families,email,' . $headOfFamily->id,
            'password' => 'nullable|string|min:8|confirmed',
            'active' => 'boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $headOfFamily->update($validated);

        return redirect()->route('admin.head-of-families.show', $headOfFamily)
            ->with('success', 'Kepala keluarga berhasil diperbarui');
    }

    public function destroy(HeadOfFamily $headOfFamily): RedirectResponse
    {
        $headOfFamily->delete();

        return redirect()->route('admin.head-of-families.index')
            ->with('success', 'Kepala keluarga berhasil dihapus');
    }

    public function importTemplate()
    {
        return Excel::download(new HeadOfFamiliesTemplateExport, 'template_kepala_keluarga.xlsx');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new HeadOfFamiliesImport, $request->file('file'));

            return redirect()->route('admin.head-of-families.index')
                ->with('success', 'Data kepala keluarga berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('admin.head-of-families.index')
                ->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }
}
