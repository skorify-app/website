@props([
    'total_acc' => [],
])

<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3">Jumlah akun</h5>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($total_acc as $summary)
                <div class="card p-3" style="min-width:220px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-light rounded mr-3" style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                            @if ($summary->role == 'STAFF')
                                <i class="mdi mdi-account" style="font-size:26px;color:#2563eb"></i>
                            @elseif ($summary->role == 'PARTICIPANT')
                                <i class="mdi mdi-account-multiple" style="font-size:26px;color:#2563eb"></i>
                            @elseif ($summary->role == 'ADMIN')
                                <i class="mdi mdi-account-key" style="font-size:26px;color:#2563eb"></i>
                            @endif
                        </div>
                        <div>
                            <div class="text-muted">{{ ucfirst(strtolower($summary->role)) }}</div>
                            <div class="h5">{{ $summary->total }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
