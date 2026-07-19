@extends('layouts.admin')

@section('title', 'Kepala Keluarga')
@section('page_title', 'Kepala Keluarga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Kepala Keluarga</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.head-of-families.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kepala Keluarga
        </a>
        <a href="{{ route('admin.head-of-families.import-template') }}" class="btn btn-info">
            <i class="fas fa-download"></i> Download Template
        </a>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
            <i class="fas fa-upload"></i> Import dari Excel
        </button>
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
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($headOfFamilies as $hof)
                <tr>
                    <td><strong>{{ $hof->nama }}</strong></td>
                    <td>{{ $hof->email }}</td>
                    <td>{{ Str::limit($hof->alamat, 50) }}</td>
                    <td>
                        @if($hof->active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.head-of-families.show', $hof) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="{{ route('admin.head-of-families.edit', $hof) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.head-of-families.destroy', $hof) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data kepala keluarga
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $headOfFamilies->links() }}
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Kepala Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.head-of-families.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: Excel (.xlsx, .xls) atau CSV</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
