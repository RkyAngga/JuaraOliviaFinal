@extends('auth.Template')
@section('title', 'Login Success - LAPOR PAL')
@section('content')

@section('back_button')
            <a href="/" class="text-black hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            @show
    <!-- Notifikasi Sukses -->
    <div class="fixed top-20 left-0 right-0 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-2xl mx-auto success-message" role="alert">
            <strong class="font-bold">Registrasi Berhasil!</strong>
            <span class="block sm:inline"> Silakan login dengan akun yang telah Anda buat.</span>
        </div>
    </div>

    <div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
        <div class="w-full max-w-2xl mx-auto bg-kuning shadow-2xl rounded-2xl overflow-hidden">
            <!-- Form Login -->
            <div class="p-8 md:p-12">
                <h1 class="text-3xl font-bold text-center mb-8 text-hitam">Masuk</h1>

                @if(session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('login') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-6 mb-12">
                            <h2 class="text-xl font-bold text-hitam mb-8">Data Diri</h2>

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

                                <!-- Email Field -->
                                <div class="md:col-span-1">
                                    <label for="email" class="block text-base font-semibold mb-2">Email</label>
                                    <input type="email" id="email" name="email" placeholder="PAL@contoh.com"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all"
                                        value="{{ old('email') }}">
                                </div>

                                <!-- Lupa Password Link -->
                                <div class="md:col-span-1 flex items-end justify-end">
                                    <a href="{{ route('password.request') }}" class="text-merah hover:text-opacity-80 text-sm font-medium transition-colors">Lupa Password?</a>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="max-w-xs mx-auto">
                            <button type="submit" class="w-full bg-white text-hitam font-bold py-3 px-4 rounded-full hover:text-white  hover:ring-2 ring-white  hover:bg-opacity-90  hover:bg-kuning  hover:bg-opacity-90 transform hover:scale-[0.98] transition-all duration-200 text-base shadow-lg">
                                Masuk
                            </button>
                        </div>

                        <!-- Registration Link -->
                        <div class="text-center mt-6">
                            <p class="text-hitam text-sm">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-biru font-semibold hover:text-opacity-80 transition-colors">Daftar sekarang</a>
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
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 0) {
            header.classList.add('bg-kuning');
            header.classList.remove('bg-white');
        } else {
            header.classList.add('bg-white');
            header.classList.remove('bg-kuning');
        }
    });

    // Auto-hide success message after 5 seconds
    setTimeout(function() {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            successMessage.style.animation = 'fadeOut 0.5s ease-in forwards';
            setTimeout(() => successMessage.remove(), 500);
        }
    }, 5000);

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
</script>
@endsection
