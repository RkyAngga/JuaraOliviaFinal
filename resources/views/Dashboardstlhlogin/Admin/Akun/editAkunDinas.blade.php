@extends('Dashboardstlhlogin.Admin.Template.Template')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Judul Halaman -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Akun Dinas</h2>
            <a href="/admin/akun" class="text-hitam hover:text-kuning transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
        <div class="w-full h-1 bg-kuning mt-2"></div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-kuning rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-hitam mb-6">Akun Dinas</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <form id="formEditAkun" action="{{ route('admin.akun.dinas.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Nama Dinas -->
                        <div class="space-y-2">
                            <label for="name" class="block text-hitam font-medium">Nama Dinas</label>
                            <input type="text" id="name" name="name" placeholder="Nama Dinas" required value="{{ old('name', $user->nama_lengkap) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label for="username" class="block text-hitam font-medium">Username</label>
                            <input type="text" id="username" name="username" placeholder="Username" required value="{{ old('username', $user->username) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-hitam font-medium">Email</label>
                            <input type="email" id="email" name="email" placeholder="dinas@example.com" required value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="space-y-2">
                            <label for="nomor_telepon" class="block text-hitam font-medium">Nomor Telepon</label>
                            <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="081234567890" required value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('nomor_telepon')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Wilayah -->
                        <div class="space-y-2">
                            <label for="wilayah" class="block text-hitam font-medium">Wilayah</label>
                            <input type="text" id="wilayah" name="wilayah" placeholder="Nama Wilayah" required value="{{ old('wilayah', $dinas->wilayah) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('wilayah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Foto Profil -->
                        <div class="space-y-2">
                            <label for="foto_profil" class="block text-hitam font-medium">Foto Profil</label>
                            <input type="file" id="foto_profil" name="foto_profil" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @if($dinas->foto_profil)
                                <img src="{{ asset('storage/' . $dinas->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 rounded-full mt-2">
                            @endif
                            @error('foto_profil')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Password (Opsional) -->
                        <div class="space-y-2">
                            <label for="password" class="block text-hitam font-medium">Password <span class="text-xs text-gray-500">(Opsional, isi jika ingin mengganti)</span></label>
                            <input type="password" id="password" name="password" placeholder="********"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Latitude -->
                        <div class="space-y-2">
                            <label for="latitude" class="block text-hitam font-medium">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" placeholder="Latitude" required value="{{ old('latitude', $dinas->latitude) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('latitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Longitude -->
                        <div class="space-y-2">
                            <label for="longitude" class="block text-hitam font-medium">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" placeholder="Longitude" required value="{{ old('longitude', $dinas->longitude) }}"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @error('longitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Hidden fields for grade and point -->
                        <input type="hidden" name="grade" value="A">
                        <input type="hidden" name="point" value="0">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" id="submitBtn" class="w-full bg-white text-hitam font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="successModal" class="fixed inset-0  hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-8 max-w-sm mx-auto text-center">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Akun Berhasil Diubah</h3>
            <p class="text-gray-500 mb-6">Akun telah berhasil diubah.</p>
        </div>
    </div>
</div>


@endsection