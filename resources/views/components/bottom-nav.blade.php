@props([
    'title' => '',
    'description' => '',
    'link' => '#',
    'iconColor'=>'000000',
    'icon'=>'',
])

<div class="col-md-4 mb-3">
     <a href="{{ $link }}" class="text-decoration-none">
        <div class="card p-3 action-card kelola-subtest">
            <div class="d-flex align-items-center">
                <div class="action-icon" style="font-size:28px;">
                     <i class="mdi {{ $icon }}" style="font-size:28px;color:{{ $iconColor }};"></i>
                </div>
                <div class="action-info ml-3">
                    <h6 class="mb-1">{{ $title }}</h6>
                    <p class="small mb-0 text-muted">{{ $description }}</p>
                </div>
            </div>
        </div>
    </a>
</div>