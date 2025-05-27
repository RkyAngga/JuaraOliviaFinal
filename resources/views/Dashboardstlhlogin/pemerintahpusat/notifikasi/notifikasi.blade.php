@extends('Dashboardstlhlogin.pemerintahpusat.template.template')
@section('title', 'pusat')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-center items-center mb-6 mt-4">
        <h1 class="text-3xl font-bold text-hitam">Pemberitahuan</h1>
    </div>

    <div class="space-y-4">
        <!-- Notifikasi Item -->
        @foreach($notifikasis as $notif)
            <div id="notif-{{ $notif->notifikasi_id }}"
                 class="rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow mb-4 flex justify-between items-start
                 {{ $notif->status_notifikasi == 'Terkirim' ? 'bg-kuning' : 'bg-[#FFD57A]' }}">
                <div>
                    <a href="{{ route('pemerintahpusat.notifikasi.ditolak', $notif->notifikasi_id) }}"
                       onclick="markAsRead({{ $notif->notifikasi_id }})">
                        <h3 class="font-semibold text-hitam">{{ $notif->judul_notifikasi }}</h3>
                        <p class="text-sm text-hitam/70 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </a>
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