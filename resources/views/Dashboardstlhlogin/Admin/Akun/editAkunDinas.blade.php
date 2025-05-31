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
        <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
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
                            <label for="name" class="block text-gray-700 font-medium">Nama Dinas</label>
                            <div class="relative">
                                <input type="text" id="name" name="name" placeholder="Nama Dinas" required value="{{ old('name', $user->nama_lengkap) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label for="username" class="block text-gray-700 font-medium">Username</label>
                            <div class="relative">
                                <input type="text" id="username" name="username" placeholder="Username" required value="{{ old('username', $user->username) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-gray-700 font-medium">Email</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" placeholder="dinas@example.com" required value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="space-y-2">
                            <label for="nomor_telepon" class="block text-gray-700 font-medium">Nomor Telepon</label>
                            <div class="relative">
                                <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="081234567890" required value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            @error('nomor_telepon')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Wilayah -->
                        <div class="space-y-2">
                            <label for="wilayah" class="block text-gray-700 font-medium">Wilayah</label>
                            <div class="relative">
                                <input type="text" id="wilayah" name="wilayah" placeholder="Nama Wilayah" required value="{{ old('wilayah', $dinas->wilayah) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
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
                            <label for="password" class="block text-gray-700 font-medium">Password <span class="text-xs text-gray-500">(Opsional, isi jika ingin mengganti)</span></label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="********"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Latitude -->
                        <div class="space-y-2">
                            <label for="latitude" class="block text-gray-700 font-medium">Latitude</label>
                            <div class="relative">
                                <input type="number" step="any" id="latitude" name="latitude" placeholder="Latitude" required value="{{ old('latitude', $dinas->latitude) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            @error('latitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Longitude -->
                        <div class="space-y-2">
                            <label for="longitude" class="block text-gray-700 font-medium">Longitude</label>
                            <div class="relative">
                                <input type="number" step="any" id="longitude" name="longitude" placeholder="Longitude" required value="{{ old('longitude', $dinas->longitude) }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            @error('longitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Hidden fields for grade and point -->
                        <input type="hidden" name="grade" value="A">
                        <input type="hidden" name="point" value="0">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col space-y-4 mt-8">
                    <button type="submit" id="submitBtn" class="w-full bg-kuning text-hitam font-bold py-4 px-6 rounded-xl hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span>Simpan Perubahan</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </button>
                    <a href="{{ route('admin.akun') }}" class="w-full py-3 px-6 rounded-xl bg-gray-100 text-hitam hover:bg-gray-200 transition-all duration-300 flex items-center justify-center space-x-2 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl p-8 max-w-sm mx-auto text-center transform transition-all duration-300 scale-90 opacity-0">
            <div class="mb-4">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Akun Berhasil Diubah</h3>
            <p class="text-gray-500 mb-6">Akun telah berhasil diubah.</p>
            <div class="animate-bounce">
                <svg class="mx-auto h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

@endsection
