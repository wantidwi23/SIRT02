@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('title', 'Data Warga')
@section('page_title', 'Data Warga') {{-- For admin layout --}}

@section('breadcrumb') {{-- For admin layout --}}
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Data Warga</li>
@endsection

@section('content')
@if(auth()->user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.residents.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Warga
            </a>
            <a href="{{ route('admin.residents.import-show') }}" class="btn btn-info">
                <i class="fas fa-upload"></i> Impor Data
            </a>
            <a href="{{ route('admin.residents.download-template') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Download Template
            </a>
        </div>
    </div>
@else
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Data Warga</h1>
                <p class="text-muted">Kelola data warga RT</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('residents.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Warga
                </a>
            </div>
        </div>
@endif

@if ($message = Session::get('success'))
    @if(auth()->user()->isAdmin())
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endif

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ auth()->user()->isAdmin() ? route('admin.residents.search') : route('residents.search') }}" class="d-flex gap-2">
            <input type="text" name="q" class="form-control" placeholder="Cari nama atau email..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-outline-primary">
                @if(auth()->user()->isAdmin())
                    <i class="fas fa-search"></i>
                @else
                    <i class="bi bi-search"></i>
                @endif
                Cari
            </button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($residents as $resident)
                <tr>
                    <td><strong>{{ $resident->name }}</strong></td>
                    <td>{{ $resident->gender ? ucfirst($resident->gender) : '-' }}</td>
                    <td>{{ $resident->email }}</td>
                    <td>
                        @if(auth()->user()->isAdmin())
                            <span class="badge badge-{{ $resident->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($resident->status) }}
                            </span>
                        @else
                            <span class="badge bg-{{ $resident->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($resident->status) }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.residents.show' : 'residents.show', $resident) }}" class="btn btn-sm btn-info">
                            @if(auth()->user()->isAdmin())
                                <i class="fas fa-eye"></i>
                            @else
                                <i class="bi bi-eye"></i>
                            @endif
                            Lihat
                        </a>
                        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.residents.edit' : 'residents.edit', $resident) }}" class="btn btn-sm btn-warning">
                            @if(auth()->user()->isAdmin())
                                <i class="fas fa-edit"></i>
                            @else
                                <i class="bi bi-pencil"></i>
                            @endif
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        @if(auth()->user()->isAdmin())
                            <i class="fas fa-inbox"></i>
                        @else
                            <i class="bi bi-inbox"></i>
                        @endif
                        Tidak ada data warga
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $residents->links(auth()->user()->isAdmin() ? 'pagination::default' : 'pagination::bootstrap-5') }}
    </div>
</div>

@if(!auth()->user()->isAdmin())
    </div>
@endif
@endsection
