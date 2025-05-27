@extends('Dashboardstlhlogin.Dinas.Template.Template')
@section('title', 'Pemberitahuan')

@section('content')

<section class="min-h-screen py-4">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-4 sm:mb-6 relative">
            <!-- Left side: Back button -->
            <div class="flex items-center gap-3">
                <a href="/dinas/laporan/masyarakat" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>
            <!-- Center: Header Title -->
            <div class="absolute left-0 right-0 flex justify-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemberitahuan</h2>
            </div>
            <!-- Right side: Spacer (optional, depending on layout needs) -->
            <div class="flex items-center gap-3 invisible">
                 <a href="#" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>

        <!-- Content goes here -->
        <div class="space-y-4">
            @foreach($notifikasis as $notif)
                <div id="notif-{{ $notif->notifikasi_id }}"
                     class="rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow mb-4 flex justify-between items-start
                     {{ $notif->status_notifikasi == 'Terkirim' ? 'bg-kuning' : 'bg-[#FFD881]' }}">
                    <div>
                        @if($notif->jenis_notifikasi == 'PesanPusat')
                            @php
                                $laporan = \App\Models\LaporanPengaduan::with('tracking')->find($notif->pengaduan_id);
                                $lastTracking = $laporan ? $laporan->tracking->last() : null;
                            @endphp
                            @if($lastTracking && $lastTracking->status == 'Tidak Terselesaikan')
                                <a href="{{ route('dinas.laporan.pesanTidakTerselesaikan', $notif->pengaduan_id) }}"
                                   onclick="markAsRead({{ $notif->notifikasi_id }})">
                                    <h3 class="font-semibold text-hitam">{{ $notif->judul_notifikasi }}</h3>
                                    <p class="text-sm text-hitam/70 mt-1">{{ $notif->isi_notifikasi }}</p>
                                    <p class="text-xs text-hitam/50 mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                                </a>
                            @else
                                @if($notif->pengaduan_id)
                                    <a href="{{ route('dinas.laporan.pesanBelumDirespon', $notif->pengaduan_id) }}"
                                       onclick="markAsRead({{ $notif->notifikasi_id }})">
                                        <h3 class="font-semibold text-hitam">{{ $notif->judul_notifikasi }}</h3>
                                        <p class="text-sm text-hitam/70 mt-1">{{ $notif->isi_notifikasi }}</p>
                                        <p class="text-xs text-hitam/50 mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                                    </a>
                                @else
                                    <span>Pesan tidak terkait laporan</span>
                                @endif
                            @endif
                        @else
                            @if($notif->pengaduan_id)
                                <a href="{{ route('dinas.laporan.step9.ditolak', ['id' => $notif->pengaduan_id]) }}"
                                   onclick="markAsRead({{ $notif->notifikasi_id }})">
                                    <h3 class="font-semibold text-hitam">{{ $notif->judul_notifikasi }}</h3>
                                    <p class="text-sm text-hitam/70 mt-1">{{ $notif->alasan_penolakan }}</p>
                                    <p class="text-xs text-hitam/50 mt-1">{{ \Carbon\Carbon::parse($notif->waktu_tolak)->diffForHumans() }}</p>
                                </a>
                            @else
                                <span>Tidak ada detail laporan</span>
                            @endif
                        @endif
                    </div>
                    <button onclick="dismissNotif({{ $notif->notifikasi_id }})" class="text-hitam hover:text-merah transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
function markAsRead(id) {
    fetch('/notifikasi/' + id + '/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            let notif = document.getElementById('notif-' + id);
            if (notif) {
                notif.classList.remove('bg-kuning');
                notif.classList.add('bg-[#FFD881]');
            }
            // Update badge angka
            let badge = document.querySelector('.bg-merah, .bg-red-500');
            if (badge) {
                let count = parseInt(badge.textContent);
                if (count > 1) badge.textContent = count - 1;
                else badge.remove();
            }
        }
    });
}

function dismissNotif(id) {
    fetch('/notifikasi/' + id + '/dismiss', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            // Hapus notifikasi dari DOM
            let notif = document.getElementById('notif-' + id);
            if (notif) notif.remove();
            // Update badge angka
            let badge = document.querySelector('.bg-merah, .bg-red-500');
            if (badge) {
                let count = parseInt(badge.textContent);
                if (count > 1) badge.textContent = count - 1;
                else badge.remove();
            }
        }
    });
}
</script>
@endsection