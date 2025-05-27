@extends('Dashboardstlhlogin.pemerintahpusat.template.template')
@section('title', 'Detail Laporan Belum Terselesaikan')

@section('content')


<div id="notificationModal" class="fixed inset-0  flex items-center justify-center p-4 z-[100] hidden">
    {{-- Panel Modal --}}
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
        {{-- Header Modal --}}
        <div class="bg-kuning px-4 py-3 rounded-t-lg flex justify-between items-center">
            <h3 class="text-lg font-bold text-hitam">Peringatan: Tindak Lanjut Laporan Pengaduan Belum Terselesaikan</h3>
            {{-- Tombol close ditambahkan --}}
            <button type="button" id="closeModalHeaderBtn" class="text-hitam hover:text-gray-700 text-2xl">&times;</button>
        </div>

        {{-- Body Modal --}}
        <div class="p-6">
            <p class="text-sm text-gray-700 mb-2">Laporan pengaduan tidak terselesaikan, silahkan kirim laporan ke dinas :</p>
            <form action="{{ route('pemerintahpusat.laporan.kirimPesanBelumTerselesaikan', $laporan->id) }}" method="POST">
                @csrf
                <textarea name="isi_pesan" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-kuning" placeholder="berikan tanggapanmu..."></textarea>

                {{-- Footer Modal (Tombol) --}}
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="closeModalFooterBtn" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-kuning text-hitam rounded-lg hover:bg-yellow-500 transition-colors shadow-md flex items-center">
                        Kirim Laporan ke dinas
                        <img src="{{ asset('img/icon/kirim.svg') }}" class="w-3 h-2 ml-2">
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<section class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Detail Laporan Pengaduan</h2>
        <a href="/dinas/laporan/step3/diproses" class="text-hitam hover:text-kuning transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>
    <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Image Section -->
            <div class="lg:col-span-7 order-1">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden border-4 border-blue-500">
                    <img id="modal-image" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-auto max-h-[90vh] object-contain rounded-xl">
                </div>
                <!-- Halaman Detail dengan Tambahan Formulir dan Tombol -->
                <div class="container mx-auto my-6">
                    <div class="bg-white rounded-xl shadow-lg p-8 space-y-8 max-w-3xl mx-auto">
                        <!-- Tanggal Pengerjaan -->
                        <div class="space-y-3">
                            <label class="block text-base font-semibold text-gray-800">Tanggal Pengerjaan</label>
                            <input type="text"
                                   value="{{ $penyelesaian->tanggal_mulai }}"
                                   readonly
                                   class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 bg-gray-50/50 transition-all">
                        </div>

                        <!-- Tanggal Estimasi Selesai -->
                        <div class="space-y-3">
                            <label class="block text-base font-semibold text-gray-800">Tanggal Estimasi Selesai</label>
                            <input type="text"
                                   value="{{ $penyelesaian->tanggal_selesai }}" 
                                   readonly
                                   class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 bg-gray-50/50 transition-all">
                        </div>
                        
                        <div class="text-red-500">Dinas tidak menyelesaikan laporan</div>
                           
                        <!-- Deskripsi Pengerjaan -->
                        <div class="space-y-3">
                            <label class="block text-base font-semibold text-gray-800">Deskripsi Detail Pengerjaan</label>
                            <textarea readonly
                                      class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 bg-gray-50/50 h-40 resize-none transition-all">{{ $penyelesaian->deskripsi_pengerjaan }}</textarea>
                        </div>

                        <!-- Button -->
                        <div class="pt-6">
                            <button type="button"
                                    onclick="openModal()"
                                    id="showNotificationBtn"
                                    class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-lg font-bold text-white rounded-xl hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                Buat Notifikasi Pesan Laporan
                            </button>
                        </div>
                    </div>
                                       <!-- Like and Comment Count Section -->
    <div class="max-w-4xl mx-auto px-4 mb-4 flex items-center space-x-4 my-8">
        <span class="flex items-center space-x-1 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
            </svg>
            <span>{{ $likeCount }}</span>
        </span>
        <span class="flex items-center space-x-1 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span>{{ $komentar->count() }}</span>
        </span>
    </div>
    <div class="max-w-4xl mx-auto rounded-3xl shadow-md p-6 mb-8 border border-gray-400">
        <div class="space-y-4 h-64 overflow-y-auto mb-4 pr-2">
            @forelse($komentar as $k)
                <div class="flex items-start {{ $k->user_id == auth()->user()->id ? 'justify-end' : '' }} space-x-3">
                    @if($k->user_id != auth()->user()->id)
                        <img src="{{ ($k->user && $k->user->masyarakat && $k->user->masyarakat->foto_profil) ? 'data:image;base64,' . base64_encode($k->user->masyarakat->foto_profil) : asset('img/logo/profil.png') }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    @endif
                    <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                        <p class="text-sm text-gray-800">{{ $k->isi_komentar }}</p>
                        <span class="text-xs text-gray-400">{{ $k->user->username ?? 'User' }} - {{ $k->created_at->diffForHumans() }}</span>
                    </div>
                    @if($k->user_id == auth()->user()->id)
                        <img src="{{ ($k->user && $k->user->masyarakat && $k->user->masyarakat->foto_profil) ? 'data:image;base64,' . base64_encode($k->user->masyarakat->foto_profil) : asset('img/logo/profil.png') }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada komentar untuk laporan ini.</p>
            @endforelse
        </div>
    </div>
                     <!-- Komentar dipindahkan ke bawah Selesaikan Laporan -->
                <div class="bg-white rounded-xl shadow-xl p-8 h-full pt-4 mt-7">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Komentar</h3>
                    {{-- Area untuk menampilkan komentar dengan scroll --}}
                    <div class="space-y-4 h-64 overflow-y-auto mb-4 pr-2">
                        <!-- Comment Example 1 (User) -->
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('img/logo/profil.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">...Trimakasih sudah melakukan pelaporan</p>
                            </div>
                        </div>

                        <!-- Comment Example 2 (Another User/Admin) -->
                        <div class="flex items-start justify-end space-x-3">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Iyaa</p>
                            </div>
                            <img src="{{ asset('img/logo/profil.png') }}" alt="Admin Avatar" class="w-10 h-10 rounded-full">
                        </div>

                        {{-- Test scroll comments --}}
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('img/logo/profil.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Semoga cepat ditangani ya.</p>
                            </div>
                        </div>
                        <div class="flex items-start justify-end space-x-3">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Siap, sedang kami proses.</p>
                            </div>
                            <img src="{{ asset('img/logo/profil.png') }}" alt="Admin Avatar" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('img/logo/profil.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Terima kasih informasinya.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('img/logo/profil.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Terima kasih informasinya.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('img/logo/profil.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="bg-kuning p-3 rounded-lg shadow max-w-xs sm:max-w-md">
                                <p class="text-sm text-gray-800">Terima kasih informasinya.</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>


            <!-- Modal -->
            <div id="image-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden justify-center items-center z-50">
                <div class="relative bg-white p-8 rounded-lg">
                    <span id="close-modal" class="absolute top-2 right-2 text-2xl font-bold text-gray-500 cursor-pointer">&times;</span>
                    <img id="modal-image" src="/img/Desain/foto.png" alt="Foto Laporan" class="w-full h-auto max-h-[90vh] object-contain rounded-xl">
                </div>
            </div>

            <!-- Detail Section -->
            <div class="lg:col-span-5 order-2">
                <div class="bg-white rounded-xl shadow-xl p-8 h-full">
                    <!-- Problem Section -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Permasalahan</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->deskripsi }}</p>
                    </div>

                    <!-- Location Section -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Lokasi</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->lokasi }}</p>
                    </div>

                    <!-- Jam Laporan -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Waktu Laporan</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <!-- Status Section -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b-2 border-yellow-400 pb-2 inline-block">Status Laporan</h2>

                        <div class="relative mt-8 pl-6">
                            <!-- Vertical Timeline Line -->
                            <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-yellow-400 via-blue-400 to-gray-200 rounded-full"></div>

                            <!-- Status Items -->
                            <div class="space-y-10">
                                <!-- Status 1 - Active -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-6 w-6 rounded-full bg-yellow-400 border-4 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="pl-8">
                                        <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 shadow-sm">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-lg font-semibold text-gray-800">Menunggu Verifikasi</h3>
                                            </div>
                                            <p class="text-gray-600 mt-2 ml-11">Laporan telah diterima dan sedang menunggu verifikasi</p>
                                            <p class="text-sm text-gray-400 mt-2 ml-11">Waktu Laporan{{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 2 - Next -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-6 w-6 rounded-full bg-blue-400 border-4 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="pl-8">
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 shadow-sm">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-lg font-semibold text-gray-500">Dalam Proses</h3>
                                            </div>
                                            <p class="text-gray-400 mt-2 ml-11">Laporan sedang di Proses, di tindak lanjuti</p>
                                            @php
                                                $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();
                                            @endphp
                                            @if($trackProses)
                                                <p class="text-sm text-gray-400 mt-2 ml-11">Waktu: {{ $trackProses->created_at->format('Y-m-d H:i:s') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 3 - Future -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-6 w-6 rounded-full bg-gray-200 border-4 border-white shadow-lg"></div>
                                    </div>
                                    <div class="pl-8">
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-lg font-semibold text-gray-500">Selesai</h3>
                                            </div>
                                            <p class="text-gray-400 mt-2 ml-11">Laporanmu sudah selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- JavaScript untuk mengontrol modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('notificationModal');
        const showBtn = document.getElementById('showNotificationBtn');
        // Mengambil kedua tombol close
        const closeBtns = [
             document.getElementById('closeModalHeaderBtn'),
             document.getElementById('closeModalFooterBtn')
        ];
        const sendBtn = document.getElementById('sendNotificationBtn');

        // Fungsi untuk membuka modal
        function openModal() {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Mencegah scroll background
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Mengembalikan scroll background
        }

        // Tampilkan modal saat tombol 'Buat notifikasi' diklik
        if (showBtn) {
            showBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        }

        // Sembunyikan modal saat tombol tutup (X atau Batal) diklik
        closeBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', closeModal);
            }
        });

        // Kirim notifikasi dan tutup modal
        if (sendBtn) {
            sendBtn.addEventListener('click', function() {
                // Di sini Anda bisa menambahkan kode untuk mengirim notifikasi
                alert('Notifikasi berhasil dikirim ke dinas');
                closeModal();
            });
        }

        // Menutup modal jika klik di luar area modal (pada overlay)
        modal.addEventListener('click', function(event) {
            // Cek apakah klik terjadi langsung pada div overlay (modal itu sendiri)
            // Kita perlu cek targetnya adalah div terluar modal, bukan panelnya
            if (event.target === modal.firstElementChild.firstElementChild) { // Cek klik pada background overlay
                 closeModal();
            }
        });
    });
</script>

<!-- script gambar -->
<script>
    // Get the modal
    const modal = document.getElementById("image-modal");
    const modalImage = document.getElementById("modal-image");
    const triggerImage = document.getElementById("image-modal-trigger");
    const closeModal = document.getElementById("close-modal");

    // When the image is clicked, open the modal
    triggerImage.addEventListener("click", function() {
        modal.classList.remove("hidden");
        modalImage.src = triggerImage.src; // Set the image source in modal to be the same as the clicked image
    });

    // When the user clicks the close button, close the modal
    closeModal.addEventListener("click", function() {
        modal.classList.add("hidden");
    });

    // Optional: Close modal if clicked outside of the image
    modal.addEventListener("click", function(e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
</script>


@endsection