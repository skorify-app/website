<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Notifikasi</title>
        <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
          <link rel="stylesheet" href="{{ @asset('css/bootstrap-icons.min.css') }}">
        
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
        <form action="{{ route('notifications.markAllRead') }}" method="POST" id="mark-all-read-form" style="margin:0;">
            @csrf
            <button class="btn btn-sm btn-mark-all-read" style="background-color:#001D39;color:#fff;">Tandai semua dibaca</button>
        </form>
    </div>

    {{-- Filter form --}}
    <form method="GET" class="mb-3">
        <div class="form-row align-items-center " style="gap: px">
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

            <div class="col-auto" style="width:16%;">
                <input type="text" name="subtest" class="form-control form-control-sm" placeholder="Judul subtes" value="{{ old('subtest', $filters['subtest'] ?? '') }}">
            </div>

            <div class="col-auto" style="width:15%;">
                <input type="text" name="date_from" class="form-control form-control-sm flatpickr-date" placeholder="Dari tanggal" value="{{ old('date_from', $filters['date_from'] ?? '') }}">
            </div>

            <div class="col-auto" style="width:15%;">
                <input type="text" name="date_to" class="form-control form-control-sm flatpickr-date" placeholder="Sampai tanggal" value="{{ old('date_to', $filters['date_to'] ?? '') }}">
            </div>

            

            <div class="col-auto">
                <select name="per_page" class="form-control form-control-sm">
                    <option value="10" {{ (old('per_page', $filters['per_page'] ?? 20) == 10) ? 'selected' : '' }}>10</option>
                    <option value="20" {{ (old('per_page', $filters['per_page'] ?? 20) == 20) ? 'selected' : '' }}>20</option>
                    <option value="50" {{ (old('per_page', $filters['per_page'] ?? 20) == 50) ? 'selected' : '' }}>50</option>
                </select>
            </div>

            <div class="col-auto" style="margin-top:1%;">
                <button class="btn btn-sm " style="background-color:#001D39;color:#fff;">Filter</button>
                <a href="{{ route('notifications.index') }}" ><button class="btn btn-sm "  style="background-color:#001D39;color:#fff;">Pulihkan</button></a>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success text-dark">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0" id="notifications-list">
            @include('notifications.partials.list', ['notifications' => $notifications])
        </div>
        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
            <div id="pagination-info" style="font-size: 14px; color: #6c757d; white-space: nowrap;">
                Menampilkan {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }} dari {{ $notifications->total() }} notifikasi
            </div>
            <div id="pagination-links" style="margin-left: 20px;">
                {{ $notifications->links('components.pagination') }}
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

        <script>
        // AJAX Pagination
        document.addEventListener('DOMContentLoaded', function() {
            const paginationContainer = document.getElementById('pagination-links');
            const notificationsList = document.getElementById('notifications-list');
            const paginationInfo = document.getElementById('pagination-info');
            
            // Event delegation for pagination links
            paginationContainer.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;
                
                e.preventDefault();
                const url = link.getAttribute('href');
                if (!url) return;
                
                // Show loading state
                notificationsList.style.opacity = '0.5';
                notificationsList.style.pointerEvents = 'none';
                
                // Fetch new page
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update notifications list
                        notificationsList.innerHTML = data.listHtml;
                        
                        // Update pagination links
                        paginationContainer.innerHTML = data.paginationHtml;
                        
                        // Update info text
                        paginationInfo.textContent = `Menampilkan ${data.firstItem} - ${data.lastItem} dari ${data.total} notifikasi`;
                        
                        // Scroll to top of notifications
                        notificationsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    alert('Gagal memuat halaman. Silakan coba lagi.');
                })
                .finally(() => {
                    // Remove loading state
                    notificationsList.style.opacity = '1';
                    notificationsList.style.pointerEvents = 'auto';
                });
            });
        });
        
        // Handle "Tandai dibaca" button clicks via AJAX
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-mark-read')) {
                e.preventDefault();
                
                const button = e.target;
                const form = button.closest('form');
                const notificationItem = button.closest('li');
                const url = form.action;
                
                // Disable button during request
                button.disabled = true;
                button.textContent = 'Memproses...';
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI: change color to gray and font weight to normal
                        const contentDiv = notificationItem.querySelector('div[style*="flex:1"]');
                        if (contentDiv) {
                            contentDiv.style.color = '#999';
                            const textDiv = contentDiv.querySelector('div');
                            if (textDiv) {
                                textDiv.style.fontWeight = '400';
                            }
                        }
                        
                        // Replace button with "Dibaca" text
                        const buttonContainer = button.closest('div[style*="flex:0 0 auto"]');
                        if (buttonContainer) {
                            buttonContainer.innerHTML = '<span class="text-muted">Dibaca</span>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking as read:', error);
                    alert('Gagal menandai notifikasi. Silakan coba lagi.');
                    button.disabled = false;
                    button.textContent = 'Tandai dibaca';
                });
            }
        });
        
        // Handle "Tandai Semua Dibaca" button click via AJAX
        document.addEventListener('click', function(e) {
            if (e.target && (e.target.classList.contains('btn-mark-all-read') || e.target.closest('.btn-mark-all-read'))) {
                e.preventDefault();
                
                const button = e.target.classList.contains('btn-mark-all-read') ? e.target : e.target.closest('.btn-mark-all-read');
                const form = document.getElementById('mark-all-read-form');
                const url = form.action;
                
                // Disable button during request
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update all unread notifications to read state
                        const notificationsList = document.getElementById('notifications-list');
                        const unreadNotifications = notificationsList.querySelectorAll('li');
                        
                        unreadNotifications.forEach(item => {
                            const contentDiv = item.querySelector('div[style*="flex:1"]');
                            if (contentDiv && contentDiv.style.color !== 'rgb(153, 153, 153)') {
                                // Change to gray (read state)
                                contentDiv.style.color = '#999';
                                const textDiv = contentDiv.querySelector('div');
                                if (textDiv) {
                                    textDiv.style.fontWeight = '400';
                                }
                                
                                // Replace button with "Dibaca" text
                                const buttonContainer = item.querySelector('div[style*="flex:0 0 auto"]');
                                if (buttonContainer && buttonContainer.querySelector('.btn-mark-read')) {
                                    buttonContainer.innerHTML = '<span class="text-muted">Dibaca</span>';
                                }
                            }
                        });
                        
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success text-dark';
                        alertDiv.textContent = 'Semua notifikasi telah ditandai dibaca.';
                        form.parentElement.insertBefore(alertDiv, form);
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => alertDiv.remove(), 3000);
                        
                        // Re-enable button
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error marking all as read:', error);
                    alert('Gagal menandai semua notifikasi. Silakan coba lagi.');
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        });
        </script>
        <script src="{{ @asset('js/subtest.js') }}"></script>
        <script src="{{ @asset('js/sweetalert2.js') }}"></script>

        <script src="{{asset('vendor/global/global.min.js')}}"></script>
        <script src="{{asset('js/quixnav-init.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>

        <script src="{{ @asset('js/popper.min.js') }}"></script>
        <script src="{{ @asset('js/bootstrap.min.js') }}"></script>
                <!-- Core JS: jQuery + Bootstrap 4 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Theme/vendor initializers -->
        <script src="{{ asset('vendor/global/global.min.js') }}"></script>
        <script src="{{ asset('js/quixnav-init.js') }}"></script>
        <script src="{{ asset('js/custom.min.js') }}"></script>

        <!-- Chart.js for statistics chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
        
        <script>
        // Initialize Flatpickr with Indonesian locale
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.flatpickr-date', {
                locale: 'id',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd F Y',
                allowInput: true
            });
        });
        </script>
    </body>
</html>
