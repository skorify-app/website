<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pengaturan Akun</title>
    <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
    <link rel="stylesheet" href="{{ @asset('/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ @asset('/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ @asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ @asset('css/bootstrap-icons.min.css') }}">
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

    <x-nav-header></x-nav-header>

    <x-header></x-header>

    @if(Auth::user()->role == "ADMIN")
        <x-sidebar.admin></x-sidebar.admin>
    @else
        <x-sidebar.staff></x-sidebar.staff>
    @endif

    <div class="content-body">
        <div class="container">


            <div class="profile-card">
                <div class="avatar-circle">
                    <img src="{{ @asset('images/avatar/avatar-1.jpeg') }}" alt="avatar" class="avatar-img">
                </div>
                <div class="info-list">
                    <div class="info-row" data-toggle="modal" data-target="#editNameModal" style="cursor:pointer;">
                        <div>
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ Auth::user()->full_name }}</div>
                        </div>
                        <div class="edit-arrow"><i class="bi bi-chevron-right"></i></div>
                    </div>

                    <div class="info-row" data-toggle="modal" data-target="#editEmailModal" style="cursor:pointer;">
                        <div>
                            <div class="info-label">Alamat Email</div>
                            <div class="info-value">{{ Auth::user()->email }}</div>
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

                    <div class="info-row">
                        <div>
                            <div class="info-label">Peran</div>
                            <div class="info-value">{{ Auth::user()->role == 'ADMIN' ? 'Admin' : 'Staf' }}</div>
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
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="full_name" value="{{ Auth::user()->full_name }}" required>
                    </div>
                    <button type="submit" class="btn primary-btn btn-block">SIMPAN</button>
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
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <button type="submit" class="btn primary-btn btn-block">SIMPAN</button>
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
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-group">
                        <input type="password" class="form-control" name="current_password" placeholder="Kata sandi lama" required minlength="8">
                    </div>
                    <div class="form-group" style="margin-top:8px;">
                        <input type="password" class="form-control" name="password" placeholder="Kata sandi baru" required minlength="8">
                    </div>
                    <div class="form-group" style="margin-top:8px;">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi kata sandi" required minlength="8">
                    </div>
                    <button type="submit" class="btn primary-btn btn-block">SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('js/quixnav-init.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>

<!-- Chart Morris plugin files -->
<script src="{{asset('vendor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendor/morris/morris.min.js')}}"></script>
<script src="{{asset('js/plugins-init/morris-init.js')}}"></script>

<!-- CDN BOOTSTRAP -->
<script src="{{ @asset('js/popper.min.js') }}"></script>
<script src="{{ @asset('js/bootstrap.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ @asset('js/sweetalert2.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: {!! json_encode(session('success')) !!},
            timer: 2000,
            showConfirmButton: false
        });
        @endif

        @if($errors->any())
        // Get all errors
        const errorMessages = {!! json_encode($errors->messages()) !!};

        // Translation mapping - map Laravel error message ke Indonesian
        const messageTranslations = {
            'confirmation': 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
            'The password field confirmation does not match': 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
            'confirmed': 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
            'current_password': 'Kata sandi lama tidak cocok.',
            'at least 8 characters': 'Kata sandi baru minimal 8 karakter.',
            'email': 'Email sudah digunakan atau format salah.',
            'required': 'Field tidak boleh kosong.'
        };

        // Build translated error messages
        let translatedErrors = [];
        for (const [field, messages] of Object.entries(errorMessages)) {
            if (messages && messages.length > 0) {
                const errorMsg = messages[0].toLowerCase();
                let translated = null;

                // Try to match parts of the error message
                for (const [key, translation] of Object.entries(messageTranslations)) {
                    if (errorMsg.includes(key.toLowerCase())) {
                        translated = translation;
                        break;
                    }
                }

                if (translated) {
                    translatedErrors.push(translated);
                } else {
                    translatedErrors.push(messages[0]);
                }
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            html: '<ul style="text-align:left; display:inline-block;">' +
                translatedErrors.map(err => '<li>' + err + '</li>').join('') +
                '</ul>',
        });
        @endif
    });
</script>

</body>

</html>
