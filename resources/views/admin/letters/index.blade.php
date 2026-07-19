@extends('layouts.admin')

@section('title', 'Kelola Permintaan Surat')
@section('page_title', 'Kelola Permintaan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Permintaan Surat</li>
@endsection

@section('content')


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
    <div class="card-header bg-primary">
        <h3 class="card-title">Daftar Permintaan Surat</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pemohon</th>
                    <th>NIK</th>
                    <th>Jenis Surat</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Tanggal Buat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($letters as $letter)
                <tr>
                    <td>{{ ($letters->currentPage() - 1) * $letters->perPage() + $loop->iteration }}</td>
                    <td><strong>{{ $letter->applicant_name }}</strong></td>
                    <td>{{ $letter->applicant_nik }}</td>
                    <td>{{ $letter->category->name ?? '-' }}</td>
                    <td>{{ Str::limit($letter->purpose, 40) }}</td>
                    <td>
                        @switch($letter->status)
                            @case('menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                                @break
                            @case('diproses')
                                <span class="badge badge-info">Diproses</span>
                                @break
                            @case('siap_diambil')
                                <span class="badge badge-success">Siap Diambil</span>
                                @break
                            @case('diambil')
                                <span class="badge badge-primary">Diambil</span>
                                @break
                            @case('ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                                @break
                        @endswitch
                    </td>
                    <td>{{ $letter->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('admin.letters.show', $letter->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.letters.edit', $letter->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.letters.destroy', $letter->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus permintaan surat ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada permintaan surat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($letters->count() > 0)
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $letters->links() }}
            </div>
        </div>
    @endif
</div>

@include('admin.letters.partials.create-modal')
@endsection
