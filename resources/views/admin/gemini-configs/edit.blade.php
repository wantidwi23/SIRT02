@extends('layouts.admin')

@section('title', 'Edit Konfigurasi Gemini API')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Konfigurasi Gemini API
                    </h3>
                </div>

                <form action="{{ route('admin.gemini-configs.update', $config) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Nama Konfigurasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $config->name) }}" 
                                   placeholder="Contoh: Production, Development" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- API Key -->
                        <div class="form-group">
                            <label for="api_key">API Key <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('api_key') is-invalid @enderror" 
                                      id="api_key" name="api_key" rows="3" 
                                      placeholder="Masukkan API key dari Google Cloud Console" required>{{ old('api_key', $config->api_key) }}</textarea>
                            @error('api_key')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Dapatkan API key dari <a href="https://aistudio.google.com/apikey" target="_blank">Google AI Studio</a>
                            </small>
                        </div>

                        <!-- Model -->
                        <div class="form-group">
                            <label for="model">Model <span class="text-danger">*</span></label>
                            <select class="form-control @error('model') is-invalid @enderror" id="model" name="model" required>
                                <option value="">-- Pilih Model --</option>
                                <option value="gemini-2.5-flash" {{ old('model', $config->model) == 'gemini-2.5-flash' ? 'selected' : '' }}>Gemini 2.5 Flash (Latest)</option>
                                <option value="gemini-2.0-flash" {{ old('model', $config->model) == 'gemini-2.0-flash' ? 'selected' : '' }}>Gemini 2.0 Flash (Recommended)</option>
                                <option value="gemini-1.5-pro" {{ old('model', $config->model) == 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro</option>
                                <option value="gemini-1.5-flash" {{ old('model', $config->model) == 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash</option>
                            </select>
                            @error('model')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Temperature -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="temperature">Temperature <span class="text-danger">*</span></label>
                                    <input type="number" step="0.1" min="0" max="2" 
                                           class="form-control @error('temperature') is-invalid @enderror" 
                                           id="temperature" name="temperature" value="{{ old('temperature', $config->temperature) }}" required>
                                    @error('temperature')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">0 = Deterministic, 1 = Balanced, 2 = Creative</small>
                                </div>
                            </div>

                            <!-- Max Output Tokens -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_output_tokens">Max Output Tokens <span class="text-danger">*</span></label>
                                    <input type="number" min="1" max="4096" 
                                           class="form-control @error('max_output_tokens') is-invalid @enderror" 
                                           id="max_output_tokens" name="max_output_tokens" value="{{ old('max_output_tokens', $config->max_output_tokens) }}" required>
                                    @error('max_output_tokens')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- System Prompt -->
                        <div class="form-group">
                            <label for="system_prompt">System Prompt <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('system_prompt') is-invalid @enderror" 
                                      id="system_prompt" name="system_prompt" rows="5" required>{{ old('system_prompt', $config->system_prompt) }}</textarea>
                            @error('system_prompt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi konfigurasi ini...">{{ old('description', $config->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $config->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Aktifkan konfigurasi ini
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Jika dicentang, konfigurasi lain akan otomatis dinonaktifkan
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.gemini-configs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
