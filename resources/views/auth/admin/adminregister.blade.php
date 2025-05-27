@extends('auth.Template')

@section('title', 'Admin Registration - LAPOR PAL')

@section('content')
<div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
    <div class="w-full max-w-2xl mx-auto bg-kuning shadow-2xl rounded-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <h1 class="text-3xl font-bold text-center mb-8 text-hitam">Admin Registration</h1>

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-6 h-6 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Registration Failed!</p>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="max-w-2xl mx-auto">
                <form action="{{ route('admin.register.submit') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-6 mb-12">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nama Lengkap Field -->
                            <div>
                                <label for="nama_lengkap" class="block text-base font-semibold mb-2">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all @error('nama_lengkap') border-red-500 @enderror"
                                    value="{{ old('nama_lengkap') }}" required>
                            </div>

                            <!-- Username Field -->
                            <div>
                                <label for="username" class="block text-base font-semibold mb-2">Username</label>
                                <input type="text" id="username" name="username" placeholder="Masukkan username"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all @error('username') border-red-500 @enderror"
                                    value="{{ old('username') }}" required>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-base font-semibold mb-2">Email</label>
                                <input type="email" id="email" name="email" placeholder="Masukkan email"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                    value="{{ old('email') }}" required>
                            </div>

                            <!-- Nomor Telepon Field -->
                            <div>
                                <label for="nomor_telepon" class="block text-base font-semibold mb-2">Nomor Telepon</label>
                                <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="Masukkan nomor telepon"
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all @error('nomor_telepon') border-red-500 @enderror"
                                    value="{{ old('nomor_telepon') }}" required>
                            </div>

                            <!-- Password Field -->
                            <div class="rounded-lg form-field transition-transform duration-200">
                                <label for="password" class="block text-base font-semibold mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all pr-10 @error('password') border-red-500 @enderror"
                                        required>
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="rounded-lg form-field transition-transform duration-200">
                                <label for="password_confirmation" class="block text-base font-semibold mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password"
                                        class="w-full px-4 py-3 rounded-lg bg-white border border-hitam focus:ring-2 focus:ring-[#FFC436] focus:border-transparent transition-all pr-10"
                                        required>
                                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="max-w-xs mx-auto">
                        <button type="submit" class="w-full bg-white text-hitam font-bold py-3 px-4 rounded-full hover:text-white hover:ring-2 ring-white hover:bg-opacity-90 hover:bg-kuning transform hover:scale-[0.98] transition-all duration-200 text-base shadow-lg">
                            Register
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-6">
                        <p class="text-hitam text-sm">
                            Sudah memiliki akun?
                            <a href="/login" class="text-biru font-semibold hover:text-opacity-80 hover:text-white transition-colors">Login here</a>
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