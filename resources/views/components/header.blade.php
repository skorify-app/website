  <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                             
                              
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" style="position: relative;">
                                    <i class="mdi mdi-bell"></i>
                                    @php $hasUnread = auth()->user() ? auth()->user()->unreadNotifications->count() > 0 : false; @endphp
                                    @if($hasUnread)
                                        <span class="notification-dot" style="position: absolute; top: 17px; right: 2px; display: block; width: 10px; height: 10px; background: #ff3b30; border-radius: 50%; border: 2px solid #fff;"></span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        @if(auth()->user())
                                            @forelse(auth()->user()->unreadNotifications->take(2) as $notification)
                                                <li class="media dropdown-item" style="display:flex;align-items:flex-start;gap:10px;padding:8px 12px;border-bottom:1px solid #f0f0f0;">
                                                    <span class="success" style="flex:0 0 36px;display:flex;align-items:center;justify-content:center;"><i class="ti-bell"></i></span>
                                                    <div class="media-body" style="flex:1;">
                                                        <a href="{{ route('notifications.index') }}" style="display:block;">
                                                            <p style="white-space:normal;margin:0;word-break:break-word;"><strong>{{ $notification->data['actor'] }}</strong> {{ $notification->data['action'] }} <strong>subtes</strong> {{ $notification->data['subtest'] }}.</p>
                                                        </a>
                                                        <div style="font-size:12px;color:#999;margin-top:6px;">{{ $notification->created_at->format('H:i') }} WIB</div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="media dropdown-item">
                                                    <div class="media-body">
                                                        <p>Tidak ada notifikasi baru.</p>
                                                    </div>
                                                </li>
                                            @endforelse
                                        @else
                                            <li class="media dropdown-item">
                                                <div class="media-body">
                                                    <p>Login untuk melihat notifikasi.</p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                    <a class="all-notification" href="{{ route('notifications.index') }}">Lihat semua notifikasi <i
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
                                        <span class="ml-2">Pengaturan</span>
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item">
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
