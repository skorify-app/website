<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pengerjaan Soal</title>
    <link rel="icon" href="{{ asset('images/skorify-logo.ico') }}">

    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">

    <style>
        body {
            background: #f5f7fb;
            color: #000;
        }

        /* ===== WARNA UTAMA ===== */
        :root {
            --dark-blue: #001D39;
            --yellow: #ffc107;
            --green: #198754;
        }

        /* ===== TIMER ===== */
        .time-hidden #timeBox {
            display: none;
        }

        /* ===== SOAL ===== */
        .soal-text {
            font-weight: 600;
            color: #000;
        }

        /* ===== NAVIGASI SOAL ===== */
        .nav-box {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
        }

        .soal-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }

        .soal-btn {
            height: 42px;
            border: 1.5px solid #000;
            background: #fff;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        .soal-btn.active {
            background: var(--dark-blue);
            color: #fff;
        }

        .soal-btn.answered {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
        }

        .soal-btn.ragu {
            background: var(--yellow);
            color: #000;
            border-color: var(--yellow);
        }

        /* ===== BUTTON BAWAH ===== */
        .btn-prev,
        .btn-next {
            background: var(--dark-blue);
            color: #fff;
            font-weight: 600;
        }

        .btn-prev:hover,
        .btn-next:hover {
            background: #000f1e;
            color: #fff;
        }

        #btnRagu {
            background-color: var(--yellow);
            color: #fff;
            font-weight: 600;
        }

        #btnRagu:hover {
            background-color: #e0a800;
            color: #fff;
        }

        /* ===== BADGE SOAL NO ===== */
        .badge-soal {
            background: var(--dark-blue);
            color: #fff;
            padding: 10px 14px;
            font-size: 15px;
            border-radius: 6px;
        }

        /* ===== NAVIGASI HIDE / SHOW ===== */
        /* ===== WRAPPER ROW ===== */
        .exam-row {
            display: flex;
            width: 100%;
            align-items: flex-start;
            gap: 24px;              /* ⬅️ JARAK SOAL ↔ NAV */
            transition: gap 0.35s ease;
        }

        /* ===== KONTEN SOAL (KIRI) ===== */
        .exam-content {
            flex: 1;
            transition: width 0.35s ease;
        }


        /* ===== NAVIGASI KANAN ===== */
        #navWrapper {
            width: 320px;
            transition: width 0.35s ease, transform 0.35s ease;
            position: relative;
            flex-shrink: 0;
        }

        /* NAV DIGESER KE KANAN */
        .nav-hidden #navWrapper {
            width: 40px;                 /* ⬅️ kunci utama */
            transform: translateX(0);    /* jangan keluar layar */
        }

        /* SOAL MELEBAR */
        .nav-hidden .exam-content {
            width: 100%;
        }

        /* GRID HILANG SAAT DITUTUP */
        .nav-hidden #navSoal .soal-grid {
            display: none;
        }

        /* ROTATE ICON */
        .nav-hidden #toggleNav i {
            transform: rotate(180deg);
        }

        /* ===== TOMBOL PREV & NEXT ===== */
        #prevSoal,
        #nextSoal {
            background-color: #001D39 !important;
            border-color: #001D39 !important;
            color: #fff !important;
            font-weight: 600;
        }

        #prevSoal:hover,
        #nextSoal:hover {
            background-color: #000f1e !important;
            border-color: #000f1e !important;
        }

        /* ===== NOMOR SOAL ===== */
        #nomorSoal {
            background-color: #001D39 !important;
            color: #fff !important;
            font-weight: 600;
        }

        /* ===== OVERRIDE ROW JADI FLEX ===== */
        .exam-row {
            display: flex;
            width: 100%;
        }
    </style>
    <style>
        #toggleTime {
            margin-left: 12px !important;
        }

        #toggleTime {
            background-color: #001D39 !important;
            border: none !important;
            color: #fff !important;
        }

        #toggleTime:hover {
            background-color: #000f1e !important;
            border: none !important;
            color: #fff !important;
        }

        #toggleTime:focus,
        #toggleTime:active {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>

</head>

<body>

<!-- PRELOADER -->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">

    <x-nav-header />
    <x-header />

    @if(Auth::user()->role === 'ADMIN')
        <x-sidebar.admin />
    @else
        <x-sidebar.staff />
    @endif

    <!-- CONTENT -->
    <div class="content-body">
        <div class="container-fluid">

            <!-- TIMER -->
            <div class="mb-3 d-flex align-items-center">
                <span class="border px-3 py-2 rounded bg-white fw-semibold me-3" id="timeBox">
                    Waktu tersisa <strong id="timer">01:00:00</strong>
                </span>

                <button class="btn btn-sm btn-outline-secondary fw-semibold" id="toggleTime">
                    Sembunyikan
                </button>
            </div>

            <div class="exam-row">

                <!-- ===== KIRI ===== -->
                <div class="exam-content">

                    <div class="mb-2">
                        <span>Soal No</span>
                        <span class="badge bg-dark px-3 py-2" id="nomorSoal">1</span>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">

                            <p class="fw-semibold">
                                Sebuah sekolah menyelenggarakan ujian berbasis komputer (CBT) yang diikuti oleh seluruh siswa kelas IX dengan durasi waktu 120 menit dan jumlah soal sebanyak 40 butir pilihan ganda tanpa pengurangan nilai untuk jawaban yang salah, 
                                seorang siswa bernama Andi mengerjakan 20 soal pertama dalam waktu 45 menit dan 10 soal berikutnya dalam waktu 30 menit, 
                                kemudian sisa waktu yang ada digunakan untuk mengerjakan soal terakhir sekaligus meninjau kembali jawabannya, 
                                jika dari seluruh soal tersebut Andi berhasil menjawab 32 soal dengan benar dan nilai akhir ujian dihitung berdasarkan perbandingan jumlah jawaban benar terhadap jumlah soal kemudian dikalikan dengan nilai maksimum 100, 
                                maka nilai akhir yang diperoleh Andi adalah …
                            </p>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban" value="A">
                                <label class="form-check-label">70</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban" value="B">
                                <label class="form-check-label">75</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban" value="C">
                                <label class="form-check-label">80</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban" value="D">
                                <label class="form-check-label">85</label>
                            </div>

                        </div>
                    </div>

                    <!-- NAV BAWAH -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-dark" id="prevSoal">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>

                        <button class="btn btn-warning fw-semibold" id="btnRagu">
                            <i class="bi bi-bookmark-fill"></i> Ragu-ragu
                        </button>

                        <button class="btn btn-dark" id="nextSoal">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- ===== KANAN (NAVIGASI) ===== -->
                <div id="navWrapper">
                    <div class="nav-box position-relative" id="navSoal">

                    <!-- TOGGLE PANAH -->
                    <button id="toggleNav"
                        class="btn btn-sm btn-dark position-absolute"
                        style="top:10px; left:-15px; z-index:1;">
                        <i class="bi bi-chevron-right"></i>
                    </button>

                    <!-- GRID SOAL -->
                    <div class="soal-grid mt-4">
                        @for($i=1;$i<=30;$i++)
                            <button class="soal-btn" data-soal="{{ $i }}">{{ $i }}</button>
                        @endfor
                    </div>

                </div>
        

            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('js/quixnav-init.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>
    /* ===== KONFIGURASI ===== */
    const TOTAL_SOAL = 30;

    let currentSoal = 1;
    let jawaban = {};
    let ragu = new Set();

    const soalBtns = document.querySelectorAll('.soal-btn');
    const btnPrev = document.getElementById('prevSoal');
    const btnNext = document.getElementById('nextSoal');

    /* ===== UPDATE NAV BUTTON ===== */
    function updateNavButtons() {

        // Soal pertama → sembunyikan Kembali (tanpa rusak layout)
        if (currentSoal === 1) {
            btnPrev.style.visibility = 'hidden';
        } else {
            btnPrev.style.visibility = 'visible';
        }

        // Soal terakhir → ganti jadi Selesai
        if (currentSoal === TOTAL_SOAL) {
            btnNext.innerHTML = 'Selesai';
            btnNext.classList.remove('btn-dark');
            btnNext.classList.add('btn-success');
        } else {
            btnNext.innerHTML = 'Selanjutnya <i class="bi bi-arrow-right"></i>';
            btnNext.classList.remove('btn-success');
            btnNext.classList.add('btn-dark');
        }
    }

    /* ===== SET SOAL AKTIF ===== */
    function setActiveSoal(no) {
        currentSoal = Number(no);
        document.getElementById('nomorSoal').innerText = currentSoal;

        // reset active
        soalBtns.forEach(b => b.classList.remove('active'));

        const btn = document.querySelector(`[data-soal="${currentSoal}"]`);

        if (!btn.classList.contains('answered') && !btn.classList.contains('ragu')) {
            btn.classList.add('active');
        }

        // ============================
        // 🔥 RESET RADIO (INI KUNCI)
        // ============================
        document.querySelectorAll('input[name="jawaban"]').forEach(r => {
            r.checked = false;
        });

        // ============================
        // 🔁 RESTORE JAWABAN JIKA ADA
        // ============================
        if (jawaban[currentSoal]) {
            const selected = document.querySelector(
                `input[name="jawaban"][value="${jawaban[currentSoal]}"]`
            );
            if (selected) selected.checked = true;
        }

        updateNavButtons();
    }


    /* ===== NAVIGASI SOAL ===== */
    soalBtns.forEach(btn => {
        btn.onclick = () => setActiveSoal(btn.dataset.soal);
    });

    btnNext.onclick = () => {
        if (currentSoal === TOTAL_SOAL) {

            const yakin = confirm(
                'Apakah Anda yakin ingin mengakhiri ujian?'
            );

            if (yakin) {
                // 👉 GANTI URL SESUAI BERANDA KAMU
                window.location.href = '/subtest';
            }

        } else {
            setActiveSoal(currentSoal + 1);
        }
    };

    btnPrev.onclick = () => {
        if (currentSoal > 1) {
            setActiveSoal(currentSoal - 1);
        }
    };

    /* ===== JAWABAN ===== */
    document.querySelectorAll('input[name="jawaban"]').forEach(r => {
            r.onchange = () => {
                jawaban[currentSoal] = r.value;
                const btn = document.querySelector(
                    `[data-soal="${currentSoal}"]`
                );
                btn.classList.add('answered');
                btn.classList.remove('active'); // optional
            };
        });

        document.getElementById('btnRagu').onclick = () => {
        const btn = document.querySelector(
            `[data-soal="${currentSoal}"]`
        );

        // jika sedang ragu → kembalikan ke status sebelumnya
        if (btn.classList.contains('ragu')) {
            btn.classList.remove('ragu');

            if (btn.classList.contains('answered')) {
                // soal sudah dijawab → hijau
                btn.classList.add('answered');
            } else {
                // soal belum dijawab → biru
                btn.classList.add('active');
            }
        } 
        // jika belum ragu → jadikan ragu
        else {
            btn.classList.remove('active');
            btn.classList.add('ragu');
        }
    };



    /* ===== TIMER HIDE ===== */
    let timeHidden = false;
    document.getElementById('toggleTime').onclick = function () {
        timeHidden = !timeHidden;

        document.body.classList.toggle('time-hidden', timeHidden);
        this.textContent = timeHidden ? 'Lihat' : 'Sembunyikan';
    };

    /* ===== NAV KANAN TOGGLE ===== */
    let navHidden = false;
    const toggleNav = document.getElementById('toggleNav');

    toggleNav.onclick = function () {
        navHidden = !navHidden;
        document.body.classList.toggle('nav-hidden', navHidden);
        this.innerHTML = navHidden
            ? '<i class="bi bi-chevron-left"></i>'
            : '<i class="bi bi-chevron-right"></i>';
    };

    /* ===== INIT ===== */
    setActiveSoal(1);

    // ⏱️ TIMER 1 JAM (60 MENIT)
    let totalSeconds = 60 * 60; // 1 jam

    const timerEl = document.getElementById('timer');

    function formatTime(seconds) {
        const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
        const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
        const s = String(seconds % 60).padStart(2, '0');
        return `${h}:${m}:${s}`;
    }

    function startTimer() {
        const interval = setInterval(() => {
            totalSeconds--;

            timerEl.textContent = formatTime(totalSeconds);

            // ⛔ WAKTU HABIS
            if (totalSeconds <= 0) {
                clearInterval(interval);
                alert('Waktu ujian telah habis!');
                window.location.href = '/subtest'; // ganti jika perlu
            }
        }, 1000);
    }

    // 🚀 MULAI TIMER
    startTimer();
</script>
</body>
</html>
