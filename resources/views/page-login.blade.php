<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Masuk</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./css/style.css" rel="stylesheet">

</head>


<body class="h-100 bg-skorify">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-5 offset-1 ">
                    <h1 class="display-4 " style="color: white;font-weight: 500;"><b> Selamat Datang!</b></h1>
                    <p style="color: white;;">Skorify
                           adalah layanan yang menyediakan sarana
                              simulasi ujian bagi calon mahasiswa Politeknik
                               Negeri Batam dalam rangka mempersiapkan diri
                                 menghadapi Ujian Mandiri Polibatam. </p>
                </div>
                <div class="col-md-4 offset-1 ">
                    <div class="authincation-content shadow " style="border-radius: 15px;">
                        <div class="row no-gutters ">
                            <div class="col-xl-12 ">
                                <div class="auth-form " >
                                    <h2 class="text-center mb-1" style="color: #001D39;"><b>Masuk</b></h2>
                                        <p class="text-center">Masukkan Email dan Kata Sandi anda!</p>
                                    <form action="{{ route('login.process') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email anda">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Kata Sandi</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi anda">
                                        </div>
                                      <div class="form-group">
                                            <label><strong>Peran</strong></label>
                                            <select class="form-control" name="role">
                                                <option value="STAFF">Staff</option>
                                                <option value="ADMIN">Admin</option>
                                            </select>
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
