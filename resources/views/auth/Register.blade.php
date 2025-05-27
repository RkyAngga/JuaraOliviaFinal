@extends('auth.Template')
@section('title', 'Register - LAPOR PAL')
@section('content')

    <div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
        <div class="w-full max-w-3xl mx-auto bg-kuning shadow-2xl rounded-3xl overflow-hidden">
            <!-- Form Register -->
            <div class="p-8 md:p-12">
                <h1 class="text-3xl font-bold text-center mb-8 text-hitam">Daftar</h1>

                <!-- Disclaimer Box -->
                <div class="bg-white rounded-lg p-4 mb-8 text-sm text-hitam">
                Mengapa kami meminta data ini? Layanan Lapor.pal mengumpulkan data pribadi pengguna sebagai jaminan keabsahan dari aduan atau aspirasi yang disampaikan, pengenal identitas, memverifikasi akun dan mengirim notifikasi laporan, menilai tingkat partisipasi publik, pengolahan dan analisis data, penyusunan perencanaan dan pengambilan kebijakan, monitoring dan evaluasi, dan mendorong terciptanya kebijakan yang inklusif.
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('register') }}" method="POST" class="space-y-8">
                        @csrf
                        <!-- Data Diri Section -->
                        <div class="space-y-6 mb-8">
                            <h2 class="text-xl font-bold text-hitam mb-6">Data Diri</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NIK Field -->
                                <div>
                                    <label for="nik" class="block text-base font-semibold mb-2">NIK</label>
                                    <input type="text" id="nik" name="nik" placeholder="Nomor Induk Kependudukan (KTP)"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('nik') }}">
                                </div>

                                <!-- Nama Lengkap Field -->
                                <div>
                                    <label for="nama_lengkap" class="block text-base font-semibold mb-2">Nama Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('nama_lengkap') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak Section -->
                        <div class="space-y-6 mb-8">
                            <h2 class="text-xl font-bold text-hitam mb-6">Data Kontak</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nomor Telepon Field -->
                                <div>
                                    <label for="nomor_telepon" class="block text-base font-semibold mb-2">Nomor Telepon</label>
                                    <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="Minimal 12 Angka"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('nomor_telepon') }}">
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-base font-semibold mb-2">Email</label>
                                    <input type="email" id="email" name="email" placeholder="PAL@contoh.com"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Akun Section -->
                        <div class="space-y-6 mb-8">
                            <h2 class="text-xl font-bold text-hitam mb-6">Data Akun</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Username Field -->
                                <div>
                                    <label for="username" class="block text-base font-semibold mb-2">User Name</label>
                                    <input type="text" id="username" name="username" placeholder="Username"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('username') }}">
                                </div>

                                <!-- Password Field -->
                                <div class="rounded-lg form-field transition-transform duration-200">
                                    <label for="password" class="block text-base font-semibold mb-2">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" placeholder="**********"
                                            class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all pr-10">
                                        <button type="button" id="togglePassword" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Confirmation Field -->
                                <div class="rounded-lg form-field transition-transform duration-200">
                                    <label for="password_confirmation" class="block text-base font-semibold mb-2">Password Confirmation</label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="**********"
                                            class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all pr-10">
                                        <button type="button" id="togglePasswordConfirmation" onclick="togglePasswordConfirmation()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Hint -->
                                <div class="md:col-span-2">
                                    <p class="text-sm text-merah">*Minimal 8 karakter dan harus berisi kombinasi huruf kapital, huruf kecil, angka dan karakter khusus (@$!%*#?&)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions Checkbox -->
                        <div class="flex items-center space-x-2 mb-8">
                            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 peer">
                            <label for="terms" class="text-sm text-hitam">
                                Saya telah membaca dan menyetujui
                                <a href="#" class="text-biru hover:text-white hover:text-opacity-80">Syarat dan Ketentuan Layanan</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <div class="max-w-xs mx-auto">
                            <button type="submit" class="w-full bg-white text-hitam font-bold py-3 px-4 hover:text-white hover:bg-kuning hover:ring-2 ring-white  rounded-full hover:bg-opacity-90 transform hover:scale-[0.98] transition-all duration-200 text-base shadow-lg">
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-6">
                            <p class="text-hitam text-sm">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-biru hover:text-white font-semibold hover:text-opacity-80 transition-colors">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle untuk password utama
        const togglePasswordBtn = document.getElementById('togglePassword');
        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener('click', togglePassword);
        }

        // Toggle untuk konfirmasi password
        const togglePasswordConfirmationBtn = document.getElementById('togglePasswordConfirmation');
        if (togglePasswordConfirmationBtn) {
            togglePasswordConfirmationBtn.addEventListener('click', togglePasswordConfirmation);
        }
    });

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        
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

    function togglePasswordConfirmation() {
        const passwordInput = document.getElementById('password_confirmation');
        const toggleButton = document.getElementById('togglePasswordConfirmation');
        
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
