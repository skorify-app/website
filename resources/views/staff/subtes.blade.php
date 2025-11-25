<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Staff Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/skorify-logo.png" width="400" alt="">
                <img class="logo-compact" src="./images/skorify-logo.png" alt="">
                <img class="brand-title" src="./images/skorify-text.png" alt="">
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
                                    <a href="{{ url('/profile') }}" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profil</span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Kotak Masuk </span>
                                    </a>
                                    <a href="{{ url('/logout') }}" class="dropdown-item">
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
        <div class="quixnav  ">
            <div class="quixnav-scroll  " style="width: 100%;">
                <ul class="metismenu" id="menu" >
                   
                    <li><a  href="{{ url('/index') }}" aria-expanded="false"><i
                                class="bi bi-house mt-1"></i><span class="nav-text">Beranda</span></a>
                       
                    </li>
                    <li><a href="javascript:void()" aria-expanded="false"><i
                                class="bi bi-book mt-1"></i><span class="nav-text">Subtes</span></a>
                        
                    </li>
                    <li><a  href="javascript:void()" aria-expanded="false"><i
                                class="bi bi-person mt-1"></i><span class="nav-text">Peserta</span></a>
                        
                    </li>
                    <li><a  href="{{ url('/profile') }}" aria-expanded="false"><i
                                class="bi bi-gear mt-1   "></i><span class="nav-text ">Pengaturan Akun</span></a>
                        
                    </li>



                </ul>
            </div>


        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <h2>Subtes Ujian Mandiri Polibatam (UMPB)</h2>

  <div class="top-bar">
    <input type="text" id="search" placeholder="Cari disini">
    <div>
      <button id="downloadTemplate">Unduh Template</button>
      <button id="addSubtestBtn">Tambahkan Subtest</button>
    </div>
  </div>

  <table  id="subtestTable">
    <thead>
      <tr>
        <th style="border-top-left-radius:10px;">Subtes</th>
        <th style="width: 50%;border-top-right-radius:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Simulasi Ujian Mandiri Polibatam</td>
        <td class="actions">
          <button class="btn-delete bi bi-trash3"></button>
          <button class="btn-edit bi bi-pencil-square"></button>
          <button class="btn-add bi bi-eye"></button>
        </td>
      </tr>
      <tr>
        <td>Matematika</td>
        <td class="actions">
          <button class="btn-delete bi bi-trash3"></button>
          <button class="btn-edit bi bi-pencil-square"></button>
          <button class="btn-add bi bi-eye"></button>
        </td>
      </tr>
      <tr>
        <td>Computational Thinking</td>
        <td class="actions">
          <button class="btn-delete bi bi-trash3"></button>
          <button class="btn-edit bi bi-pencil-square"></button>
          <button class="btn-add bi bi-eye"></button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Modal Tambah Subtest -->
  <div class="modal-subtes" id="subtestModal">
    <div class="modal-contentSubtes">
      <span class="close-btn" id="closeModal">&times;</span>
      <h3>Tambahkan Subtest</h3>

      <label>Nama Subtest</label>
      <input type="text" id="subtestName" placeholder="Masukkan nama subtest" />

      <label>Upload Soal Subtest (Excel)</label>
      <input type="file" id="subtestFile" accept=".xlsx, .xls" />

      <button id="saveSubtest">Simpan</button>
    </div>
  </div>

<script>
  
</script>
               
               

               
                                               
 
               
                
                 
                    
               
              
                

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
    <script src="{{asset('js/tabel-subtes.js')}}"></script>


    



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