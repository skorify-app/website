 <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header" style="background-color: #001D39;">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/skorify-logo.png" width="100" alt="">
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