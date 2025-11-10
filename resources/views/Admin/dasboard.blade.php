<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.3.67/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Required vendors (moved to bottom to avoid early execution) -->
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header" style="background-color: #001D39;">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/skorify-logo.png') }}" width="400" alt="">
                <img class="logo-compact" src="{{ asset('images/skorify-logo.png') }}" alt="">
                <img class="brand-title" src="{{ asset('images/skorify-text.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span style="background-color: #001D39;" class="line"></span>
                    <span style="background-color: #001D39;" class="line"></span>
                    <span style="background-color: #001D39;" class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Cari" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Notifikasi</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="notification-box bg-light-primary">
                                                <i class="mdi mdi-account text-primary"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="mb-0"><strong>Juan</strong> menambahkan <strong>subtes</strong> matematika.</p>
                                                <small class="text-muted">3:20 WIB</small>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center" href="#">Lihat Semua Notifikasi</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Hello, Admin!</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">
                                        <i class="mdi mdi-account mr-2"></i>
                                        Profil
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="mdi mdi-email mr-2"></i>
                                        Kotak Masuk
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">
                                        <i class="mdi mdi-logout mr-2"></i>
                                        Keluar
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start (from Staff index)
        ***********************************-->
        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="index.html" aria-expanded="false">
                            <i class="mdi mdi-home"></i>
                            <span class="nav-text">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-account-group"></i>
                            <span class="nav-text">Kelola akun staff</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-book-open-page-variant"></i>
                            <span class="nav-text">Subtes</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-cog"></i>
                            <span class="nav-text">Pengaturan Akun</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-logout"></i>
                            <span class="nav-text">Log out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

            <!--**********************************
                Content body start
            ***********************************-->
            <div class="content-body">
                <div class="container-fluid">

                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-dark mb-4">Dashboard</h4>
                        </div>
                    </div>

                    <!-- Jumlah Akun -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">Jumlah akun</h5>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="card p-3" style="min-width:220px;">
                                    <div class="d-flex align-items-center">
                                        <div class="p-3 bg-light rounded mr-3" style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                            <i class="mdi mdi-account" style="font-size:26px;color:#2563eb"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted">Staff</div>
                                            <div class="h5">{{ $staffCount ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card p-3" style="min-width:220px;">
                                    <div class="d-flex align-items-center">
                                        <div class="p-3 bg-light rounded mr-3" style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                            <i class="mdi mdi-account-multiple" style="font-size:26px;color:#2563eb"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted">Peserta</div>
                                            <div class="h5">{{ $pesertaCount ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card p-3" style="min-width:220px;">
                                    <div class="d-flex align-items-center">
                                        <div class="p-3 bg-light rounded mr-3" style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                            <i class="mdi mdi-account-key" style="font-size:26px;color:#2563eb"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted">Admin</div>
                                            <div class="h5">{{ $adminCount ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Statistics Chart (restored) -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card p-3">
                                <h5 class="mb-3">User Statistics</h5>
                                <div class="chart-wrap">
                                    <canvas id="userStatsChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics recap (visual like attached image) -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card p-3 stats-recap">
                                <div class="d-flex justify-content-between align-items-start flex-wrap">
                                    <div class="pr-3" style="flex:1 1 60%;">
                                        <h5 class="mb-3">Statistics recap</h5>
                                        <div class="d-flex align-items-center recap-items" style="gap:2.5rem;">
                                            <div class="recap-item d-flex align-items-center">
                                                <div class="recap-icon">
                                                    <i class="mdi mdi-file-document" style="font-size:20px;color:#2563eb"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="small text-muted">Simulasi Ujian Mandiri Polibatam (UMPB)</div>
                                                    <div class="h4 mb-0">{{ $recap1 ?? 0 }}</div>
                                                </div>
                                            </div>

                                            <div class="recap-item d-flex align-items-center">
                                                <div class="recap-icon bank-icon">
                                                    <i class="mdi mdi-bank" style="font-size:20px;color:#10b981"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="small text-muted">Bank Soal UMPB</div>
                                                    <div class="h4 mb-0">{{ $recap2 ?? 0 }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right" style="min-width:180px;">
                                        <select class="form-control month-selector mb-2" style="width:160px;">
                                            <option>Agustus</option>
                                        </select>
                                        <div><a href="#" class="small text-muted">Lihat detail</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Cards (wide) -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card p-3 action-card kelola-subtest">
                                    <div class="d-flex align-items-center">
                                        <div class="action-icon" style="font-size:28px;">
                                            <i class="mdi mdi-clipboard-text" style="font-size:28px;color:#001D39"></i>
                                        </div>
                                        <div class="action-info ml-3">
                                            <h6 class="mb-1">Kelola Subtest</h6>
                                            <p class="small mb-0 text-muted">Tambah, edit atau hapus subtest</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card p-3 action-card kelola-akun">
                                    <div class="d-flex align-items-center">
                                        <div class="action-icon" style="font-size:28px;">
                                            <i class="mdi mdi-account-cog" style="font-size:28px;color:#10b981"></i>
                                        </div>
                                        <div class="action-info ml-3">
                                            <h6 class="mb-1">Kelola Akun</h6>
                                            <p class="small mb-0 text-muted">Lihat daftar akun dan kelola</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card p-3 action-card pengaturan">
                                    <div class="d-flex align-items-center">
                                        <div class="action-icon" style="font-size:28px;">
                                            <i class="mdi mdi-cog-outline" style="font-size:28px;color:#f59e0b"></i>
                                        </div>
                                        <div class="action-info ml-3">
                                            <h6 class="mb-1">Pengaturan</h6>
                                            <p class="small mb-0 text-muted">Ubah profile dan kata sandi</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <!--**********************************
            Content body end
        ***********************************-->
        </div>
    </div>

    <!-- Core JS: jQuery + Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme/vendor initializers -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('js/quixnav-init.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>

    <!-- Chart.js for statistics chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Pass server-side chart data to frontend JS -->
    <script>
        window.dashboardData = {
            labels: @json($chartLabels ?? []),
            data: @json($chartData ?? [])
        };
    </script>

    <!-- App script -->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
