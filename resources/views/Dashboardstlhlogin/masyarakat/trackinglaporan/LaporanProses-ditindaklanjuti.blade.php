@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Kinggg')

@section('content')

<section class="min-h-screen py-4">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <a href="/masyarakat/pengaduan" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Detail Laporan Pengaduan</h2>
            </div>
    </div>
    <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Image Section (now also contains comments) -->
            <div class="lg:col-span-7 flex flex-col gap-8">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden border-4 border-blue-950">
                    <img id="image-modal-trigger" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-96 md:h-[380px] object-cover rounded-xl transform hover:scale-105 transition duration-500 cursor-pointer">
                </div>

    <div class="justify-start">                          <!-- Like and Comment Count Section -->
    <div class="max-w-4xl mx-auto  mb-4 flex items-center space-x-4">
        <form action="{{ route('masyarakat.laporan.like', $laporan->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="flex items-center space-x-1 text-gray-600 hover:text-blue-500 {{ $liked ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                </svg>
                <span>{{ $likeCount }}</span>
            </button>
        </form>
        <div class="flex items-center space-x-1 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span>{{ $komentar->count() }}</span>
        </div>
    </div>
</div>
                <!-- Moved and Modified Comment Section -->
                <div class="bg-white rounded-xl shadow-xl p-8 pt-4">
                    {{-- Area untuk menampilkan komentar dengan scroll --}}
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Komentar</h3>
                    <div class="space-y-4 h-64 overflow-y-auto mb-4 pr-2">
                        @foreach($komentar as $k)
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
                        @endforeach
                    </div>
                    {{-- Input comment area --}}
                    <form action="{{ route('masyarakat.laporan.komentar', $laporan->id) }}" method="POST" class="flex items-center space-x-3 border-t border-black pt-4">
                        @csrf
                        <img src="{{ (auth()->user()->masyarakat && auth()->user()->masyarakat->foto_profil) ? 'data:image;base64,' . base64_encode(auth()->user()->masyarakat->foto_profil) : asset('img/logo/profil.png') }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                        <input type="text" name="isi_komentar" placeholder="Tulis komentar..." class="flex-grow p-3 border border-black rounded-full focus:outline-none" required>
                        <button type="submit" class="text-gray-600 p-2">
                            <img src="{{ asset('img/icon/kirim.svg') }}" alt="Kirim" class="w-10 h-5">
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div id="image-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden justify-center items-center z-50">
                <div class="relative bg-white p-8 rounded-lg">
                    <span id="close-modal" class="absolute top-2 right-2 text-2xl font-bold text-gray-500 cursor-pointer">&times;</span>
                    <img id="modal-image" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-auto max-h-[90vh] object-contain rounded-xl">
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
                                            <p class="text-sm text-gray-400 mt-2 ml-11">Waktu Laporan {{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
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
                                        <div class="bg-blue-500 p-4 rounded-xl border border-blue-500 shadow-sm">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-500 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-lg font-semibold text-black">Dalam Proses</h3>
                                            </div>
                                            @php
                                                $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();
                                                $penyelesaian = \App\Models\PenyelesaianLaporan::where('pengaduan_id', $laporan->id)->first();
                                            @endphp
                                            @if($trackProses)
                                                @if($trackProses->sub_status == 'proses')
                                                    <span style="color: #2196F3;">Laporan sedang di Proses, di tindak lanjuti</span>
                                                @elseif($trackProses->sub_status == 'menunggu_verifikasi_admin')
                                                    <span style="color: #093456;" class="text-white mt-2 ">Laporan Telah Diselesaikan, menunggu verifkasi admin</span>
                                                    @if($penyelesaian && $penyelesaian->waktu_foto)
                                                        <p class="text-sm text-white">Waktu Pengerjaan Laporan: {{ \Carbon\Carbon::parse($penyelesaian->waktu_foto)->format('Y-m-d H:i:s') }}</p>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 3 - Future -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-5 md:h-6 w-5 md:w-6 rounded-full bg-gray-200 border-4 border-white shadow-lg"></div>
                                    </div>
                                    <div class="pl-5 md:pl-7 w-full">
                                        <div class="bg-gray-50 p-3 md:p-4 rounded-lg border border-gray-100 w-full">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-6 w-6 md:h-7 md:w-7 rounded-full bg-gray-200 mr-2.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base md:text-lg font-semibold text-gray-500">Selesai</h3>
                                            </div>
                                            <p class="text-sm md:text-base text-gray-400 mt-1.5 md:mt-2 ml-8 md:ml-9">Laporanmu sudah selesai</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- detail laporan  dinas-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
