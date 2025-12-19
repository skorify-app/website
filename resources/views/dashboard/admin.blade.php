<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dasbor Admin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/skorify-logo.ico') }}">
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
    <x-nav-header></x-nav-header>

    <x-header></x-header>

    <x-sidebar.admin></x-sidebar.admin>


    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">

            <x-page-title title="Dasbor"></x-page-title>

            <!-- Jumlah Akun -->
            <x-user-count :total_acc="$total_acc"></x-user-count>

            <!-- User Statistics Chart (restored) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card p-3">
                        <h5 class="mb-3">Statistik Pengguna</h5>
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
                                <h5 class="mb-3">Rekap Statistik</h5>
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
                                <div><a href="#" class="small text-muted" data-toggle="modal" data-target="#statisticsDetailModal">Lihat detail</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Cards (wide) -->
            <div class="row">
                <x-bottom-nav
                    title="Kelola Subtes"
                    link="/subtest"
                    icon="mdi-clipboard-text"
                    icon-color="#001D39"
                    description="Tambah, edit atau hapus subtest"
                ></x-bottom-nav>

                <x-bottom-nav
                    title="Kelola Akun Staf"
                    link="/subtest"
                    icon="mdi-account-cog"
                    iconColor="#10b981"
                    description="Lihat daftar akun staf dan kelola"
                ></x-bottom-nav> 
                
                <x-bottom-nav
                    title="Pengaturan"
                    link="/profile"
                    icon="mdi-cog-outline"
                    iconColor="#f59e0b"
                    description="Ubah profil dan kata sandi"
                ></x-bottom-nav>   
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
<!-- Statistics Detail Modal (inline) -->
<div class="modal fade" id="statisticsDetailModal" tabindex="-1" role="dialog" aria-labelledby="statisticsDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statisticsDetailModalLabel">Detail statistics recap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <div class="input-group">
                            <input id="modalSearchInput" type="text" class="form-control" placeholder="Cari subtest disini">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        <select id="modalMonthSelector" class="form-control">
                            <option>Agustus</option>
                        </select>
                    </div>
                </div>

                <div class="row" id="modalSubjectsContainer">
                    <!-- Matematika -->
                    <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="matematika">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="subject-icon mr-3">
                                    <img src="{{ asset('images/subjects/math.png') }}" alt="Matematika" style="width:60px;height:60px;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="mb-0">Matematika</h6>
                                    <small class="text-muted">5 Pengerjaan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bahasa Indonesia -->
                    <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="bahasa-indonesia">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="subject-icon mr-3">
                                    <img src="{{ asset('images/subjects/indo.png') }}" alt="Bahasa Indonesia" style="width:60px;height:60px;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="mb-0">Bahasa Indonesia</h6>
                                    <small class="text-muted">2 Pengerjaan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sains -->
                    <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="sains">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="subject-icon mr-3">
                                    <img src="{{ asset('images/subjects/science.png') }}" alt="Sains" style="width:60px;height:60px;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="mb-0">Sains</h6>
                                    <small class="text-muted">3 Pengerjaan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bahasa Inggris -->
                    <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="bahasa-inggris">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="subject-icon mr-3">
                                    <img src="{{ asset('images/subjects/english.png') }}" alt="Bahasa Inggris" style="width:60px;height:60px;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="mb-0">Bahasa Inggris</h6>
                                    <small class="text-muted">1 Pengerjaan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Computational Thinking -->
                    <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="computational-thinking">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="subject-icon mr-3">
                                    <img src="{{ asset('images/subjects/computational.png') }}" alt="Computational Thinking" style="width:60px;height:60px;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="mb-0">Computational Thinking</h6>
                                    <small class="text-muted">4 Pengerjaan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Subject Detail Modal (inline) -->
<div class="modal fade" id="subjectDetailModal" tabindex="-1" role="dialog" aria-labelledby="subjectDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subjectDetailModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="subjectDetailImageWrap" style="display:inline-block;padding:10px;background:#f6f8fb;border-radius:8px;">
                    <img id="subjectDetailImage" src="" alt="" style="max-width:320px;max-height:320px;object-fit:contain;">
                </div>
                <h5 class="mt-3" id="subjectDetailTitle"></h5>
                <p class="text-muted" id="subjectDetailCount"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    .subject-icon { width:60px; height:60px; display:flex; align-items:center; justify-content:center; background:#f6f8fb; border-radius:8px; }
    .modal .card { box-shadow:none; }
</style>

<script>
    // search inside modal
    $(document).ready(function() {
        $('#modalSearchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#modalSubjectsContainer .subject-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // open subject detail when a subject-card inside the statistics modal is clicked
        $(document).on('click', '#statisticsDetailModal .subject-card', function (e) {
            e.preventDefault();
            var $card = $(this);
            var imgSrc = $card.find('img').attr('src');
            var title = $card.find('h6').first().text() || $card.find('h5').first().text();
            var countText = $card.find('small.text-muted').first().text();

            if (imgSrc) {
                $('#subjectDetailImage').attr('src', imgSrc);
            }
            $('#subjectDetailTitle').text(title);
            $('#subjectDetailCount').text(countText);

            $('#subjectDetailModal').modal('show');
        });
    });
</script>
</body>

</html>
