@extends('layouts.admin')

@section('title', 'Detail Kepala Keluarga')
@section('page_title', 'Detail Kepala Keluarga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.head-of-families.index') }}">Kepala Keluarga</a></li>
    <li class="breadcrumb-item active">{{ $headOfFamily->nama }}</li>
@endsection

@section('content')
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $headOfFamily->nama }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-muted">Nama</h6>
                    <p class="fs-5">{{ $headOfFamily->nama }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Email</h6>
                    <p class="fs-5">{{ $headOfFamily->email }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Alamat</h6>
                    <p>{{ $headOfFamily->alamat }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Status</h6>
                    <p>
                        @if($headOfFamily->active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Dibuat</h6>
                    <p>{{ $headOfFamily->created_at->format('d M Y H:i') }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Terakhir Diperbarui</h6>
                    <p>{{ $headOfFamily->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.head-of-families.edit', $headOfFamily) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.head-of-families.destroy', $headOfFamily) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('admin.head-of-families.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
