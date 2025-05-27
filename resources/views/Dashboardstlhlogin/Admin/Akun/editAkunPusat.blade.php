@extends('Dashboardstlhlogin.Admin.Template.Template')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Judul Halaman -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Akun Pemerintah Pusat</h2>
            <a href="{{ route('admin.akun') }}" class="text-hitam hover:text-kuning transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
        <div class="w-full h-1 bg-kuning mt-2"></div>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-kuning rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-hitam mb-6">Akun Pemerintah Pusat</h2>
            
            <form action="{{ route('admin.akun.pusat.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Nama Pemerintah Pusat -->
                        <div>
                            <label for="nama_lengkap" class="block text-hitam font-medium mb-2">Nama Pemerintah Pusat</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" 
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('nama_lengkap') border-red-500 @enderror"
                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-hitam font-medium mb-2">Username</label>
                            <input type="text" id="username" name="username" placeholder="Username" 
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('username') border-red-500 @enderror"
                                value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-hitam font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" placeholder="email@contoh.com"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('email') border-red-500 @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Profil -->
                        <div>
                            <label for="foto_profil" class="block text-hitam font-medium mb-2">Foto Profil</label>
                            <input type="file" id="foto_profil" name="foto_profil" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                            @if($pusat->foto_profil)
                                <img src="{{ asset('storage/' . $pusat->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 rounded-full mt-2">
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-hitam font-medium mb-2">Password</label>
                            <input type="password" id="password" name="password" placeholder="********"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('password') border-red-500 @enderror"
                                required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-hitam font-medium mb-2">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam"
                                required>
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="nomor_telepon" class="block text-hitam font-medium mb-2">Nomor Telepon</label>
                            <input type="text" id="nomor_telepon" name="nomor_telepon" placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('nomor_telepon') border-red-500 @enderror"
                                value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required>
                            @error('nomor_telepon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-hitam font-medium mb-2">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" placeholder="Latitude"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('latitude') border-red-500 @enderror"
                                value="{{ old('latitude', $pusat->latitude) }}">
                            @error('latitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-hitam font-medium mb-2">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" placeholder="Longitude"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam @error('longitude') border-red-500 @enderror"
                                value="{{ old('longitude', $pusat->longitude) }}">
                            @error('longitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pilihan Dinas -->
                <div class="mt-6">
                    <label class="block text-hitam font-medium mb-2">Pilih Dinas yang Diayomi</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($dinas as $d)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="dinas_{{ $d->id }}" name="dinas[]" value="{{ $d->id }}"
                                    class="rounded border-gray-300 text-kuning focus:ring-kuning"
                                    {{ in_array($d->id, old('dinas', [])) ? 'checked' : '' }}>
                                <label for="dinas_{{ $d->id }}" class="text-hitam">{{ $d->wilayah }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('dinas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-white text-hitam font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
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