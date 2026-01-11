<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Dasbor Staff</title>

    <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
    
    <!-- MDI & Bootstrap (Loaded FIRST so valid theme overrides work) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.3.67/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
</head>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <style>
        /* Force hide all grid lines in Chart.js */
        #staffStatsChart {
            background: transparent !important;
        }
        canvas {
            image-rendering: -webkit-optimize-contrast !important;
        }
        /* Recap Stats Custom Styles */
        .stats-recap .card-title {
            font-size: 1.5rem;
          
           
        }
        .stats-recap .card-subtitle {
            font-size: 0.9rem;
            color: #666;
        }
        .stats-recap .stat-widget-two {
            background: #fff;
            border-radius: 10px;
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
            font-size: 13px !important;
        }
    </style>

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


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <x-nav-header></x-nav-header>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <x-header></x-header>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <x-sidebar.staff></x-sidebar.staff>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12" >
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Statistik Pengguna</h5>
                            <select id="yearFilter" class="form-control" style="width: 120px; height: 35px; padding: 5px;">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-8">
                                    <canvas id="staffStatsChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Rekap Statistik Section -->
            <div class="row stats-recap">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title">Rekap Statistik</h5>
                            <div class="offset-1 mt-1 " height="40" style="border-radius: 5px; display: inline-flex; align-items: center; padding: 2px;">
                                <!-- Filter Controls inside user's wrapper style -->
                                <select id="recapFilterType" class="form-control mb-0 recap-input" height="40" style="border-radius: 5px; width:auto; font-size:13px;">
                                    <option value="daily">Harian</option>
                                    <option value="monthly">Bulanan</option>
                                    <option value="yearly" selected>Tahunan</option>
                                </select>
                                
                                <div id="wrapperDaily" style="display:none; margin-left: 5px;">
                                    <input type="text" id="recapFilterDaily" class="form-control mb-0 recap-input" placeholder="Pilih Tanggal" style="height:35px; font-size:13px; background-color: #fff;">
                                </div>
                                
                                <div id="wrapperMonthly" style="display:none; margin-left: 5px;">
                                    <input type="text" id="recapFilterMonthly" class="form-control mb-0 recap-input" placeholder="Pilih Bulan" style="height:35px; font-size:13px; background-color: #fff;">
                                </div>
                                
                                <div id="wrapperYearly" style="margin-left: 5px;">
                                    <select id="recapFilterYearly" class="form-control mb-0 recap-input" style="height:35px; font-size:13px;">
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ini -->
                        <div class="row" style="margin-top: 5vh;">
                                <!-- UMPB (Null Subtest) -->
                                <div class="col-lg-3 col-sm-6 col-10 col-xl-4 offset-xl-1 offset-1">
                                    <div class="card shadow" style="border-radius: 10px;">
                                        <div class="stat-widget-two card-body flex-column flex-md-row d-flex align-items-center p-3">
                                            <div class="stat-content">
                                                <div class="card-title mb-1"><span id="recap1-count">0</span> Pengerjaan</div> <!-- Removed font-size override if user didn't have it -->
                                                <div class="card-subtitle">Simulasi Ujian Mandiri Polibatam (UMPB)</div>
                                            </div>
                                            <div class="card-body p-0 d-flex align-items-center justify-content-center mt-3">
                                                <img src="{{ asset('images/grade.png') }}" width="50" style="background-color:#BDD8E9;" class="img-thumbnail" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Soal (Not Null Subtest) -->
                                <div class="col-lg-3 col-sm-6 col-10 col-xl-4 offset-xl-2 offset-1">
                                    <a href="#" data-toggle="modal" data-target="#statisticsDetailModal">
                                        <div class="card shadow" style="border-radius: 10px;">
                                            <div class="stat-widget-two card-body flex-column flex-md-row d-flex align-items-center p-3">
                                                <div class="stat-content">
                                                    <div class="card-title mb-1"><span id="recap2-count">0</span> Pengerjaan</div>
                                                    <div class="card-subtitle">Bank Soal UMPB</div> <!-- Changed text to match user snippet? "Subtes Ujian Mandiri Polibatam (UMPB)" vs "Bank Soal UMPB". User had "Subtes Ujian Mandiri..." -->
                                                </div>
                                                <div class="card-body p-0 d-flex align-items-center justify-content-center mt-3">
                                                    <img src="{{ asset('images/test.png') }}" width="50" style="background-color:#BDD8E9;" class="img-thumbnail" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Statistics Modal -->
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
                                            <button class="btn btn-secondary" type="button"><i class="bi bi-search"></i></button>
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
                                <!-- Dynamic Content Loaded via AJAX -->
                                <div class="col-12 text-center py-5">
                                    <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center justify-content-center">
                <div class="col-lg-3 col-sm-6 col-xl-4">
                    <a href="/subtest"> <div class="card shadow"style="border-radius: 10px;">
                            <div class="stat-widget-two card-body d-flex align-items-center p-3">
                                <div class="stat-content">
                                    <div class="card-title mb-1">Kelola Subtes</div>
                                    <div class="card-subtitle"> Tambah, edit atau hapus</div>
                                </div>

                                <div class=" card-body p-0 d-flex align-items-center justify-content-center">

                                    <i class="bi bi-pencil-square"  style="font-size: 2.9rem;color:#001D39;"></i>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
             
                <div class="col-lg-3 col-sm-6 col-xl-4">
                    <a href=""><div class="card shadow"style="border-radius: 10px;">
                            <div class="stat-widget-two card-body  d-flex align-items-center p-3">
                                <div class="stat-content  ">
                                    <div class="card-title mb-1">Pengaturan</div>
                                    <div class="card-subtitle"> Ubah profile dan kata sandi</div>
                                </div>

                                <div class=" card-body p-0 d-flex align-items-center justify-content-center " >
                                    <i class="bi bi-gear-wide-connected" style="font-size: 2.9rem;color: #f59e0b;"></i>

                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- /# column -->

                </div>
            </div>







        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright © Developed by <a href="#" target="_blank">PBL-TRPL308</a> 2025</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->

    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('js/quixnav-init.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>


<!-- Vectormap -->
<script src="{{asset('vendor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendor/morris/morris.min.js')}}"></script>


<script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
<script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>

<script src="{{asset('vendor/gaugeJS/dist/gauge.min.js')}}"></script>

<!--  flot-chart js -->
<script src="{{asset('vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.resize.js')}}"></script>

<!-- Owl Carousel -->
<script src="{{asset('vendor/owl-carousel/js/owl.carousel.min.js')}}"></script>

<!-- Counter Up -->
<script src="{{asset('vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
<script src="{{asset('vendor/jqvmap/js/jquery.vmap.usa.js')}}"></script>
<script src="{{asset('vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>


<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('js/quixnav-init.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>

<!-- Pass dashboard data to JavaScript -->
<script>
    window.dashboardData = {
        monthlyStatsLabels: @json($monthlyStatsLabels ?? []),
        monthlyStatsData: @json($monthlyStatsData ?? [])
    };
</script>

<script src="{{asset('js/dashboard-1.js')}}?v={{ time() }}"></script>
<script src="{{asset('js/dashboard-3.js')}}"></script>






<script src="{{asset('vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('vendor/flot-spline/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('js/plugins-init/flot-init.js')}}"></script>



<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('js/quixnav-init.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>

<!-- Chart Morris plugin files -->
<script src="{{asset('vendor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendor/morris/morris.min.js')}}"></script>
<script src="{{asset('js/plugins-init/morris-init.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        /* =========================================
         * RECAP STATS FILTER LOGIC (STAFF DASHBOARD)
         * ========================================= */
        const filterType = document.getElementById('recapFilterType');
        if (!filterType) return; // Guard clause

        const wrappers = {
            daily: document.getElementById('wrapperDaily'),
            monthly: document.getElementById('wrapperMonthly'),
            yearly: document.getElementById('wrapperYearly')
        };
        const inputs = {
            daily: document.getElementById('recapFilterDaily'),
            monthly: document.getElementById('recapFilterMonthly'),
            yearly: document.getElementById('recapFilterYearly')
        };

        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const dd = String(now.getDate()).padStart(2, '0');

        // Initialize Defaults
        inputs.daily.value = `${yyyy}-${mm}-${dd}`;
        // Monthly value is managed by Flatpickr defaultDate

        // Initialize Flatpickr Daily (Indonesia)
        flatpickr("#recapFilterDaily", {
            locale: "id",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            defaultDate: `${yyyy}-${mm}-${dd}`,
            disableMobile: "true",
            onChange: function(selectedDates, dateStr, instance) {
                fetchRecapData();
            }
        });

        // Initialize Flatpickr Monthly (Indonesia)
        flatpickr("#recapFilterMonthly", {
            locale: "id",
            plugins: [
                new monthSelectPlugin({
                    shorthand: false, // defaults to false, but specifies full name
                    dateFormat: "Y-m",
                    altFormat: "F Y",
                    theme: "light"
                })
            ],
            defaultDate: `${yyyy}-${mm}`,
            disableMobile: "true",
            onChange: function(selectedDates, dateStr, instance) {
                fetchRecapData();
            }
        });

        function updateRecapVisibility() {
            const type = filterType.value;
            
            // Hide all wrappers using style display (to coexist with Flatpickr wrappers)
            Object.values(wrappers).forEach(el => { if(el) el.style.display = 'none'; });
            
            // Show selected wrapper
            if (wrappers[type]) {
                wrappers[type].style.display = 'block';
            }
            
            fetchRecapData();
        }

        filterType.addEventListener('change', updateRecapVisibility);
        
        // Add change listeners for native inputs (Yearly)
        if (inputs.yearly) {
            inputs.yearly.addEventListener('change', fetchRecapData);
        }

        function fetchRecapData() {
            const type = filterType.value;
            let value = '';
            
            if (inputs[type]) {
                value = inputs[type].value;
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
                    
                    // Update Modal Content Trigger if needed (Modal fetches its own data mainly)
                },
                error: function(xhr) {
                    console.error("Failed to fetch recap stats:", xhr);
                    $('#recap1-count, #recap2-count').css('opacity', '1');
                }
            });
        }

        // Trigger initial state
        updateRecapVisibility();

        /* =========================================
         * MODAL FILTER LOGIC (STAFF DASHBOARD)
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
            const dashType = filterType.value; // Get value from native element
            modalFilterType.val(dashType);
            updateModalVisibility();
        });

        /* =========================================
         * MODAL SEARCH LOGIC
         * ========================================= */
        const searchInput = $('#modalSearchInput');
        
        function performSearch() {
            const value = searchInput.val().toLowerCase();
            const cards = $("#modalSubjectsContainer .subject-card");
            
            cards.filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            // Check if any cards are visible
            const visibleCount = cards.filter(':visible').length;
            const noResultsMsg = $('#no-search-results');
            
            if (visibleCount === 0) {
                if (noResultsMsg.length === 0) {
                    $("#modalSubjectsContainer").append('<div id="no-search-results" class="col-12 text-center text-muted mt-5"><h5>Subtes tidak ditemukan</h5></div>');
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
    });
</script>
</body>

</html>
