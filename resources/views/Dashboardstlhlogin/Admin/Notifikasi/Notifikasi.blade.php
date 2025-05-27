@extends('Dashboardstlhlogin.Admin.Template.Template')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col items-center mb-2">
        <h1 class="text-3xl font-bold text-hitam pt-4 mb-4">Pemberitahuan</h1>
        <div class="w-30 h-1 bg-kuning rounded-full mb-6"></div>
    </div>

    <div class="max-w-3xl mx-auto space-y-4">
        <!-- Notifikasi Item -->
        @foreach($notifikasis as $notif)
            <div id="notif-{{ $notif->notifikasi_id }}"
                 class="rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 mb-4 flex justify-between items-start transform hover:-translate-y-1
                 {{ $notif->status_notifikasi == 'Terkirim' ? 'bg-kuning' : 'bg-[#FFD57A]' }}">
                <div class="flex-grow">
                    <a href="{{ route('admin.notifikasi.ditolak', $notif->notifikasi_id) }}"
                       onclick="markAsRead({{ $notif->notifikasi_id }})"
                       class="block">
                        <h3 class="font-semibold text-hitam text-lg mb-2">{{ $notif->judul_notifikasi }}</h3>
                        <p class="text-sm text-hitam/70">{{ $notif->created_at->diffForHumans() }}</p>
                    </a>
                </div>
                <button onclick="dismissNotif({{ $notif->notifikasi_id }})" 
                        class="text-hitam hover:text-merah transition-colors p-2 rounded-full hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endforeach

        @if(count($notifikasis) === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <p class="text-gray-500 text-lg">Tidak ada pemberitahuan</p>
            </div>
        @endif
    </div>
</div>

<script>
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
                notif.classList.add('bg-[#FFD57A]');
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
</script>
@endsection