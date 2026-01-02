<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kelola Subtes</title>
        <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ @asset('css/bootstrap-icons.min.css') }}">
        <style>
            .modal-contentSubtes label {
               margin-bottom: 0; 
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

                    <x-page-title title="Subtes Ujian Mandiri Polibatam (UMPB)"></x-page-title>

                    <div class="top-bar">
                        <input type="text" id="search" placeholder="Cari subtes">
                        <div>
                            <a href="{{ @asset('Templat_Soal_Subtes.xltx') }}" download class="btn">
                                <button>Unduh Templat</button>
                            </a>
                            <button id="create-subtest">Tambah Subtes</button>
                        </div>
                    </div>

                    <table id="subtests-table" class="table align-middle">
                        <thead>
                            <tr >
                                <th style="border-top-left-radius:10px;width:25%">Ikon</th>
                                <th style="width: 35%;">Nama</th>
                                <th style="width: 15%;">Durasi</th>
                                <th style="width: 25%;border-top-right-radius:10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($subtests as $subtest)
                            @php
                                $ds = $subtest->duration_seconds ?? 1800;
                                $h = intdiv($ds, 3600);
                                $m = intdiv($ds % 3600, 60);
                                $s = $ds % 60;
                                $hms = sprintf('%02d:%02d:%02d', $h, $m, $s);
                            @endphp
                            <tr
                                data-subtest-id="{{ $subtest->subtest_id }}"
                                data-subtest-name="{{ $subtest->subtest_name }}"
                                data-subtest-hours="{{ $h }}"
                                data-subtest-minutes="{{ $m }}"
                                data-subtest-seconds="{{ $s }}"
                            >
                                <td>
                                    @if($subtest->subtest_image_name)
                                        <img
                                            src="/images/subtest/{{ $subtest->subtest_image_name }}"
                                            alt="Ikon subtes {{ $subtest->subtest_image_name }}"
                                            style="height: 64px;"
                                        >
                                    @endif
                                </td>
                                <td>{{ $subtest->subtest_name }}</td>
                                <td>{{ $hms }} </td>
                                <td class="actions">
                                    <button class="btn-delete bi bi-trash"></button>
                                    <button class="btn-edit bi bi-pencil-square"></button>
                                    <a href="{{ route('pengerjaan', $subtest->subtest_id) }}">
                                        <button class="btn-add bi bi-eye"></button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada subtes</td></tr>
                        @endforelse
                        </tbody>
                    </table>



                    <x-create-subtest-modal></x-create-subtest-modal>
                    <x-edit-subtest-modal></x-edit-subtest-modal>
                </div>
            </div>

            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Developed by <a href="#" target="_blank">PBL-TRPL308</a> 2025</p>
                </div>
            </div>
        </div>

        <script src="{{ @asset('js/subtest.js') }}"></script>
        <script src="{{ @asset('js/sweetalert2.js') }}"></script>

        <script src="{{asset('vendor/global/global.min.js')}}"></script>
        <script src="{{asset('js/quixnav-init.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>

        <script src="{{ @asset('js/popper.min.js') }}"></script>
        <script src="{{ @asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>
