<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kelola Subtes</title>
        <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ @asset('css/bootstrap-icons.min.css') }}">
        <style>
            .modal-contentSubtes label {
               margin-bottom: 0; 
            }
        </style>
    </head>

    <body>
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>

        <div id="main-wrapper">
            <x-nav-header></x-nav-header>

            <x-header></x-header>

            @if($role == "ADMIN")
                <x-sidebar.admin></x-sidebar.admin>
            @else
                <x-sidebar.staff></x-sidebar.staff>
            @endif

            <div class="content-body">
<div class="container" style="max-width:900px;margin-top:30px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lihat semua notifikasi</h4>
        <form action="{{ route('notifications.markAllRead') }}" method="POST" style="margin:0;">
            @csrf
            <button class="btn btn-sm btn-outline-primary">Tandai semua dibaca</button>
        </form>
    </div>

    {{-- Filter form --}}
    <form method="GET" class="mb-3">
        <div class="form-row align-items-end">
            <div class="col-auto">
                <label class="sr-only">Status</label>
                <select name="status" class="form-control form-control-sm">
                    <option value="all" {{ (old('status',$filters['status'] ?? 'all') == 'all') ? 'selected' : '' }}>Semua</option>
                    <option value="unread" {{ (old('status',$filters['status'] ?? '') == 'unread') ? 'selected' : '' }}>Belum dibaca</option>
                    <option value="read" {{ (old('status',$filters['status'] ?? '') == 'read') ? 'selected' : '' }}>Sudah dibaca</option>
                </select>
            </div>

            <div class="col-auto">
                <input type="text" name="actor" class="form-control form-control-sm" placeholder="Nama pelaku" value="{{ old('actor', $filters['actor'] ?? '') }}">
            </div>

            <div class="col-auto">
                <select name="action" class="form-control form-control-sm">
                    <option value="" {{ (old('action',$filters['action'] ?? '') == '') ? 'selected' : '' }}>Semua aksi</option>
                    <option value="menambahkan" {{ (old('action',$filters['action'] ?? '') == 'menambahkan') ? 'selected' : '' }}>Menambahkan</option>
                    <option value="mengedit" {{ (old('action',$filters['action'] ?? '') == 'mengedit') ? 'selected' : '' }}>Mengedit</option>
                    <option value="menghapus" {{ (old('action',$filters['action'] ?? '') == 'menghapus') ? 'selected' : '' }}>Menghapus</option>
                </select>
            </div>

            <div class="col-auto">
                <input type="text" name="subtest" class="form-control form-control-sm" placeholder="Judul subtes" value="{{ old('subtest', $filters['subtest'] ?? '') }}">
            </div>

            <div class="col-auto">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ old('date_from', $filters['date_from'] ?? '') }}">
            </div>

            <div class="col-auto">
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ old('date_to', $filters['date_to'] ?? '') }}">
            </div>

            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="only_me" id="only_me" value="1" {{ (old('only_me', $filters['only_me'] ?? false) ? 'checked' : '') }}>
                    <label class="form-check-label small" for="only_me">Hanya saya</label>
                </div>
            </div>

            <div class="col-auto">
                <select name="per_page" class="form-control form-control-sm">
                    <option value="10" {{ (old('per_page', $filters['per_page'] ?? 20) == 10) ? 'selected' : '' }}>10</option>
                    <option value="20" {{ (old('per_page', $filters['per_page'] ?? 20) == 20) ? 'selected' : '' }}>20</option>
                    <option value="50" {{ (old('per_page', $filters['per_page'] ?? 20) == 50) ? 'selected' : '' }}>50</option>
                </select>
            </div>

            <div class="col-auto">
                <button class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if($notifications->count() > 0)
                <ul class="list-unstyled mb-0">
                    @foreach($notifications as $notification)
                        <li style="border-bottom:1px solid #eee;padding:12px 16px;">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                                <div style="flex:1;">
                                    <div style="font-weight: {{ is_null($notification->read_at) ? '700' : '400' }};">
                                        <strong>{{ $notification->data['actor'] }}</strong> {{ $notification->data['action'] }} <strong>subtes</strong> {{ $notification->data['subtest'] }}.
                                    </div>
                                    <div style="color:#777;font-size:13px;margin-top:6px;">{{ $notification->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <div style="flex:0 0 auto;text-align:right;">
                                    @if(is_null($notification->read_at))
                                        <form action="{{ route('notifications.markRead', ['id' => $notification->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-primary">Tandai dibaca</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Dibaca</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-4 text-center text-muted">Belum ada notifikasi.</div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
                Menampilkan {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }} dari {{ $notifications->total() }} notifikasi
            </div>
            <div>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
                   
                
            </div>

            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Developed by <a href="#" target="_blank">PBL-TRPL308</a> 2025</p>
                </div>
            </div>
        </div>

        <script src="{{ @asset('js/subtest.js') }}"></script>
        <script src="{{ @asset('js/sweetalert2.js') }}"></script>

        <script src="{{asset('vendor/global/global.min.js')}}"></script>
        <script src="{{asset('js/quixnav-init.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>

        <script src="{{ @asset('js/popper.min.js') }}"></script>
        <script src="{{ @asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>
