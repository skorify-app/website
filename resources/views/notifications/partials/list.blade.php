@if($notifications->count() > 0)
    <ul class="list-unstyled mb-0">
        @foreach($notifications as $notification)
            <li style="border-bottom:1px solid #eee;padding:12px 16px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                    <div style="flex:1;color:{{ is_null($notification->read_at) ? '#000' : '#999' }};">
                        <div style="font-weight: {{ is_null($notification->read_at) ? '700' : '400' }};">
                            <strong>{{ $notification->data['actor'] }}</strong> {{ $notification->data['action'] }} <strong>subtes</strong> {{ $notification->data['subtest'] }}.
                        </div>
                        
                        @if(isset($notification->data['changes']) && count($notification->data['changes']) > 0)
                            <div style="margin-top:8px;padding-left:12px;border-left:3px solid {{ is_null($notification->read_at) ? '#001D39' : '#ccc' }};">
                                <div style="font-size:13px;margin-bottom:4px;"><strong>Perubahan:</strong></div>
                                @foreach($notification->data['changes'] as $change)
                                    <div style="font-size:13px;margin-bottom:2px;">
                                        @if($change['field'] === 'nama')
                                            • Nama: <span style="opacity:0.7;">{{ $change['old'] }}</span> → <span style="font-weight:600;">{{ $change['new'] }}</span>
                                        @elseif($change['field'] === 'durasi')
                                            • Durasi: <span style="opacity:0.7;">{{ $change['old'] }}</span> → <span style="font-weight:600;">{{ $change['new'] }}</span>
                                        @elseif($change['field'] === 'icon')
                                            • Icon: <span style="font-weight:600;">Diperbarui</span>
                                        @elseif($change['field'] === 'soal')
                                            • Soal: <span style="font-weight:600;">Diperbarui (file Excel baru)</span>
                                        @elseif($change['field'] === 'gambar')
                                            • Gambar: <span style="font-weight:600;">Diperbarui (file ZIP baru)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <div style="color:#777;font-size:13px;margin-top:6px;">{{ $notification->created_at->translatedFormat('d F Y H:i') }} WIB</div>
                    </div>
                    <div style="flex:0 0 auto;text-align:right;">
                        @if(is_null($notification->read_at))
                            <form action="{{ route('notifications.markRead', ['id' => $notification->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-sm btn-primary btn-mark-read">Tandai dibaca</button>
                            </form>
                        @else
                            <span class="text-muted">Dibaca</span>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="p-4 text-center text-muted">Belum ada notifikasi.</div>
@endif
