@extends('auth.Template')
@section('title', 'Login - LAPOR PAL')
@section('content')

    <div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
        <div class="w-full max-w-2xl mx-auto bg-kuning shadow-2xl rounded-2xl overflow-hidden">

            <!-- Form Login -->
            <div class="p-8 md:p-12">
                <h1 class="text-3xl font-bold text-center mb-8 text-hitam">Masuk</h1>

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <div class="py-1">
                                <svg class="w-6 h-6 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Login Gagal!</p>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <div class="py-1">
                                <svg class="w-6 h-6 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Berhasil!</p>
                                <p>{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-6 mb-12">
                            <h2 class="text-xl font-bold text-hitam mb-8">Data Diri</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Username Field -->
                                <div>
                                    <label for="username" class="block text-base font-semibold mb-2">User Name</label>
                                    <input type="text" id="username" name="username" placeholder="Username"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all @error('username') border-red-500 @enderror"
                                        value="{{ old('username') }}" required>
                                </div>

                                <!-- Password Field -->
                                <div class="rounded-lg form-field transition-transform duration-200">
                                    <label for="password" class="block text-base font-semibold mb-2">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" placeholder="**********"
                                            class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all pr-10 @error('password') border-red-500 @enderror"
                                            required>
                                        <button type="button" id="togglePassword" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Lupa Password Link -->
                                <div class="md:col-span-2 flex justify-end">
                                    <a href="{{ route('password.request') }}" class="text-merah hover:text-white hover:text-opacity-80 text-sm font-medium transition-colors">Lupa Password?</a>
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
                                <a href="{{ route('register') }}" class="text-biru hover:text-white font-semibold hover:text-opacity-80 transition-colors">Daftar sekarang</a>
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

    // Auto-hide notifications after 5 seconds
    setTimeout(function() {
        const notifications = document.querySelectorAll('.animate-fade-in');
        notifications.forEach(notification => {
            notification.style.transition = 'opacity 0.5s ease-out';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 500);
        });
    }, 5000);
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection
