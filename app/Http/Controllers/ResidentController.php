<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Imports\ResidentsImport;
use App\Exports\ResidentsTemplateExport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResidentController extends Controller
{
    /**
     * Create/update/delete operations are only for admin
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(): View
    {
        $residents = Resident::orderBy('name')->paginate(15);
        return view('residents.index', compact('residents'));
    }

    public function create(): View
    {
        return view('residents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'email' => 'required|email|unique:residents,email',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive,pindah',
            'notes' => 'nullable|string',
        ]);

        Resident::create($validated);

        return redirect()->route('admin.residents.index')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show(Resident $resident): View
    {
        $resident->load(['reports', 'letters']);
        return view('residents.show', compact('resident'));
    }

    public function edit(Resident $resident): View
    {
        return view('residents.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'email' => 'required|email|unique:residents,email,' . $resident->id,
            'address' => 'required|string',
            'status' => 'required|in:active,inactive,pindah',
            'notes' => 'nullable|string',
        ]);

        $resident->update($validated);

        return redirect()->route('admin.residents.show', $resident)->with('success', 'Data warga diperbarui');
    }

    public function destroy(Resident $resident): RedirectResponse
    {
        $resident->delete();
        return redirect()->route('admin.residents.index')->with('success', 'Data warga dihapus');
    }

    public function search(Request $request): View
    {
        $query = $request->input('q');
        $residents = Resident::where('name', 'like', "%{$query}%")
            ->orWhere('nik', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->paginate(15);

        return view('residents.index', compact('residents'));
    }

    public function importShow(): View
    {
        return view('residents.import');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ResidentsImport(), $request->file('file'));
            return redirect()->route('admin.residents.index')->with('success', 'Data warga berhasil diimpor');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new ResidentsTemplateExport(), 'template-data-warga.xlsx');
    }}