<?php

namespace App\Http\Controllers;

use App\Models\LetterCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class LetterCategoryController extends Controller
{
    public function index(): View
    {
        $categories = LetterCategory::withCount('letters')->paginate(10);
        return view('admin.letter-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.letter-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:letter_categories,name',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        LetterCategory::create($validated);

        return redirect()->route('admin.letter-categories.index')->with('success', 'Kategori surat berhasil ditambahkan');
    }

    public function edit(LetterCategory $letterCategory): View
    {
        return view('admin.letter-categories.edit', compact('letterCategory'));
    }

    public function update(Request $request, LetterCategory $letterCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:letter_categories,name,' . $letterCategory->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $letterCategory->update($validated);

        return redirect()->route('admin.letter-categories.index')->with('success', 'Kategori surat berhasil diperbarui');
    }

    public function destroy(LetterCategory $letterCategory): RedirectResponse
    {
        if ($letterCategory->letters()->count() > 0) {
            return redirect()->route('admin.letter-categories.index')->with('error', 'Kategori surat tidak dapat dihapus karena masih ada surat yang menggunakan kategori ini');
        }

        $letterCategory->delete();

        return redirect()->route('admin.letter-categories.index')->with('success', 'Kategori surat berhasil dihapus');
    }
}
