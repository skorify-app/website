<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pengerjaan Soal</title>

<!-- Icon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
<link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.3.67/css/materialdesignicons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
    }

    /* ============================
       SIDEBAR ADMIN (PALING KIRI)
    ============================ */
    .sidebar-admin {
        width: 250px;
        background: #fff;
        border-right: 1px solid #ddd;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
        z-index: 999;
    }

    .quixnav {
        padding-top: 20px;
    }

    .quixnav .nav-text {
        font-size: 15px;
    }

    .quixnav a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
    }

    .quixnav a:hover {
        background: #f3f3f3;
    }

    /* ============================
       LAYOUT UTAMA
    ============================ */
    .container {
        display: flex;
        height: 100vh;
        padding-left: 250px; /* geser konten karena sidebar admin */
    }

    .content {
        flex: 1;
        padding: 20px 30px;
        position: relative;
    }

    .top-section {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .timer-box {
        display: inline-block;
        padding: 10px 18px;
        background: #fff;
        border-radius: 8px;
        font-weight: bold;
        border: 1px solid #ddd;
    }

    .hide-btn {
        margin-left: 10px;
        padding: 8px 14px;
        background: #eee;
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
    }

    .menu-btn {
        margin-left: auto;
        padding: 10px 14px;
        background: #eee;
        border-radius: 6px;
        border: 1px solid #ccc;
        cursor: pointer;
        font-size: 20px;
    }

    .question-box {
        margin-top: 10px;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .nav-buttons {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
    }

    .btn {
        padding: 10px 18px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-back { background: #dcdcdc; }
    .btn-ragu { background: #ffcc00; }
    .btn-next { background: #4c8bff; color: white; }

    /* ============================
       SIDEBAR KANAN (DAFTAR SOAL)
    ============================ */
    .sidebar {
        width: 260px;
        background: #fff;
        border-left: 1px solid #ddd;
        padding: 20px;
        transition: width .3s ease, opacity .3s ease;
    }

    .sidebar.hidden {
        width: 0;
        opacity: 0;
        padding: 0;
        overflow: hidden;
        border: none;
    }

    .questions-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .q-item {
        width: 40px;
        height: 40px;
        background: #ffffff;
        color: black;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        border: 1px solid #ccc;
    }

    .q-answered { background: #4c8bff !important; color: white !important; }
    .q-flag { background: #ffcc00 !important; color: black !important; }
    .q-active { border: 2px solid #4c8bff; }

</style>
</head>

<body>

<!-- ============================
     SIDEBAR ADMIN KIRI
============================ -->

<x-nav-header></x-nav-header>
<x-sidebar.admin></x-sidebar.admin>
    
<div class="container">

    <!-- ============================
         BAGIAN KIRI – SOAL
    ============================ -->
    <div class="content">

        <div class="top-section">
            <div id="timer" class="timer-box">Waktu tersisa: 59:30</div>

            <button id="hideTimeBtn" class="hide-btn" onclick="toggleTime()">Hide</button>

            <button class="menu-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div>
            <small><strong>Soal No 1</strong></small>
        </div>

        <div class="question-box">
            <h5>Berikut merupakan contoh soal matematika ilmu yang menyenangkan 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do 
                eiusmod tempor incididunt ut .</h5>

            <input type="radio" name="answer"> Jawaban A <br>
            <input type="radio" name="answer"> Jawaban B <br>
            <input type="radio" name="answer"> Jawaban C <br>
            <input type="radio" name="answer"> Jawaban D
        </div>

        <div class="nav-buttons">
            <button class="btn btn-back">Kembali</button>
            <button class="btn btn-ragu">Ragu-ragu</button>
            <button class="btn btn-next">Selanjutnya</button>
        </div>

    </div>

    <!-- ============================
         SIDEBAR KANAN – DAFTAR SOAL
    ============================ -->
    <div id="sidebar" class="sidebar">
        <div class="questions-grid">

            <div class="q-item q-active" data-number="1">1</div>
            <div class="q-item" data-number="2">2</div>
            <div class="q-item" data-number="3">3</div>
            <div class="q-item" data-number="4">4</div>
            <div class="q-item" data-number="5">5</div>

            <div class="q-item" data-number="6">6</div>
            <div class="q-item" data-number="7">7</div>
            <div class="q-item" data-number="8">8</div>
            <div class="q-item" data-number="9">9</div>
            <div class="q-item" data-number="10">10</div>

        </div>
    </div>

</div>

<script>
/* ============================
   TOGGLE WAKTU TERSISA
============================ */
function toggleTime() {
    let timer = document.getElementById("timer");
    let btn = document.getElementById("hideTimeBtn");

    if (timer.style.display === "none") {
        timer.style.display = "inline-block";
        btn.innerText = "Hide";
    } else {
        timer.style.display = "none";
        btn.innerText = "Show";
    }
}

/* ============================
   TOGGLE SIDEBAR DAFTAR SOAL
============================ */
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("hidden");
}

/* ============================
   WARNA STATUS NOMOR SOAL
============================ */
let activeQuestion = 1;

document.querySelectorAll('input[name="answer"]').forEach(opt => {
    opt.addEventListener('change', function () {
        let btn = document.querySelector('.q-item[data-number="' + activeQuestion + '"]');
        btn.classList.remove('q-flag');
        btn.classList.add('q-answered');
    });
});

document.querySelector('.btn-ragu').addEventListener('click', function () {
    let btn = document.querySelector('.q-item[data-number="' + activeQuestion + '"]');
    btn.classList.remove('q-answered');
    btn.classList.add('q-flag');
});

document.querySelectorAll('.q-item').forEach(item => {
    item.addEventListener('click', function () {
        document.querySelectorAll('.q-item').forEach(x => x.classList.remove('q-active'));
        this.classList.add('q-active');
        activeQuestion = this.dataset.number;
    });
});
</script>

</body>
</html>
