<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">

    <title>Skorify | Masuk Akun</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ @asset('./images/favicon.png') }}">
    <link href="{{ @asset('./css/style.css') }}" rel="stylesheet">
</head>
<body class="h-100 bg-skorify">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-5 offset-1 text-white">
                    <h1 class="display-4 text-white" style="font-weight: 500;"><b> Selamat Datang!</b></h1>
                    <p>
                        Skorify adalah layanan yang menyediakan sarana simulasi
                        ujian bagi calon mahasiswa Politeknik Negeri Batam dalam
                        rangka mempersiapkan diri menghadapi Ujian Mandiri Polibatam.
                    </p>
                </div>
                <div class="col-md-4 offset-1">
                    <div class="authincation-content shadow " style="border-radius: 15px;">
                        <div class="row no-gutters ">
                            <div class="col-xl-12 ">
                                @if($errors->any())
                                    <x-error-card message="{{$errors->first()}}"></x-error-card>
                                @endif

                                <div class="auth-form">
                                    <h2 class="text-center mb-1"><b>MASUK AKUN</b></h2>
                                    <p class="text-center">Masukkan email dan kata sandi Anda.</p>
                                    <form action="{{ route('login.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email anda">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Kata Sandi</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi anda">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-block" style="background-color: #001D39;color: white;">Masuk</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>

</body>

</html>
