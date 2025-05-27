@extends('FormLogin-Register.Template')
@section('title', 'Login')
@section('content')

@section('back_button')
            <a href="/forgot-password" class="text-black hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            @show
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 mt-6 mb-16">
        <div class="max-w-2xl mx-auto bg-kuning rounded-lg p-8 shadow-lg">
            <h1 class="text-3xl font-bold text-hitam mb-6 text-center">Konfirmasi Password Baru</h1>

            <form action="/reset-password" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block text-hitam font-medium mb-2">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="Masukan Password Baru"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-kuning focus:border-transparent bg-white"
                                    required>
                                <button type="button" id="togglePassword" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-hitam font-medium mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-kuning focus:border-transparent bg-white"
                                    required>
                                <button type="button" id="togglePasswordConfirmation" onclick="togglePasswordConfirmation()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reset Password Button -->
                <button type="submit" class="w-full bg-white text-hitam  hover:text-white  hover:ring-2 ring-white  hover:bg-opacity-90  hover:bg-kuning  font-bold py-3 px-4 rounded-full transform hover:scale-[0.98] transition-all duration-200 text-base shadow-lg mt-6">
                    Reset Password
                </button>
            </form>
        </div>
    </main>

@endsection
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const logo = document.getElementById('logo');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 0) {
                    header.classList.add('scrolled');
                    logo.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                    logo.classList.remove('scrolled');
                }
            });
        });
    </script>
</body>
</html>
