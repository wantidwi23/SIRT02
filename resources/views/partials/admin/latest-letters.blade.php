<!-- Latest Letters -->
<div class="col-md-4">
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">Surat Terbaru</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                @forelse(\App\Models\Letter::latest()->take(3)->get() as $letter)
                    <li class="item">
                        <div class="product-info">
                            <a href="{{ route('admin.letters.show', $letter->id) }}" class="product-title">
                                {{ $letter->category->name ?? 'Surat' }}
                                <span class="badge badge-success float-right">{{ $letter->created_at->format('d M Y') }}</span>
                            </a>
                            <span class="product-description">
                                Pemohon: {{ $letter->applicant_name ?? 'N/A' }}
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="item text-center text-muted py-3">Belum ada surat</li>
                @endforelse
            </ul>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<!-- /.col -->
