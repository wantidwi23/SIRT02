@extends('layouts.admin')

@section('title', 'Detail Konfigurasi Gemini API')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Flash Messages -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title">
                            <i class="fas fa-cog"></i> {{ $config->name }}
                        </h3>
                        @if ($config->is_active)
                            <span class="badge badge-success">AKTIF</span>
                        @else
                            <span class="badge badge-secondary">TIDAK AKTIF</span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('admin.gemini-configs.edit', $config) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.gemini-configs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Status Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-microchip"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Model</span>
                                    <span class="info-box-number" style="font-size: 18px;">{{ $config->model }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-thermometer-half"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Temperature</span>
                                    <span class="info-box-number" style="font-size: 18px;">{{ $config->temperature }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Nama</strong></label>
                                <p>{{ $config->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Max Output Tokens</strong></label>
                                <p>{{ $config->max_output_tokens }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>API Key</strong></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="apiKeyInput" 
                                           value="{{ $config->api_key }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" 
                                                onclick="toggleApiKey()" id="toggleBtn">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>System Prompt</strong></label>
                                <div class="bg-light p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                                    <pre style="margin: 0; white-space: pre-wrap; word-wrap: break-word;">{{ $config->system_prompt }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($config->description)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Deskripsi</strong></label>
                                    <p>{{ $config->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>Dibuat</strong></label>
                                <p>{{ $config->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <form action="{{ route('admin.gemini-configs.test-connection', $config) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-wifi"></i> Test Koneksi API
                        </button>
                    </form>

                    @if (!$config->is_active)
                        <form action="{{ route('admin.gemini-configs.set-active', $config) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i> Aktifkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleApiKey() {
    const input = document.getElementById('apiKeyInput');
    const btn = document.getElementById('toggleBtn');
    
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<i class="fas fa-eye"></i>';
    }
}
</script>
@endsection
