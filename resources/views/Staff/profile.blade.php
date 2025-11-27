<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pengaturan Akun - Staff</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
    /* small inline styles to mimic the reference */
    .profile-card {
      max-width: 560px;
      margin: 6vh auto;
      background: #fff;
      border-radius: 18px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      text-align: center;
      position: relative;
    }
    .avatar-circle {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: #f1f7f8;
      display:inline-block;
      overflow: hidden;
      margin: -80px auto 20px;
      border:4px solid #fff;
    }
    .avatar-circle img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: 50%;
    }
        .info-list { text-align:left; max-width:460px; margin:0 auto; }
        .info-row { background:#fbfbfb; border:1px solid #eee; padding:14px 18px; border-radius:6px; display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
        .info-label { font-weight:600; color:#333; }
        .info-value { color:#555; }
        .edit-arrow { color:#bbb; }
    .logout-btn { display:block; margin:22px auto 0; max-width:420px; }
    /* primary brand button using requested color #001D39 */
    .primary-btn {
      background-color: #001D39;
      border-color: #001D39;
      color: #ffffff;
    }
    .primary-btn:hover, .primary-btn:focus {
      background-color: #00142b; /* slightly darker on hover */
      border-color: #00142b;
      color: #fff;
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


        <x-header.header></x-header.header>

    <!--**********************************
      Sidebar start (same as Beranda)
    ***********************************-->
    <x-sidebar.staff></x-sidebar.staff>

  <div class="content-body">
            <div class="container">
                <div class="profile-card">
          <div class="avatar-circle">
            <img src="./images/avatar/avatar-1.jpeg" alt="avatar" class="avatar-img">
          </div>
                    <div class="info-list">
                        <div class="info-row" data-toggle="modal" data-target="#editNameModal" style="cursor:pointer;">
                            <div>
                                <div class="info-label">Nama</div>
                                <div class="info-value">Hikari Immanuel blarblar</div>
                            </div>
                            <div class="edit-arrow"><i class="bi bi-chevron-right"></i></div>
                        </div>

                        <div class="info-row" data-toggle="modal" data-target="#editEmailModal" style="cursor:pointer;">
                            <div>
                                <div class="info-label">Email</div>
                                <div class="info-value">Hikarimanuel@gmail.com</div>
                            </div>
                            <div class="edit-arrow"><i class="bi bi-chevron-right"></i></div>
                        </div>

                        <div class="info-row" data-toggle="modal" data-target="#editPasswordModal" style="cursor:pointer;">
                            <div>
                                <div class="info-label">Kata sandi</div>
                                <div class="info-value">************</div>
                            </div>
                            <div class="edit-arrow"><i class="bi bi-chevron-right"></i></div>
                        </div>

                        <div class="info-row" style="background:#fff; border-color:#eee;">
                            <div>
                                <div class="info-label">Peran</div>
                                <div class="info-value">Staff</div>
                            </div>
                        </div>

            <a href="{{ url('/logout') }}" class="btn primary-btn btn-block logout-btn">KELUAR</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modals for editing -->
    <!-- Edit Name -->
    <div class="modal fade" id="editNameModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Nama</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="#">
              <div class="form-group">
                <input type="text" class="form-control" name="name" value="Hikari Immanuel blarblar">
              </div>
              <button type="button" class="btn primary-btn btn-block" data-dismiss="modal">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Email -->
    <div class="modal fade" id="editEmailModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Email</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="#">
              <div class="form-group">
                <input type="email" class="form-control" name="email" value="Hikarimanuel@gmail.com">
              </div>
              <button type="button" class="btn primary-btn btn-block" data-dismiss="modal">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Password -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Kata Sandi</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="#">
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Kata sandi baru">
              </div>
              <button type="button" class="btn primary-btn btn-block" data-dismiss="modal">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('js/quixnav-init.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

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
