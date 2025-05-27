@extends('Dashboardstlhlogin.Admin.Template.Template')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section dengan efek gradien -->
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="flex-grow text-center">
                <h2 class="text-3xl font-bold text-hitam mb-8">Akun Pemerintah Pusat</h2>
            </div>
        </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Container dengan efek card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl p-8 shadow-xl">
            <form action="{{ route('admin.akun.pusat.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 backdrop-blur-sm p-6 rounded-xl space-y-6 shadow-sm">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Dasar</h3>
                            
                            <!-- Nama Pemerintah Pusat -->
                            <div class="space-y-2">
                                <label for="nama_lengkap" class="block text-gray-700 font-medium">Nama Pemerintah Pusat</label>
                                <div class="relative">
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" 
                                        class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                        value="{{ old('nama_lengkap') }}" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username dan Email -->
                            <div class="space-y-4">
                                <div class="relative">
                                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                                    <input type="text" id="username" name="username" placeholder="Username" 
                                        class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                        value="{{ old('username') }}" required>
                                    @error('username')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                    <input type="email" id="email" name="email" placeholder="email@contoh.com"
                                        class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Latitude di kolom kiri -->
                        <div class="space-y-2">
                            <label for="latitude" class="block text-hitam font-medium">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" placeholder="Latitude"
                                class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300 @error('latitude') border-red-500 @enderror"
                                value="{{ old('latitude') }}">
                            @error('latitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Profil -->
                        <div>
                            <label for="foto_profil" class="block text-hitam font-medium mb-2">Foto Profil</label>
                            <input type="file" id="foto_profil" name="foto_profil" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg bg-white border-none focus:ring-2 focus:ring-hitam">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 backdrop-blur-sm p-6 rounded-xl space-y-6 shadow-sm">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Keamanan & Kontak</h3>

                            <!-- Password Fields -->
                            <div class="space-y-4">
                                <div class="relative">
                                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                                    <input type="password" id="password" name="password" placeholder="********"
                                        class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                        required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="relative">
                                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********"
                                        class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                        required>
                                    @error('password_confirmation')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="relative">
                                <label for="nomor_telepon" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-hitam focus:ring-2 focus:ring-hitam transition-all duration-300"
                                    value="{{ old('nomor_telepon') }}" required>
                                @error('nomor_telepon')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Longitude di kolom kanan -->
                        <div class="space-y-2">
                            <label for="longitude" class="block text-hitam font-medium">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" placeholder="Longitude"
                                class="w-full px-4 py-3 rounded-lg bg-white border-2 border-gray-200 focus:border-kuning focus:ring-2 focus:ring-kuning transition-all duration-300 @error('longitude') border-red-500 @enderror"
                                value="{{ old('longitude') }}">
                            @error('longitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pilihan Dinas dengan Card Style -->
                <div class="bg-gray-50 backdrop-blur-sm p-6 rounded-xl shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Dinas yang Diayomi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($dinas as $d)
                            <label for="dinas_{{ $d->id }}" class="flex items-center p-3 rounded-lg border-2 border-gray-200 hover:border-hitam cursor-pointer transition-all duration-300">
                                <input type="checkbox" id="dinas_{{ $d->id }}" name="dinas[]" value="{{ $d->id }}"
                                    class="rounded border-gray-300 text-kuning focus:ring-kuning mr-3"
                                    {{ in_array($d->id, old('dinas', [])) ? 'checked' : '' }}>
                                <span class="text-gray-700">{{ $d->wilayah }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('dinas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button dengan efek hover -->
                <div class="flex flex-col space-y-4">
                    <button type="submit" class="bg-kuning text-hitam font-bold py-4 px-8 rounded-xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center space-x-2">
                        <span>Buat Akun</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </button>
                    
                    <a href="{{ route('admin.akun') }}" class="bg-gray-100 text-hitam font-medium py-3 px-8 rounded-xl hover:bg-gray-200 transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
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

<!-- Modal Sukses yang Diperbarui -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl p-8 max-w-sm mx-auto text-center transform transition-all duration-300 scale-90 opacity-0">
            <div class="mb-4">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h3>
            <p class="text-gray-600 mb-6">Akun baru telah berhasil dibuat.</p>
        </div>
    </div>
</div>

<script>
function showSuccessModal(event) {
    event.preventDefault();
    const modal = document.getElementById('successModal');
    const modalContent = modal.querySelector('div > div');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-90', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    setTimeout(() => {
        window.location.href = '/admin/akun';
    }, 2000);
}

document.getElementById('successModal').addEventListener('click', function(event) {
    if (event.target === this) {
        const modalContent = this.querySelector('div > div');
        modalContent.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            this.classList.add('hidden');
        }, 300);
    }
});

function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleButton = passwordInput.nextElementSibling;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        `;
    } else {
        passwordInput.type = 'password';
        toggleButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        `;
    }
}
</script>
@endsection