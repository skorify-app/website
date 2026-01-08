<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Skorify | Masuk Akun</title>

     <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('images/skorify-logo.ico') }}">
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
                                

                                <div class="auth-form">
                                    <h2 class="text-center mb-1"><b>MASUK AKUN</b></h2>
                                    <p class="text-center">Masukkan email dan kata sandi Anda.</p>
                                    <form action="{{ route('login.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" id="email-input" class="form-control" placeholder="Masukkan Email anda" value="{{ old('email') }}">
                                            <small id="email-error" style="color: red; font-size: 12px; display: none;margin-top:1vh;"></small>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Kata Sandi</strong></label>
                                            <input type="password" name="password" id="password-input" class="form-control" placeholder="Masukkan Kata Sandi anda">
                                            <small id="password-error" style="color: red; font-size: 12px; display: none;margin-top:1vh;"></small>
                                        </div>
                                        @if(session('error'))
                                            <div class="text-center" style="color:red; font-size: 14px; margin-bottom: 10px;">
                                                {{ session('error') }}
                                            </div>
                                        @elseif($errors->any())
                                            <div class="text-center" style="color:red; font-size: 14px; margin-bottom: 2vh;">
                                                Email atau kata sandi anda salah
                                            </div>x`
                                        @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            const emailInput = document.getElementById('email-input');
            const passwordInput = document.getElementById('password-input');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    // Clear previous errors
                    emailError.style.display = 'none';
                    emailError.textContent = '';
                    passwordError.style.display = 'none';
                    passwordError.textContent = '';
                    
                    let hasError = false;
                    
                    const email = emailInput.value.trim();
                    const password = passwordInput.value.trim();
                    
                    // Validasi email kosong
                    if (!email) {
                        e.preventDefault();
                        emailError.textContent = 'Email harus diisi';
                        emailError.style.display = 'block';
                        hasError = true;
                    } else {
                        // Validasi format email
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(email)) {
                            e.preventDefault();
                            emailError.textContent = 'Format email tidak valid';
                            emailError.style.display = 'block';
                            hasError = true;
                        }
                    }
                    
                    // Validasi password kosong
                    if (!password) {
                        e.preventDefault();
                        passwordError.textContent = 'Kata sandi harus diisi';
                        passwordError.style.display = 'block';
                        hasError = true;
                    }
                    
                    if (hasError) {
                        return false;
                    }
                });
                
                // Clear error on input
                emailInput.addEventListener('input', function() {
                    emailError.style.display = 'none';
                    emailError.textContent = '';
                });
                
                passwordInput.addEventListener('input', function() {
                    passwordError.style.display = 'none';
                    passwordError.textContent = '';
                });
            }
        });
    </script>

</body>

</html>
