<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kelola Staff</title>
        <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ @asset('css/bootstrap-icons.min.css') }}">
        <style>
            /* Center modal on screen */
            .modal-subtes {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
                align-items: center;
                justify-content: center;
            }

            .modal-subtes.show {
                display: flex;
            }

            .modal-contentSubtes {
                background-color: #fefefe;
                margin: 0 auto;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                width: 90%;
            }

            .modal-contentSubtes input[type="email"],
            .modal-contentSubtes input[type="password"],
             .modal-contentSubtes input[type="text"] {
                padding: 10px 12px;
                border-radius: 8px;
                border: 1px solid #ccc;
            }
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

            <x-sidebar.admin></x-sidebar.admin>

            <div class="content-body">
                <!-- row -->
                <div class="container-fluid">
                    @if($errors->any())
                        <x-error-card message="{{$errors->first()}}"></x-error-card>
                    @endif

                    @if(session()->has('success'))
                        <x-error-card message="{{ session('success') }}"></x-error-card>
                    @endif

                    <x-page-title title="Kelola Staff"></x-page-title>

                    <div class="top-bar">
                        <input type="text" id="search" placeholder="Cari disini">
                        <div>
                            <button id="create-staff">Tambah Staff</button>
                        </div>
                    </div>

                    <table id="staff-table">
                        <thead>
                            <tr>
                                <th style="border-top-left-radius:10px;">Nama Lengkap</th>
                                <th>Email</th>
                                <th style="width: 50%;border-top-right-radius:10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($staffs as $staff)
                            <tr
                                data-staff-id="{{ $staff->account_id }}"
                                data-staff-name="{{ $staff->full_name }}"
                                data-staff-email="{{ $staff->email }}"
                            >
                                <td>{{ $staff->full_name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td class="actions">
                                    <button class="btn-delete bi bi-trash"></button>
                                    <button class="btn-edit bi bi-pencil-square"></button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>

                    <x-create-staff-modal></x-create-staff-modal>
                    <x-edit-staff-modal></x-edit-staff-modal>
                </div>
            </div>

            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Developed by <a href="#" target="_blank">PBL-TRPL308</a> 2025</p>
                </div>
            </div>
        </div>

        <script src="{{ @asset('js/staff.js') }}"></script>
        <script src="{{ @asset('js/sweetalert2.js') }}"></script>

        <script src="{{asset('vendor/global/global.min.js')}}"></script>
        <script src="{{asset('js/quixnav-init.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>

        <script src="{{ @asset('js/popper.min.js') }}"></script>
        <script src="{{ @asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>
