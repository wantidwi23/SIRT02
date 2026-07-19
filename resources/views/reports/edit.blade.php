@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Update Status Laporan</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $report->title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.update', $report) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Laporan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="baru" {{ old('status', $report->status) === 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="diproses" {{ old('status', $report->status) === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ old('status', $report->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ old('status', $report->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_response" class="form-label">Respons/Tindakan</label>
                            <textarea class="form-control @error('admin_response') is-invalid @enderror" id="admin_response" name="admin_response" rows="5" placeholder="Jelaskan respons atau tindakan yang diambil">{{ old('admin_response', $report->admin_response) }}</textarea>
                            @error('admin_response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="upload_file" class="form-label">Upload File/Dokumen (Opsional)</label>
                            <input type="file" class="form-control @error('upload_file') is-invalid @enderror" id="upload_file" name="upload_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Format: PDF, DOC, DOCX, JPG, PNG. Max 2MB</small>
                            @error('upload_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
