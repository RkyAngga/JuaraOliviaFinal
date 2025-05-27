@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Profil Masyarakat')

@section('content')

@if (session('success'))
    <div class="fixed top-40 right-10 z-100 max-w-xs">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded shadow-md flex items-center space-x-2" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-700 hover:text-green-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

<section class="profil">
    <div class="container mx-auto px-4 py-8 flex flex-col items-center space-y-8 max-w-4xl">
        <!-- Profile Header with Avatar -->
        <div class="relative w-full max-w-md flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-kuning shadow-xl mb-4">
                <img src="{{ $user->masyarakat->foto_profil ? 'data:image;base64,' . base64_encode($user->masyarakat->foto_profil) : asset('img/logo/profil.png') }}"
                    alt="Avatar"
                    class="w-full h-full object-cover" />
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $user->nama_lengkap ?? 'Pengguna' }}</h1>
            <span class="text-gray-600">{{ $user->username ?? '@username' }}</span>
        </div>

        <!-- Poin Card -->
        <div class="w-full max-w-md bg-kuning rounded-3xl shadow-lg mb-8 p-8 text-center border border-gray-300">
            <div class="text-lg font-semibold mb-2">Yeay kamu sudah mendapat</div>
            <div class="text-lg font-bold mb-1">{{ $user->masyarakat->poin ?? 0 }}</div>
            <div class="text-lg italic">Poin</div>
        </div>

        <!-- Profile Form Card -->
        <div class="w-full bg-kuning shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <form class="space-y-8">
                    @csrf
                    <!-- Data Diri -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Diri</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">NIK</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    {{ $user->nik ?? '-' }}
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    {{ $user->nama_lengkap ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Kontak -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Kontak</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    {{ $user->nomor_telepon ?? '-' }}
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Email</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    {{ $user->email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Akun -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Akun</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Username</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    {{ $user->username ?? '-' }}
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Password</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                    ********
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="button" onclick="window.location.href='/masyarakat/profil/ubah'" 
                            class="flex-1 px-6 py-3 bg-white text-hitam font-semibold rounded-lg hover:bg-abuabu transform hover:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Ubah Profil
                        </button>
                        <button type="button" onclick="showConfirmModal()" 
                            class="flex-1 px-6 py-3 bg-merah text-white font-semibold rounded-lg hover:bg-red-600 transform hover:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Keluar -->
        <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
            <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 transform transition-all duration-300">
                <div class="text-center space-y-6">
                    <svg class="w-16 h-16 text-merah mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800">Apakah anda yakin ingin keluar?</h3>
                    <div class="flex justify-center gap-4">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-merah text-white font-semibold rounded-lg hover:bg-red-600 transform hover:scale-[0.98] transition-all duration-200">
                                Ya, Keluar
                            </button>
                        </form>
                        <button onclick="closeConfirmModal()" class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transform hover:scale-[0.98] transition-all duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function showConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.remove('flex');
        document.getElementById('confirmModal').classList.add('hidden');
    }
</script>
@endsection