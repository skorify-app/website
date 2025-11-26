<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kelola Subtes</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
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
    <x-nav-header></x-nav-header>

    <x-header></x-header>

    @if($role == "ADMIN")
        <x-sidebar.admin></x-sidebar.admin>
    @else
        <x-sidebar.staff></x-sidebar.staff>
    @endif

    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            @if($errors->any())
                <x-error-card message="{{$errors->first()}}"></x-error-card>
            @endif

            @if(session()->has('success'))
                <x-error-card message="{{ session('success') }}"></x-error-card>
            @endif

            <h2>Subtes Ujian Mandiri Polibatam (UMPB)</h2>

            <div class="top-bar">
                <input type="text" id="search" placeholder="Cari disini">
                <div>
                    <button id="downloadTemplate">Unduh Template</button>
                    <button id="create-subtest">Tambah Subtes</button>
                </div>
            </div>

            <table id="subtests-table">
                <thead>
                    <tr>
                        <th style="border-top-left-radius:10px;">Nama Subtes</th>
                        <th style="width: 50%;border-top-right-radius:10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($subtests as $subtest)
                    <tr data-subtest-id="{{ $subtest['subtest_id'] }}">
                        <td>{{ $subtest['subtest_name'] }}</td>
                        <td class="actions">
                            <button class="btn-delete bi bi-trash">Hapus</button>
                            <button class="btn-edit bi bi-pencil-square">Edit</button>
                            <button class="btn-add bi bi-eye">Lihat</button>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Subtest -->
            <div class="modal-subtes" id="create-subtest-modal">
                <div class="modal-contentSubtes">
                    <span class="close-btn" id="close-modal">&times;</span>
                    <h3>Tambah Subtes</h3>

                    <label>Nama Subtes</label>
                    <input type="text" name="subtest_name" placeholder="Masukkan nama subtes" />

                    <label>Upload Soal Subtes (Excel)</label>
                    <input type="file" name="subtest_file" accept=".xlsx, .xls, .xltx, .xlt" />

                    <button id="submit-create-subtest">Tambah</button>
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
<script src="{{asset('js/subtest.js')}}"></script>






<script src="{{asset('vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('vendor/flot-spline/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('js/plugins-init/flot-init.js')}}"></script>



<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('js/quixnav-init.js')}}"></script>

<!-- CDN BOOTSTRAP -->
<script src="{{ @asset('js/popper.min.js') }}"></script>
<script src="{{ @asset('js/bootstrap.min.js') }}"></script>
</body>

</html>
