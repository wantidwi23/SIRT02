@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('content')
@if(auth()->user()->isAdmin())
    <!-- Admin View -->
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>{{ $report->title }}</h1>
                <p class="text-muted">Detail Laporan</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Status
                </a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Laporan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kepala Keluarga</strong>
                                <p>
                                    <a href="{{ route('admin.head-of-families.show', $report->headOfFamily) }}">
                                        {{ $report->headOfFamily->nama }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>Kategori</strong>
                                <p>{{ ucfirst(str_replace('_', ' ', $report->category)) }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
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
                            <div class="col-md-6">
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
                    </div>
                </div>

                @if($report->admin_response)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Respons Admin</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $report->admin_response }}</p>
                        
                        @if($report->admin_file)
                        <div class="mt-3">
                            <strong>File/Dokumen Terlampir</strong>
                            <div class="mt-2">
                                @if(in_array(pathinfo($report->admin_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
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
                </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Kepala Keluarga</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Nama</strong><br>
                            {{ $report->headOfFamily->nama }}
                        </p>
                        <p>
                            <strong>Email</strong><br>
                            {{ $report->headOfFamily->email }}
                        </p>
                        <p>
                            <strong>Alamat</strong><br>
                            {{ $report->headOfFamily->alamat ?? '-' }}
                        </p>
                        <a href="{{ route('admin.head-of-families.show', $report->headOfFamily) }}" class="btn btn-sm btn-outline-primary">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-warning btn-sm w-100 mb-2">
                            <i class="bi bi-pencil"></i> Edit Status
                        </a>
                        <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- User View - Modal Style -->
    <div class="modal fade" id="reportDetailModal" tabindex="-1" aria-labelledby="reportDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportDetailModalLabel">{{ $report->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                @if(in_array(pathinfo($report->admin_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('reportDetailModal'));
            modal.show();
            
            document.getElementById('reportDetailModal').addEventListener('hidden.bs.modal', function() {
                window.location.href = '{{ route("reports.index") }}';
            });
        });
    </script>

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