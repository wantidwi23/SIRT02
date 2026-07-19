<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with('resident')->orderBy('created_at', 'desc')->paginate(10);
        $residents = Resident::where('status', 'active')->get();
        return view('reports.index', compact('reports', 'residents'));
    }

    public function create(): View
    {
        return view('reports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'required|in:kehilangan,kerusakan_fasilitas,keamanan,kebersihan,lainnya',
            'evidence_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if user is authenticated via web guard OR session (HeadOfFamily)
        $isHeadOfFamily = session('head_of_family_id') !== null;
        
        if (!Auth::check() && !$isHeadOfFamily) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat laporan');
        }

        // Simpan head_of_family_id untuk kepala keluarga
        if ($isHeadOfFamily) {
            $validated['head_of_family_id'] = session('head_of_family_id');
        }

        // Handle multiple image uploads (max 3)
        $evidenceImages = [];
        if ($request->hasFile('evidence_images')) {
            $uploadedFiles = $request->file('evidence_images');
            
            // Ensure it's an array
            if (!is_array($uploadedFiles)) {
                $uploadedFiles = [$uploadedFiles];
            }

            // Limit to 3 images
            foreach (array_slice($uploadedFiles, 0, 3) as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('reports', 'public');
                    $evidenceImages[] = $path;
                }
            }
        }

        if (!empty($evidenceImages)) {
            $validated['evidence_images'] = $evidenceImages;
        }

        Report::create($validated);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat');
    }

    public function show(Report $report): View
    {
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report): View
    {
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditolak',
            'admin_response' => 'nullable|string',
            'upload_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('admin_response')) {
            $validated['responded_at'] = now();
        }

        // Handle file upload from admin
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $path = $file->store('reports/admin-response', 'public');
            $validated['admin_file'] = $path;
        }

        $report->update($validated);

        // Check if user is admin, redirect to admin route, otherwise redirect to user route
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.reports.show', $report)->with('success', 'Laporan diperbarui');
        }

        return redirect()->route('reports.show', $report)->with('success', 'Laporan diperbarui');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Laporan dihapus');
    }
}

