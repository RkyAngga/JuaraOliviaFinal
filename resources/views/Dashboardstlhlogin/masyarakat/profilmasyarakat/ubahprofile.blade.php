@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Ubah Profil')

@section('content')
<section class="profil">
    <div class="container mx-auto px-4 py-8 flex flex-col items-center max-w-4xl">
        <!-- Header -->
        <div class="w-full flex items-center gap-4 mb-8">
            <a href="/masyarakat/profil" class="flex items-center justify-center p-2 text-gray-600 hover:text-kuning transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">Ubah Profil</h1>
                <p class="text-gray-600 mt-1">Perbarui informasi profil dan pengaturan akun Anda</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="w-full bg-kuning rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('masyarakat.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')

                <!-- Validation Errors -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-red-800 font-semibold">Terdapat beberapa kesalahan:</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Photo Upload Section -->
                <div class="flex flex-col items-center mb-8 p-6 bg-gray-50 rounded-xl">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-kuning shadow-lg mb-4">
                            <img src="{{ $user->masyarakat->foto_profil ? 'data:image;base64,' . base64_encode($user->masyarakat->foto_profil) : asset('img/logo/profil.png') }}"
                                alt="Foto Profil"
                                class="w-full h-full object-cover"
                                id="previewImage">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <label class="p-2 bg-black bg-opacity-50 rounded-full cursor-pointer">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" name="foto_profil" id="foto_profil" class="hidden" accept="image/jpeg,image/png,image/gif">
                            </label>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Klik untuk mengganti foto profil (Maks. 2MB)</p>
                </div>

                <!-- Form Sections -->
                <div class="space-y-8">
                    <!-- Data Diri Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Diri</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" value="{{ $user->nik }}" readonly
                                    class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-200 text-gray-500 cursor-not-allowed">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Data Kontak Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Kontak</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon" value="{{ $user->nomor_telepon }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Data Akun Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Akun</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" value="{{ $user->username }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-kuning focus:border-transparent transition-all">
                                <p class="text-sm text-merah mt-1">*Wajib diisi jika mengubah password</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-white text-hitam font-semibold rounded-lg hover:bg-abuabu transform hover:scale-[0.98] transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Preview image before upload
    document.getElementById('foto_profil').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran foto maksimal 2 MB.");
                e.target.value = "";
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection