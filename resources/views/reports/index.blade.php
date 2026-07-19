@extends((auth()->check() && auth()->user()->isAdmin()) ? 'layouts.admin' : 'layouts.app')

@section('title', 'Laporan Warga')
@section('page_title', 'Laporan Warga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Laporan Warga</li>
@endsection

@section('content')

<!-- Admin View -->
@if(auth()->check() && auth()->user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3">Kelola Laporan Warga</h2>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Laporan dari Warga</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Warga</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                    <tr>
                        <td><strong>{{ $report->title }}</strong></td>
                        <td>{{ $report->headOfFamily->nama ?? ($report->resident->headOfFamily->nama ?? 'N/A') }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $report->category)) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{
                                $report->status === 'selesai' ? 'success' :
                                ($report->status === 'diproses' ? 'warning' :
                                ($report->status === 'ditolak' ? 'danger' : 'secondary'))
                            }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td>{{ $report->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-sm btn-warning" title="Edit Status">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox"></i> Tidak ada laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light">
            {{ $reports->links('pagination::default') }}
        </div>
    </div>

<!-- User View -->
@else
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Laporan Saya</h1>
                <p class="text-muted">Lihat status laporan yang Anda buat</p>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReportModal">
                    <i class="bi bi-plus-lg"></i> Buat Laporan Baru
                </button>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @forelse ($reports as $report)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">{{ $report->title }}</h5>
                                <span class="badge bg-{{
                                    $report->status === 'selesai' ? 'success' :
                                    ($report->status === 'diproses' ? 'warning' :
                                    ($report->status === 'ditolak' ? 'danger' : 'secondary'))
                                }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag"></i> {{ ucfirst(str_replace('_', ' ', $report->category)) }}
                            </p>
                            <p class="card-text">{{ substr($report->description, 0, 100) }}...</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $report->created_at->format('d M Y H:i') }}
                            </small>
                        </div>
                        <div class="card-footer bg-transparent">
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#reportDetailModal{{ $report->id }}">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </button>
                        </div>
                    </div>

                    <!-- Detail Modal for each report -->
                    <div class="modal fade" id="reportDetailModal{{ $report->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $report->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Kategori</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $report->category)) }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Status</strong>
                                            <p>
                                                <span class="badge bg-{{
                                                    $report->status === 'selesai' ? 'success' :
                                                    ($report->status === 'diproses' ? 'warning' :
                                                    ($report->status === 'ditolak' ? 'danger' : 'secondary'))
                                                }}">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <strong>Tanggal Dibuat</strong>
                                            <p>{{ $report->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Deskripsi</strong>
                                        <p>{{ $report->description }}</p>
                                    </div>

                                    @if($report->evidence_images && count($report->evidence_images) > 0)
                                    <div class="mb-3">
                                        <strong>Foto Bukti ({{ count($report->evidence_images) }})</strong>
                                        <div class="mt-3">
                                            <div class="row g-3">
                                                @foreach($report->evidence_images as $image)
                                                <div class="col-12 col-sm-6">
                                                    <div style="overflow: hidden; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Bukti" style="width: 100%; height: 250px; object-fit: cover; cursor: pointer; display: block;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="setModalImage(this.src)">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($report->evidence_image)
                                    <div class="mb-3">
                                        <strong>Foto Bukti</strong>
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $report->evidence_image) }}" alt="Bukti" style="max-width: 100%; height: auto; border-radius: 8px;">
                                        </div>
                                    </div>
                                    @endif

                                    @if($report->admin_response)
                                    <hr>
                                    <div class="mb-3">
                                        <strong>Respons Admin</strong>
                                        <p>{{ $report->admin_response }}</p>
                                        
                                        @if($report->admin_file)
                                        <div class="mt-3">
                                            <strong>File/Dokumen Terlampir</strong>
                                            <div class="mt-2">
                                                @php
                                                    $ext = strtolower(pathinfo($report->admin_file, PATHINFO_EXTENSION));
                                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                                @endphp
                                                @if($isImage)
                                                    <img src="{{ asset('storage/' . $report->admin_file) }}" alt="File Admin" style="max-width: 100%; height: auto; border-radius: 8px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="setModalImage(this.src)">
                                                @else
                                                    <a href="{{ asset('storage/' . $report->admin_file) }}" class="btn btn-sm btn-primary" download>
                                                        <i class="bi bi-download"></i> Download File
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <small class="text-muted d-block mt-3">
                                            Direspons: {{ $report->responded_at->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0 mt-2">Anda belum membuat laporan apapun.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Buat Laporan -->
    <div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="createReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background: linear-gradient(135deg, #6bb8a1 0%, #5aa894 100%); color: white;">
                    <div>
                        <h5 class="modal-title" id="createReportModalLabel" style="margin: 0;">
                            <i class="bi bi-file-earmark-plus"></i> Buat Laporan Baru
                        </h5>
                        <small style="color: rgba(255,255,255,0.9);">Laporkan masalah atau kejadian di lingkungan RT Anda</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="padding: 30px;">
                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="createReportForm">
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
                                <div style="font-size: 0.85rem; color: #7f8c8d; margin-top: 5px;">
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
                                      id="description" name="description" rows="4" 
                                      placeholder="Jelaskan detail laporan Anda secara lengkap dan jelas..."
                                      required style="padding: 10px 15px; border-radius: 6px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ old('description') }}</textarea>
                            <div style="font-size: 0.85rem; color: #7f8c8d; margin-top: 5px;">
                                <i class="bi bi-info-circle"></i> Minimal 10 karakter
                            </div>
                            @error('description')
                                <div class="invalid-feedback" style="display: block;">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="padding: 20px; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" form="createReportForm" class="btn" style="background: linear-gradient(135deg, #6bb8a1 0%, #5aa894 100%); color: white; font-weight: 600;">
                        <i class="bi bi-check-lg"></i> Simpan Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal for Zoom -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Bukti" style="width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>

@endif

@endsection
