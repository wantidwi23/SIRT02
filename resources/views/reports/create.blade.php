@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('content')
<style>
    .create-report-header {
        background: linear-gradient(135deg, #6bb8a1 0%, #5aa894 100%);
        padding: 30px 0;
        margin-bottom: 30px;
        border-radius: 8px;
    }
    
    .form-section {
        background: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #6bb8a1;
        box-shadow: 0 0 0 0.2rem rgba(107, 184, 161, 0.25);
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #6bb8a1 0%, #5aa894 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #5aa894 0%, #4a9784 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 184, 161, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .info-box {
        background: #e8f5f2;
        border-left: 4px solid #6bb8a1;
        padding: 20px;
        border-radius: 6px;
        margin-top: 30px;
    }
    
    .info-box h5 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .info-box ul {
        margin: 10px 0 0 20px;
        color: #555;
    }
    
    .info-box li {
        margin-bottom: 5px;
    }
    
    .back-link {
        color: #6bb8a1;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .back-link:hover {
        color: #5aa894;
    }
    
    .back-link i {
        margin-right: 8px;
    }

    .form-text-small {
        font-size: 0.85rem;
        color: #7f8c8d;
        margin-top: 5px;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<!-- Header Section -->
<div class="create-report-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 style="color: white; margin: 0; font-weight: 700;">
                <i class="bi bi-file-earmark-plus"></i> Buat Laporan Baru
            </h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">Laporkan masalah atau kejadian di lingkungan RT Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('reports.index') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<!-- Form Section -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="form-section">
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul Laporan -->
                <div class="mb-4">
                    <label for="title" class="form-label">
                        <i class="bi bi-file-text"></i> Judul Laporan
                    </label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" 
                           placeholder="Contoh: Jalan Berlubang di Depan Rumah"
                           required value="{{ old('title') }}"
                           style="padding: 10px 15px; border-radius: 6px;">
                    @error('title')
                        <div class="invalid-feedback" style="display: block;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Kategori dan Foto Bukti -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="category" class="form-label">
                            <i class="bi bi-tag"></i> Kategori
                        </label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required style="padding: 10px 15px; border-radius: 6px;">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="kehilangan" {{ old('category') === 'kehilangan' ? 'selected' : '' }}>Kehilangan</option>
                            <option value="kerusakan_fasilitas" {{ old('category') === 'kerusakan_fasilitas' ? 'selected' : '' }}>Kerusakan Fasilitas</option>
                            <option value="keamanan" {{ old('category') === 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="kebersihan" {{ old('category') === 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="lainnya" {{ old('category') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback" style="display: block;">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="evidence_images" class="form-label">
                            <i class="bi bi-image"></i> Foto Bukti (Max 3)
                        </label>
                        <input type="file" 
                               class="form-control @error('evidence_images.*') is-invalid @enderror" 
                               id="evidence_images" name="evidence_images[]" accept="image/*" multiple
                               style="padding: 10px 15px; border-radius: 6px;">
                        <div class="form-text-small">
                            <i class="bi bi-info-circle"></i> Format: JPG, PNG, GIF (max 2MB per file, maksimal 3 file)
                        </div>
                        @error('evidence_images.*')
                            <div class="invalid-feedback" style="display: block;">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi Laporan -->
                <div class="mb-4">
                    <label for="description" class="form-label">
                        <i class="bi bi-chat-left-text"></i> Deskripsi Laporan
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" 
                              placeholder="Jelaskan detail laporan Anda secara lengkap dan jelas..."
                              required style="padding: 10px 15px; border-radius: 6px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ old('description') }}</textarea>
                    <div class="form-text-small">
                        <i class="bi bi-info-circle"></i> Minimal 10 karakter
                    </div>
                    @error('description')
                        <div class="invalid-feedback" style="display: block;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-3 pt-3">
                    <button type="submit" class="btn btn-primary-custom flex-grow-1">
                        <i class="bi bi-check-lg"></i> Simpan Laporan
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary flex-grow-1">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <h5>
                <i class="bi bi-lightbulb"></i> Tips Membuat Laporan yang Baik
            </h5>
            <ul class="mb-0">
                <li><strong>Judul Jelas:</strong> Tuliskan judul yang deskriptif dan mudah dipahami</li>
                <li><strong>Detail Lokasi:</strong> Cantumkan lokasi kejadian dengan detail (nama jalan, nomor rumah, dll)</li>
                <li><strong>Bukti Visual:</strong> Sertakan foto/bukti jika memungkinkan untuk memperjelas masalah</li>
                <li><strong>Deskripsi Lengkap:</strong> Jelaskan apa yang terjadi, kapan, dan dampaknya</li>
                <li><strong>Kategori Tepat:</strong> Pilih kategori yang paling sesuai dengan jenis laporan</li>
            </ul>
        </div>
    </div>
</div>
@endsection
