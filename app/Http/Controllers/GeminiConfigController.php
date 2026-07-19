<?php

namespace App\Http\Controllers;

use App\Models\GeminiConfig;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;

class GeminiConfigController extends Controller
{
    /**
     * Display a listing of the gemini configs.
     */
    public function index(): View
    {
        $configs = GeminiConfig::latest()->paginate(10);
        return view('admin.gemini-configs.index', compact('configs'));
    }

    /**
     * Show the form for creating a new gemini config.
     */
    public function create(): View
    {
        return view('admin.gemini-configs.create');
    }

    /**
     * Store a newly created gemini config in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'model' => 'required|string|max:255',
            'temperature' => 'required|numeric|between:0,2',
            'max_output_tokens' => 'required|integer|min:1|max:4096',
            'system_prompt' => 'required|string',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
        ]);

        // Set default model to gemini-2.5-flash if empty
        if (empty($validated['model'])) {
            $validated['model'] = 'gemini-2.5-flash';
        }

        $config = GeminiConfig::create($validated);

        // If marked as active, deactivate others
        if ($validated['is_active'] ?? false) {
            $config->setAsActive();
        }

        return redirect()->route('admin.gemini-configs.show', $config)
            ->with('success', 'Konfigurasi Gemini berhasil dibuat');
    }

    /**
     * Display the specified gemini config.
     */
    public function show(GeminiConfig $geminiConfig): View
    {
        return view('admin.gemini-configs.show', ['config' => $geminiConfig]);
    }

    /**
     * Show the form for editing the specified gemini config.
     */
    public function edit(GeminiConfig $geminiConfig): View
    {
        return view('admin.gemini-configs.edit', ['config' => $geminiConfig]);
    }

    /**
     * Update the specified gemini config in storage.
     */
    public function update(Request $request, GeminiConfig $geminiConfig): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'model' => 'required|string|max:255',
            'temperature' => 'required|numeric|between:0,2',
            'max_output_tokens' => 'required|integer|min:1|max:4096',
            'system_prompt' => 'required|string',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
        ]);

        $geminiConfig->update($validated);

        // If marked as active, deactivate others
        if ($validated['is_active'] ?? false) {
            $geminiConfig->setAsActive();
        }

        return redirect()->route('admin.gemini-configs.show', $geminiConfig)
            ->with('success', 'Konfigurasi Gemini berhasil diperbarui');
    }

    /**
     * Remove the specified gemini config from storage.
     */
    public function destroy(GeminiConfig $geminiConfig): RedirectResponse
    {
        if ($geminiConfig->is_active) {
            return back()->with('error', 'Tidak bisa menghapus konfigurasi yang sedang aktif');
        }

        $geminiConfig->delete();

        return redirect()->route('admin.gemini-configs.index')
            ->with('success', 'Konfigurasi Gemini berhasil dihapus');
    }

    /**
     * Set config as active
     */
    public function setActive(GeminiConfig $geminiConfig): RedirectResponse
    {
        $geminiConfig->setAsActive();

        return redirect()->route('admin.gemini-configs.show', $geminiConfig)
            ->with('success', 'Konfigurasi Gemini berhasil diaktifkan');
    }

    /**
     * Test API connection
     */
    public function testConnection(GeminiConfig $geminiConfig): RedirectResponse
    {
        try {
            $client = new Client();
            
            $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/' . $geminiConfig->model . ':generateContent?key=' . $geminiConfig->api_key, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => 'Test']
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 50,
                    ],
                ],
                'timeout' => 30,
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return back()->with('success', 'Koneksi API Gemini berhasil! Model: ' . $geminiConfig->model);
            } else {
                $body = json_decode($response->getBody(), true);
                $errorMsg = $body['error']['message'] ?? 'Unknown error';
                return back()->with('error', 'Koneksi gagal (' . $statusCode . '): ' . $errorMsg);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody(), true);
            $errorMsg = $body['error']['message'] ?? $e->getMessage();
            return back()->with('error', 'API Error: ' . $errorMsg . '. Mohon cek API Key dan Model Name Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
