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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <!-- Custom Styles for Recap -->
    <style>
        .recap-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background-color: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .recap-icon.bank-icon {
            background-color: #d1fae5;
        }
        .stats-recap .recap-item {
            min-width: 200px;
        }
        /* Force white background for Flatpickr readonly inputs */
        .recap-input,
        .recap-input[readonly],
        .flatpickr-input[readonly] {
            background-color: #ffffff !important;
            opacity: 1 !important; /* Ensure no opacity reduction */
            font-size: 14px !important;
        }
    </style>
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Statistik Pengguna</h5>
                            <div class="form-group mb-0">
                                <select id="yearFilter" class="form-control form-control-sm" style="width: auto; min-width: 100px;">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="chart-wrap">
                            <canvas id="userStatsChart" height="200"></canvas>
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
                                            <div class="h4 mb-0" id="recap1-count">{{ $recap1 ?? 0 }}</div>
                                        </div>
                                    </div>

                                    <div class="recap-item d-flex align-items-center">
                                        <div class="recap-icon bank-icon">
                                            <i class="mdi mdi-bank" style="font-size:20px;color:#10b981"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="small text-muted">Bank Soal UMPB</div>
                                            <div class="h4 mb-0" id="recap2-count">{{ $recap2 ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right" style="min-width:220px;">
                                <div class="d-flex align-items-center justify-content-end" style="gap:5px;">
                                    <select id="recapFilterType" class="form-control mb-0" style="width:100px; height:35px; font-size:13px;">
                                        <option value="daily">Harian</option>
                                        <option value="monthly">Bulanan</option>
                                        <option value="yearly" selected>Tahunan</option>
                                    </select>
                                    
                                    <!-- Inputs for each type -->
                                    <div id="wrapperDaily" style="display:none;">
                                        <input type="text" id="recapFilterDaily" class="form-control mb-0 recap-input" placeholder="Pilih Tanggal" style="width:130px; height:35px; font-size:13px; background-color: #fff;">
                                    </div>
                                    <div id="wrapperMonthly" style="display:none;">
                                        <input type="text" id="recapFilterMonthly" class="form-control mb-0 recap-input" placeholder="Pilih Bulan" style="width:130px; height:35px; font-size:13px; background-color: #fff;">
                                    </div>
                                    <div id="wrapperYearly">
                                        <select id="recapFilterYearly" class="form-control mb-0 recap-input" style="width:100px; height:35px; font-size:13px;">
                                            @foreach($availableYears as $year)
                                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-1"><a href="#" class="small text-muted" data-toggle="modal" data-target="#statisticsDetailModal">Lihat detail</a></div>
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
                    description="Tambah, edit atau hapus subtes"
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
                    description="Ubah nama, email dan kata sandi"
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
        data: @json($chartData ?? []),
        monthlyStatsLabels: @json($monthlyStatsLabels ?? []),
        monthlyStatsLabelsWithYear: @json($monthlyStatsLabelsWithYear ?? []),
        monthlyStatsData: @json($monthlyStatsData ?? [])
    };
</script>

<!-- App script -->
<script src="{{ asset('js/admin.js') }}"></script>
<!-- Statistics Detail Modal (inline) -->
<div class="modal fade" id="statisticsDetailModal" tabindex="-1" role="dialog" aria-labelledby="statisticsDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statisticsDetailModalLabel">Detail Rekap Statistik</h5>
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
                        <div class="d-flex align-items-center justify-content-end" style="gap:5px;">
                            <select id="modalFilterType" class="form-control mb-0" style="width:100px; height:35px; font-size:13px;">
                                <option value="daily">Harian</option>
                                <option value="monthly">Bulanan</option>
                                <option value="yearly" selected>Tahunan</option>
                            </select>
                            
                            <!-- Inputs for each type in Modal -->
                            <div id="wrapperModalDaily" style="display:none;">
                                <input type="text" id="modalFilterDaily" class="form-control mb-0 recap-input" placeholder="Pilih Tanggal" style="width:130px; height:35px; font-size:13px; background-color: #fff;">
                            </div>
                            <div id="wrapperModalMonthly" style="display:none;">
                                <input type="text" id="modalFilterMonthly" class="form-control mb-0 recap-input" placeholder="Pilih Bulan" style="width:130px; height:35px; font-size:13px; background-color: #fff;">
                            </div>
                            <div id="wrapperModalYearly">
                                <select id="modalFilterYearly" class="form-control mb-0 recap-input" style="width:100px; height:35px; font-size:13px;">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
        // search inside modal with "No Results" handling
    $(document).ready(function() {
        const searchInput = $('#modalSearchInput');

        function performSearch() {
            var value = searchInput.val().toLowerCase();
            var cards = $('#modalSubjectsContainer .subject-card');
            
            cards.filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            // Check if any cards are visible
            var visibleCount = cards.filter(':visible').length;
            var noResultsMsg = $('#no-search-results-admin');
            
            if (visibleCount === 0) {
                if (noResultsMsg.length === 0) {
                    $("#modalSubjectsContainer").append('<div id="no-search-results-admin" class="col-12 text-center text-muted mt-5"><h5>Subtes tidak ditemukan</h5></div>');
                } else {
                    noResultsMsg.show();
                }
            } else {
                if (noResultsMsg.length > 0) {
                    noResultsMsg.hide();
                }
            }
        }

        searchInput.on('keyup', performSearch);
        
        // Search button click
        $('.input-group-append button').on('click', performSearch);


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
    
    // --- RECAP STATISTICS FILTER ---
    $(document).ready(function() {
        const recapFilterType = $('#recapFilterType');
        const recapWrappers = {
            daily: $('#wrapperDaily'),
            monthly: $('#wrapperMonthly'),
            yearly: $('#wrapperYearly')
        };
        const recapInputs = {
            daily: $('#recapFilterDaily'),
            monthly: $('#recapFilterMonthly'),
            yearly: $('#recapFilterYearly')
        };
        
        // Initialize Default Dates if empty
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');

        // Initialize Flatpickr for Daily
        const dailyPicker = flatpickr("#recapFilterDaily", {
            locale: "id",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            defaultDate: `${yyyy}-${mm}-${dd}`,
            onChange: function(selectedDates, dateStr, instance) {
                fetchRecapData(); // Trigger fetch immediately on change
            }
        });

        // Initialize Flatpickr for Monthly
        const monthlyPicker = flatpickr("#recapFilterMonthly", {
            locale: "id",
            plugins: [
                new monthSelectPlugin({
                    shorthand: false, // Use full month names (Januari, etc.)
                    dateFormat: "Y-m", // Value sent to server
                    altFormat: "F Y", // Displayed value (Januari 2026)
                    theme: "light"
                })
            ],
            defaultDate: `${yyyy}-${mm}`,
            onChange: function(selectedDates, dateStr, instance) {
                fetchRecapData();
            }
        });

        // if (!recapInputs.daily.val()) recapInputs.daily.val(`${yyyy}-${mm}-${dd}`); // Handled by defaultDate
        // if (!recapInputs.monthly.val()) recapInputs.monthly.val(`${yyyy}-${mm}`); // Handled by defaultDate

        function updateRecapVisibility() {
            const type = recapFilterType.val();
            // Hide all wrappers first
            Object.values(recapWrappers).forEach(wrapper => wrapper.hide());
            // Show selected wrapper
            if (recapWrappers[type]) recapWrappers[type].show();
            
            fetchRecapData();
        }

        function fetchRecapData() {
            const type = recapFilterType.val();
            let value = '';
            
            if (recapInputs[type]) {
                value = recapInputs[type].val();
            }

            if (!value) return;

            // Show loading state (optional)
            $('#recap1-count, #recap2-count').css('opacity', '0.5');

            $.ajax({
                url: '/admin/recap-stats',
                method: 'GET',
                data: { type: type, value: value },
                success: function(response) {
                    $('#recap1-count').text(response.recap1).css('opacity', '1');
                    $('#recap2-count').text(response.recap2).css('opacity', '1');
                    
                    // --- UPDATE MODAL CONTENT ---
                    if (response.details) {
                        const container = $('#modalSubjectsContainer');
                        container.empty();
                        
                        // Image mapping fallback (lower case keys for safety)
                        const imageMap = {
                            'matematika': 'math.png',
                            'mtk': 'math.png',
                            'bahasa indonesia': 'indo.png',
                            'sains': 'science.png',
                            'bahasa inggris': 'english.png',
                            'computational thinking': 'computational.png'
                        };

                        response.details.forEach(detail => {
                            let imgPath;
                            
                            if (detail.subtest_image_name) {
                                // Uploaded icon (stored in public/images/subtest/)
                                imgPath = `/images/subtest/${detail.subtest_image_name}`;
                            } else {
                                // Fallback/Default icon (stored in public/images/subjects/)
                                const lowerName = (detail.subtest_name || '').toLowerCase();
                                const mapName = imageMap[lowerName] || 'math.png'; 
                                imgPath = `/images/subjects/${mapName}`;
                            }
                            
                            const cardHtml = `
                                <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="${detail.subtest_name}">
                                    <div class="card h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="subject-icon mr-3">
                                                <img src="${imgPath}" alt="${detail.subtest_name}" style="width:60px;height:60px;object-fit:contain;" onerror="this.src='/images/subjects/math.png'">
                                            </div>
                                            <div>
                                                <h6 class="mb-0">${detail.subtest_name}</h6>
                                                <small class="text-muted">${detail.count} Pengerjaan</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            container.append(cardHtml);
                        });
                    }
                },
                error: function(xhr) {
                    console.error("Failed to fetch recap stats:", xhr);
                    $('#recap1-count, #recap2-count').css('opacity', '1');
                }
            });
        }

        recapFilterType.on('change', updateRecapVisibility);
        
        Object.values(recapInputs).forEach(input => {
            input.on('change', fetchRecapData);
        });

        // Trigger initial state for Recap Widget
        updateRecapVisibility();

        /* =========================================
         * MODAL FILTER LOGIC (INDEPENDENT)
         * ========================================= */
        const modalFilterType = $('#modalFilterType');
        const modalWrappers = {
            daily: $('#wrapperModalDaily'),
            monthly: $('#wrapperModalMonthly'),
            yearly: $('#wrapperModalYearly')
        };
        const modalInputs = {
            daily: $('#modalFilterDaily'),
            monthly: $('#modalFilterMonthly'),
            yearly: $('#modalFilterYearly')
        };

        // Initialize Modal Defaults
        if (!modalInputs.daily.val()) modalInputs.daily.val(`${yyyy}-${mm}-${dd}`);
        // Monthly managed by Flatpickr defaultDate

        // Initialize Flatpickr for Modal Daily
        flatpickr("#modalFilterDaily", {
            locale: "id",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            defaultDate: `${yyyy}-${mm}-${dd}`,
            onChange: function(selectedDates, dateStr, instance) {
                fetchModalData();
            }
        });

        // Initialize Flatpickr for Modal Monthly
        flatpickr("#modalFilterMonthly", {
            locale: "id",
            plugins: [
                new monthSelectPlugin({
                    shorthand: false,
                    dateFormat: "Y-m",
                    altFormat: "F Y",
                    theme: "light"
                })
            ],
            defaultDate: `${yyyy}-${mm}`,
            onChange: function(selectedDates, dateStr, instance) {
                fetchModalData();
            }
        });

        function updateModalVisibility() {
            const type = modalFilterType.val();
            Object.values(modalWrappers).forEach(wrapper => wrapper.hide());
            if (modalWrappers[type]) modalWrappers[type].show();
            fetchModalData();
        }

        function fetchModalData() {
            const type = modalFilterType.val();
            let value = '';
            if (modalInputs[type]) value = modalInputs[type].val();
            if (!value) return;

            // Loading state for modal container
            const container = $('#modalSubjectsContainer');
            container.css('opacity', '0.5');

            $.ajax({
                url: '/admin/recap-stats', // Re-use same endpoint
                method: 'GET',
                data: { type: type, value: value },
                success: function(response) {
                    container.css('opacity', '1');
                    container.empty();
                    
                    if (response.details && response.details.length > 0) {
                        const imageMap = {
                            'matematika': 'math.png',
                            'mtk': 'math.png',
                            'bahasa indonesia': 'indo.png',
                            'sains': 'science.png',
                            'bahasa inggris': 'english.png',
                            'computational thinking': 'computational.png'
                        };

                        response.details.forEach(detail => {
                            let imgPath;
                            if (detail.subtest_image_name) {
                                imgPath = `/images/subtest/${detail.subtest_image_name}`;
                            } else {
                                const lowerName = (detail.subtest_name || '').toLowerCase();
                                const mapName = imageMap[lowerName] || 'math.png'; 
                                imgPath = `/images/subjects/${mapName}`;
                            }
                            
                            const cardHtml = `
                                <div class="col-md-6 col-lg-4 mb-4 subject-card" data-subject="${detail.subtest_name}">
                                    <div class="card h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="subject-icon mr-3">
                                                <img src="${imgPath}" alt="${detail.subtest_name}" style="width:60px;height:60px;object-fit:contain;" onerror="this.src='/images/subjects/math.png'">
                                            </div>
                                            <div>
                                                <h6 class="mb-0">${detail.subtest_name}</h6>
                                                <small class="text-muted">${detail.count} Pengerjaan</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            container.append(cardHtml);
                        });
                    } else {
                        container.html('<div class="col-12 text-center text-muted">Tidak ada data untuk periode ini</div>');
                    }
                },
                error: function(xhr) {
                    console.error("Failed to fetch modal stats:", xhr);
                    container.css('opacity', '1');
                }
            });
        }

        modalFilterType.on('change', updateModalVisibility);
        Object.values(modalInputs).forEach(input => {
            input.on('change', fetchModalData);
        });
        
        // Sync Modal filters with Dashboard filters when Modal Opens
        $('#statisticsDetailModal').on('show.bs.modal', function () {
            // Option 1: Copy values from dashboard to modal
            const dashType = $('#recapFilterType').val();
            modalFilterType.val(dashType);
            
            // Trigger visibility update which also fetches data
            updateModalVisibility();
            
            // Sync values (complex due to Flatpickr instances, but basic value copy might work)
            // Ideally we just let it fetch default or current modal state.
            // Let's just trigger updateModalVisibility() to load data based on current modal inputs.
        });
    });
</script>
</body>

</html>
