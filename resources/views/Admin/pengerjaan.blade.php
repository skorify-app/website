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
    /* =========================
    GLOBAL
    ========================= */
    body {
        background: #f5f7fb;
        color: #000;
    }

    :root {
        --dark-blue: #001D39;
        --yellow: #ffc107;
        --green: #198754;
    }

    /* =========================
    TIMER
    ========================= */
    .time-hidden #timeBox {
        display: none;
    }

    /* =========================
    SOAL
    ========================= */
    .soal-text {
        font-weight: 600;
        color: #000;
    }

    .soal-wrapper {
        transition: all 0.35s ease;
    }

    /* =========================
    NAVIGASI KANAN
    ========================= */
    #navWrapper {
        position: relative;
        transition: all 0.35s ease;
    }

    .nav-box {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
    }

    /* GRID NOMOR SOAL */
    .soal-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    /* BUTTON NOMOR */
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
        color: #fff;
        border-color: var(--yellow);
    }

    /* =========================
    TOGGLE NAVIGASI
    ========================= */
    .nav-toggle {
        position: absolute;
        top: -10px;              /* ⬅️ kunci jaraknya */
        left: -18px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        z-index: 1;
    }

    .nav-toggle i {
        transition: transform 0.35s ease;
    }

    /* =========================
    ANIMASI HIDE / SHOW NAV
    ========================= */
    #navSoal {
        transition: transform 0.35s ease, opacity 0.3s ease;
    }

    /* NAV DISHIDE (FIX BOOTSTRAP GRID) */
    .content-body.nav-hidden #navWrapper {
        max-width: 0 !important;
        flex: 0 0 0 !important;
        padding: 0 !important;
        overflow: visible;
    }

    .content-body.nav-hidden #navSoal {
        transform: translateX(100%);
        opacity: 0;
        pointer-events: none;
    }

    /* SOAL MELEBAR */
    .content-body.nav-hidden .soal-wrapper {
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    /* =========================
    BUTTON BAWAH
    ========================= */
    #prevSoal,
    #nextSoal {
        background-color: var(--dark-blue) !important;
        border-color: var(--dark-blue) !important;
        color: #fff !important;
        font-weight: 600;
    }

    #prevSoal:hover,
    #nextSoal:hover {
        background-color: #000f1e !important;
        border-color: #000f1e !important;
    }

    #btnRagu {
        background: var(--yellow);
        color: #fff;
        font-weight: 600;
    }

    /* =========================
    BADGE NOMOR SOAL
    ========================= */
    #nomorSoal {
        background-color: var(--dark-blue) !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* =========================
    RESPONSIVE (MOBILE)
    ========================= */
    @media (max-width: 992px) {

        #navWrapper {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: 260px;
            z-index: 9998;
            background: #fff;
        }

        .content-body.nav-hidden #navWrapper {
            transform: translateX(100%);
        }

        .nav-toggle {
            left: -40px;
        }
    }

    .nav-box {
        background: #fff;
        border-radius: 10px;
        padding: 32px 15px 15px; /* normal saja */
    }

    .gambar-soal {
        margin-top: 12px;     /* dekat ke teks soal */
        margin-bottom: 28px;  /* JAUH dari jawaban */
    }

    .gambar-soal img {
        max-width: 100%;   /* ⬅️ lebih besar */
        width: 100%;        /* responsif */
        height: auto;
        display: block;
    }

    /* =========================
    GAMBAR SOAL
    ========================= */
    .gambar-soal {
        text-align: center;
        margin: 16px 0 24px;
    }

    .gambar-soal img {
        max-width: 100%;      /* tidak keluar container */
        width: auto;          /* jangan dipaksa */
        max-height: 280px;    /* BATAS TINGGI */
        object-fit: contain;  /* gambar tidak terpotong */
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
            <div class="mb-3 d-flex align-items-center gap-2">
                <span class="border px-3 py-2 rounded bg-white fw-semibold" id="timeBox">
                    @php
                        $ds = $duration_seconds ?? 30 * 60;
                        $h = intdiv($ds, 3600);
                        $m = intdiv($ds % 3600, 60);
                        $s = $ds % 60;
                    @endphp
                    Waktu tersisa <strong id="timer">{{ sprintf('%02d:%02d:%02d', $h, $m, $s) }}</strong>
                </span>
            </div>

            <div class="row position-relative">

                <!-- ===== KIRI ===== -->
                <div class="col-lg-8 soal-wrapper">

                    <div class="mb-2">
                        <span>Soal No</span>
                        <span class="badge bg-dark px-3 py-2" id="nomorSoal">1</span>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">

                            @foreach($questions as $index => $question)
                            <div class="soal-item" data-soal="{{ $index + 1 }}" style="{{ $index==0 ? '' : 'display:none' }}">

                                <p class="fw-semibold soal-text">
                                    {{ $question->question_text }}
                                </p>

                                @if($question->image)
                                <div class="gambar-soal">
                                    <img src="{{ asset('storage/questions/'.$question->subtest_id.'/'.$question->image->image_name) }}">
                                </div>
                                @endif

                                @foreach($question->choices as $choice)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="jawaban[{{ $question->question_id }}]"
                                            value="{{ $choice->label }}">
                                        <label class="form-check-label">
                                            {{ $choice->label }}. {{ $choice->choice_value }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                            @endforeach

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
                <div class="col-lg-4 position-relative" id="navWrapper">

                    <!-- TOGGLE -->
                    <button id="toggleNav" class="nav-toggle btn btn-dark btn-sm">
                        <i class="bi bi-chevron-right"></i>
                    </button>

                    <!-- NAV BOX -->
                    <div class="nav-box" id="navSoal">
                        <div class="soal-grid mt-4">
                            @foreach($questions as $index => $q)
                                <button class="soal-btn" data-soal="{{ $index + 1 }}">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
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
document.addEventListener('DOMContentLoaded', function () {

    let currentSoal = 1;
    const totalSoal = {{ count($questions) }};
    const jawaban = {};
    const ragu = new Set();

    const btnPrev = document.getElementById('prevSoal');
    const btnNext = document.getElementById('nextSoal');
    const btnRagu = document.getElementById('btnRagu');
    const nomorSoal = document.getElementById('nomorSoal');

    /* =========================
       SET ACTIVE SOAL
    ========================= */
    function setActiveSoal(no) {
        currentSoal = Number(no);

        // Update nomor atas
        nomorSoal.innerText = currentSoal;

        // Tampilkan soal aktif
        document.querySelectorAll('.soal-item').forEach(item => {
            item.style.display =
                item.dataset.soal == currentSoal ? 'block' : 'none';
        });

        // Navigasi kanan
        document.querySelectorAll('.soal-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.soal == currentSoal) {
                btn.classList.add('active');
            }
        });

        updateNavButton();
    }

    /* =========================
       UPDATE BUTTON NAV
    ========================= */
    function updateNavButton() {
        // Tombol kembali (jangan geser layout)
        if (currentSoal === 1) {
            btnPrev.style.visibility = 'hidden'; // ⬅️ PENTING
        } else {
            btnPrev.style.visibility = 'visible';
        }

        // Tombol selanjutnya / selesai
        if (currentSoal === totalSoal) {
            btnNext.innerHTML = 'Selesai';
            btnNext.classList.remove('btn-dark');
            btnNext.classList.add('btn-success');
        } else {
            btnNext.innerHTML = 'Selanjutnya <i class="bi bi-arrow-right"></i>';
            btnNext.classList.remove('btn-success');
            btnNext.classList.add('btn-dark');
        }
    }

    /* =========================
       KLIK NAVIGASI KANAN
    ========================= */
    document.querySelectorAll('.soal-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            setActiveSoal(this.dataset.soal);
        });
    });

    /* =========================
       PILIH JAWABAN
    ========================= */
    document.querySelectorAll('.form-check-input').forEach(radio => {
        radio.addEventListener('change', function () {
            jawaban[currentSoal] = this.value;
            ragu.delete(currentSoal);

            const btn = document.querySelector(
                `.soal-btn[data-soal="${currentSoal}"]`
            );
            btn.classList.remove('ragu');
            btn.classList.add('answered');
        });
    });

    /* =========================
       TOMBOL RAGU
    ========================= */
    btnRagu.addEventListener('click', function () {
        const btn = document.querySelector(
            `.soal-btn[data-soal="${currentSoal}"]`
        );

        // JIKA SUDAH RAGU → BALIK
        if (btn.classList.contains('ragu')) {
            btn.classList.remove('ragu');

            // Kalau sudah dijawab → hijau
            if (jawaban[currentSoal]) {
                btn.classList.add('answered');
            }
            // Kalau belum dijawab → tetap biru (active)
        }
        // JIKA BELUM RAGU → JADI RAGU
        else {
            btn.classList.remove('answered');
            btn.classList.add('ragu');
        }
    });

    /* =========================
       NEXT & PREV
    ========================= */
    const SUBTEST_URL = "/subtest";
        btnNext.addEventListener('click', function () {
        if (currentSoal < totalSoal) {
            setActiveSoal(currentSoal + 1);
        } else {
            // KLIK SELESAI → PINDAH KE SUBTEST
            window.location.href = SUBTEST_URL;
        }
    });

    btnPrev.addEventListener('click', function () {
        if (currentSoal > 1) {
            setActiveSoal(currentSoal - 1);
        }
    });

    /* =========================
       TOGGLE NAVIGASI KANAN
    ========================= */
    const toggleNav = document.getElementById('toggleNav');
const toggleIcon = toggleNav.querySelector('i');

toggleNav.addEventListener('click', function () {
    const content = document.querySelector('.content-body');
    content.classList.toggle('nav-hidden');

    // GANTI ARAH PANAH
    if (content.classList.contains('nav-hidden')) {
        toggleIcon.classList.remove('bi-chevron-right');
        toggleIcon.classList.add('bi-chevron-left');
    } else {
        toggleIcon.classList.remove('bi-chevron-left');
        toggleIcon.classList.add('bi-chevron-right');
    }
});

    /* =========================
       INIT
    ========================= */
    setActiveSoal(1);

});

const SUBTEST_URL = "/subtest";
    let timeLeft = {{ $duration_seconds ?? (30 * 60) }}; // durasi subtes dalam detik
    const timerEl = document.getElementById('timer');

    function startTimer() {
        const timerInterval = setInterval(() => {

            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            timerEl.textContent =
                String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');

            if (timeLeft <= 0) {
                clearInterval(timerInterval);

                // WAKTU HABIS → LANGSUNG KE SUBTEST
                window.location.href = SUBTEST_URL;
            }

            timeLeft--;
        }, 1000);
    }

    startTimer();
</script>

</body>
</html>
