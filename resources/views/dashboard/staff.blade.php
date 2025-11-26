<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Dasbor Staff</title>

    <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
    <link href="{{ @asset('./vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ @asset('./css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ @asset('./vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ @asset('./vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header" style="background-color: #001D39;">
        <a href="{{ @route('dashboard') }}" class="brand-logo">
            <img class="logo-abbr" src="{{ @asset('./images/skorify-logo.png') }}" width="100" alt="">
            <img class="logo-compact" src="{{ @asset('./images/skorify-logo.png') }}" alt="">
            <img class="brand-title" src="{{ @asset('./images/skorify-text.png') }}" alt="">
        </a>

        <div class="nav-control">
            <div class="hamburger" >
                <span style="background-color: #001D39;" class="line"></span><span style="background-color: #001D39;" class="line"></span><span style="background-color: #001D39;" class="line"></span>
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
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="list-unstyled">
                                    <li class="media dropdown-item">
                                        <span class="success"><i class="ti-user"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Juan</strong> menambahkan <strong>subtes</strong> matematika.
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 WIB</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="primary"><i class="ti-shopping-cart"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Joel</strong> menghapus <strong>subtes</strong> matematika.</p>
                                            </a>
                                        </div>
                                        <span class="notify-time">13:00 WIB</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="danger"><i class="ti-bookmark"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Tian</strong> mengedit <strong>soal</strong> matematika.
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">12:20 WIB</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="primary"><i class="ti-heart"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Naomi</strong> membuat <strong>subtes</strong>  Bahasa Inggris.</p>
                                            </a>
                                        </div>
                                        <span class="notify-time">10:20 WIB</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="success"><i class="ti-image"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong> Nanda</strong> mengedit  <strong>soal</strong> Bahasa Inggris
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">20:20 WIB</span>
                                    </li>
                                </ul>
                                <a class="all-notification" href="#">See all notifications <i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-account"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="./app-profile.html" class="dropdown-item">
                                    <i class="icon-user"></i>
                                    <span class="ml-2">Profil</span>
                                </a>
                                <a href="./email-inbox.html" class="dropdown-item">
                                    <i class="icon-envelope-open"></i>
                                    <span class="ml-2">Kotak Masuk </span>
                                </a>
                                <a href="{{ @route('logout') }}" class="dropdown-item">
                                    <i class="icon-key"></i>
                                    <span class="ml-2">Keluar </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
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
                        <div class="card-header">
                            <h5 class="card-title">Statistik Pengguna</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title">Rekap Statistik</h5>
                            <div class="offset-1 mt-1 bg-primary"height="40" style=" border-radius: 5px; ">
                                <select class="form-control " height="40" style=" border-radius: 5px; ">
                                    <option>Januari</option>
                                    <option>Februari</option>
                                    <option>Maret</option>
                                    <option>April</option>
                                    <option>Mei</option>
                                    <option>Juni</option>
                                    <option>Juli</option>
                                    <option>Agustus</option>
                                    <option>September</option>
                                    <option>Oktober</option>
                                    <option>November</option>
                                    <option>Desember</option>
                                </select>
                            </div>
                        </div>
                        <!-- ini -->
                        <div class="row" style="margin-top: 5vh;">
                            <div class="col-lg-3 col-sm-6 col-10 col-xl-4  offset-xl-1  offset-1">
                                <div class="card shadow" style="border-radius: 10px;">
                                    <div class="stat-widget-two card-body flex-column flex-md-row  d-flex align-items-center p-3">
                                        <div class="stat-content  ">
                                            <div class="card-title mb-1">20 Pengerjaan</div>
                                            <div class="card-subtitle"> Simulasi Ujian Mandiri Polibatam (UMPB)</div>
                                        </div>

                                        <div class=" card-body p-0 d-flex align-items-center justify-content-center mt-3 " >
                                            <img src="images/grade.png" width="50" style="background-color:#BDD8E9;" class="img-thumbnail" alt="...">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-sm-6 col-10 col-xl-4  offset-xl-2 offset-1 ">
                                <a href="" data-toggle="modal" data-target="#exampleModalCenter"><div class="card shadow "style="border-radius: 10px;">
                                        <div class="stat-widget-two card-body flex-column flex-md-row  d-flex align-items-center p-3">
                                            <div class="stat-content  ">
                                                <div class="card-title mb-1">15 Pengerjaan</div>
                                                <div class="card-subtitle">  Subtes Ujian Mandiri Polibatam (UMPB)</div>
                                            </div>

                                            <div class=" card-body p-0 d-flex align-items-center justify-content-center mt-3 " >
                                                <img src="images/test.png" width="50" style="background-color:#BDD8E9;" class="img-thumbnail" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>


                            <!-- /# column -->

                        </div>
                    </div>
                </div>


            </div>
            <!-- Modal Review Pengerjaan Subtes -->
            <div class="modal fade " id="exampleModalCenter" >
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content pb-3 ">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: black">Detail Rekap Statistik</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>

                        </div>
                        <div class="row align-items-center">
                            <div class="search-container mt-1" width="10">
                                <input type="text" id="searchInput" placeholder="Cari Subtes">
                                <button id="clearBtn" title="Hapus"><i class="bi bi-x-circle"></i></button>
                                <button title="Cari"><i class="bi bi-search"></i></button>
                            </div>
                            <div class="offset-1 mt-1 bg-primary"height="40" style=" border-radius: 5px; ">
                                <select class="form-control " height="40" style=" border-radius: 5px; ">
                                    <option>Januari</option>
                                    <option>Februari</option>
                                    <option>Maret</option>
                                    <option>April</option>
                                    <option>Mei</option>
                                    <option>Juni</option>
                                    <option>Juli</option>
                                    <option>Agustus</option>
                                    <option>September</option>
                                    <option>Oktober</option>
                                    <option>November</option>
                                    <option>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-2" style="width: 100%; ">
                            <div class="col-6 align-items-center  d-flex  ">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text  ">
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Sains</h5>
                                    <p class="mb-0" style="line-height: 1.1;color:black;font-size:0.7rem;">4 Pengerjaan</p>
                                </div>
                            </div>
                            <div class=" col-5 d-flex align-items-center ">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text " >
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Matematika</h5>
                                    <p class="mb-0 " style="line-height: 1.1;color:black;font-size:0.7rem;">2 Pengerjaan</p>
                                </div>
                            </div>
                        </div>

                        <div class="row my-2" style="width: 100%; ">
                            <div class="col-6 align-items-center d-flex">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text  ">
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Literasi</h5>
                                    <p class="mb-0" style="line-height: 1.1;color:black;font-size:0.7rem;">40 Pengerjaan</p>
                                </div>
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text">
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Computational Thinking </h5>
                                    <p class="mb-0 " style="line-height: 1.1;color:black;font-size:0.7rem;">32 Pengerjaan</p>
                                </div>
                            </div>
                        </div>

                        <div class="row my-2 " style="width: 100%; ">
                            <div class="col-6 align-items-center  d-flex  ">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text  ">
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Bahasa Inggris</h5>
                                    <p class="mb-0" style="line-height: 1.1;color:black;font-size:0.7rem;">10 Pengerjaan</p>
                                </div>
                            </div>
                            <div class="  col-5 d-flex align-items-center ">
                                <img src="images/skorify-logo.png" width="50" alt="" class="margin-image" >
                                <div class="info-text " >
                                    <h5 class="mb-0" style="line-height: 1.1;color:black;">Bahasa Indonesia </h5>
                                    <p class="mb-0 " style="line-height: 1.1;color:black;font-size:0.7rem;">20 Pengerjaan</p>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xl-4">
                    <a href=""> <div class="card shadow"style="border-radius: 10px;">
                            <div class="stat-widget-two card-body d-flex align-items-center p-3">
                                <div class="stat-content">
                                    <div class="card-title mb-1">Kelola Subtes</div>
                                    <div class="card-subtitle"> Tambah, edit atau hapus</div>
                                </div>

                                <div class=" card-body p-0 d-flex align-items-center justify-content-center">

                                    <i class="bi bi-pencil-square"  style="font-size: 2.9rem;color: #001D39;"></i>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-xl-4 ">
                    <a href=""><div class="card shadow"style="border-radius: 10px;">
                            <div class="stat-widget-two card-body d-flex align-items-center p-3 ">
                                <div class="stat-content">
                                    <div class="card-title mb-1">Kelola Peserta</div>
                                    <div class="card-subtitle"> Lihat daftar akun dan kelola</div>
                                </div>

                                <div class="card-body p-0 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill"  style="font-size: 2.9rem;color: #001D39;"></i>

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
                                    <i class="bi bi-gear-wide-connected" style="font-size: 2.9rem;color: #001D39;"></i>

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
<script src="{{asset('js/dashboard-1.js') }}"></script>
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

<!-- CDN BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>

</html>
