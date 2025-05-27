@extends('Dashboardstlhlogin.pemerintahpusat.template.template')
@section('title', 'pusat')

@section('content')

<!-- Modal Notifikasi (Hidden by default) -->
{{-- Modal sudah dibuat responsif dengan max-w-md --}}
<div id="notificationModal" class="fixed inset-0  flex items-center justify-center p-4 z-[100] hidden">
    {{-- Panel Modal --}}
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
        {{-- Header Modal --}}
        <div class="bg-kuning px-4 py-3 rounded-t-lg flex justify-between items-center">
            <h3 class="text-lg font-bold text-hitam">Peringatan: Tindak Lanjut Laporan Pengaduan Belum Dilakukan</h3>
            {{-- Tombol close ditambahkan --}}
            <button type="button" id="closeModalHeaderBtn" class="text-hitam hover:text-gray-700 text-2xl">&times;</button>
        </div>

        {{-- Body Modal --}}
        <div class="p-6">
            <p class="text-sm text-gray-700 mb-2">Laporan pengaduan belum direspon, silahkan kirim laporan ke dinas :</p>
            <form action="{{ route('pemerintahpusat.laporan.kirimPesan', $laporan->id) }}" method="POST">
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


<section class="bg-gray-50 min-h-screen">
    {{-- Menambahkan padding horizontal untuk mobile --}}
    <div class="container mx-auto px-4 sm:px-8 py-4">
    <div class="flex justify-between items-center mb-4 sm:mb-6">
            {{-- Ukuran teks judul disesuaikan --}}
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Detail Laporan Pengaduan</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
    </div>
    <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Image Section -->
            <div class="lg:col-span-7">
                <div class="border-4 border-kuning rounded-xl shadow-xl overflow-hidden">
                    <img id="image-modal-trigger" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-96 md:h-[500px] object-cover rounded-xl transform hover:scale-105 transition duration-500 cursor-pointer">
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
            <div class="lg:col-span-5">
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
                            <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-yellow-400 via-gray-200 to-gray-200 rounded-full"></div>

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
                                            <p class="text-gray-600 mt-2 ml-11">Laporanmu dikirim, menunggu verifikasi dinas</p>
                                            <p class="text-sm text-gray-400 mt-2 ml-11">Waktu Laporan {{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 2 - Next -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-6 w-6 rounded-full bg-gray-200 border-4 border-white shadow-lg"></div>
                                    </div>
                                    <div class="pl-8">
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-lg font-semibold text-gray-500">Dalam Proses</h3>
                                            </div>
                                            <p class="text-gray-400 mt-2 ml-11">Laporan sedang di Proses, di tindak lanjuti</p>
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
                <div class="mt-6 flex justify-center sm:justify-end"> {{-- Tombol center di mobile, end di layar lebih besar --}}
                    <a href="#" id="showNotificationBtn" class="px-6 py-3 bg-kuning text-hitam font-semibold rounded-full hover:bg-yellow-500 transition duration-300 flex items-center justify-center shadow-md text-sm sm:text-base">
                        <span>Buat notifikasi laporan</span>
                    </a>
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

@endsection