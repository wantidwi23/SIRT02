<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Resident;
use App\Models\LetterCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LetterController extends Controller
{
    public function index(): View
    {
        $categories = LetterCategory::all();
        
        // Check if user is admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            $letters = Letter::with('category')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.letters.index', compact('letters', 'categories'));
        }
        
        // User (authenticated or head_of_family) hanya melihat surat yang dibuat oleh dirinya sendiri
        $query = Letter::with('category')->orderBy('created_at', 'desc');
        
        // Filter by head_of_family_id if session exists
        if (session('head_of_family_id')) {
            $query->where('head_of_family_id', session('head_of_family_id'));
        } elseif (auth()->check()) {
            // For regular users, show their name
            $query->where('applicant_name', auth()->user()->name);
        }
        
        $letters = $query->paginate(10);
        return view('letters.index', compact('letters', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_nik' => 'required|string|min:16|max:16',
            'identity_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'letter_category_id' => 'required|exists:letter_categories,id',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('identity_image')) {
            $validated['identity_image'] = $request->file('identity_image')->store('identities', 'public');
        }

        // Auto-set head_of_family_id if user is logged in via session
        if (session('head_of_family_id')) {
            $validated['head_of_family_id'] = session('head_of_family_id');
        }

        Letter::create($validated);

        return redirect()->route('letters.index')->with('success', 'Permintaan surat berhasil dibuat');
    }

    public function show(Letter $letter): View
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.letters.show', compact('letter'));
        }
        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter): View
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.letters.edit', compact('letter'));
        }
        return view('letters.edit', compact('letter'));
    }

    public function update(Request $request, Letter $letter): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,siap_diambil,diambil,ditolak',
            'admin_notes' => 'nullable|string',
            'letter_file' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('letter_file')) {
            $validated['letter_file'] = $request->file('letter_file')->store('letters', 'public');
        }

        if ($request->input('status') === 'siap_diambil') {
            $validated['ready_at'] = now();
        }

        if ($request->input('status') === 'diambil') {
            $validated['taken_at'] = now();
        }

        $letter->update($validated);

        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.letters.show', $letter)->with('success', 'Status surat berhasil diperbarui');
        }
        return redirect()->route('letters.show', $letter)->with('success', 'Surat diperbarui');
    }

    public function destroy(Letter $letter): RedirectResponse
    {
        $letter->delete();
        return redirect()->route('letters.index')->with('success', 'Surat dihapus');
    }
}
