@extends('auth.Template')
@section('title', 'Lupa Password - LAPOR PAL')
@section('content')

    <div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
        <div class="w-full max-w-2xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden">
            <!-- Form Forgot Password -->
            <div class="p-8 md:p-12">
                <h1 class="text-3xl font-bold text-center mb-8 text-hitam">Lupa Password</h1>

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
                    <div class="bg-white rounded-lg p-6 mb-2">
                        <p class="text-hitam mb-6">Masukkan alamat Email anda, kami akan mengirimkan kode OTP untuk mereset password anda melalui Email anda.</p>

<form action="{{ route('password.email') }}" method="POST" id="forgotPasswordForm">
    @csrf
    <div class="mb-6">
        <label for="email" class="block text-hitam mb-2">Email</label>
        <input type="email" id="email" name="email" placeholder="PAL@contoh.com"
            class="w-full p-3 rounded-lg bg-white text-hitam placeholder-gray-400 border border-gray-300 focus:outline-none focus:border-yellow-500"
            value="{{ old('email') }}" required>
    </div>
    <button type="submit" id="submitButton" class="w-full bg-kuning text-hitam font-bold py-3 px-4 rounded-lg hover:bg-yellow-500 hover:ring-2 ring-white hover:text-white transition duration-200 flex items-center justify-center">
        <span class="submit-text">Kirim Kode OTP</span>
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-hitam hidden" id="loadingIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>
</form>
                    </div>

                    <div class="text-center py-4">
                        <a href="{{ route('login') }}" class="text-hitam hover:text-white hover:text-opacity-80 transition-colors">
                            Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgotPasswordForm');
        const submitButton = document.getElementById('submitButton');
        const loadingIcon = document.getElementById('loadingIcon');
        const submitText = document.querySelector('.submit-text');

        if (form) {
            form.addEventListener('submit', function(e) {
                // Prevent double submission
                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }

                // Show loading state
                submitButton.disabled = true;
                loadingIcon.classList.remove('hidden');
                submitText.textContent = 'Mengirim...';
            });
        }
    });
    </script>
@endsection