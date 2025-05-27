@extends('auth.Template')
@section('title', 'Lupa Password - LAPOR PAL')
@section('content') 

    <div class="container mx-auto px-2 py-6 flex-grow flex items-center justify-center mt-12">
        <div class="w-full max-w-2xl mx-auto bg-kuning shadow-2xl rounded-2xl overflow-hidden">
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
                    <div class="bg-white rounded-lg p-6 mb-8">
                        <p class="text-hitam mb-6">Masukkan alamat Email anda, kami akan mengirimkan alamat untuk mereset password anda melalui Email anda.</p>

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="block text-hitam mb-2">Email</label>
                                <input type="email" id="email" name="email" placeholder="PAL@contoh.com"
                                    class="w-full p-3 rounded-lg bg-white text-hitam placeholder-gray-400 border border-gray-300 focus:outline-none focus:border-yellow-500"
                                    value="{{ old('email') }}">
                            </div>

                            <button type="submit" class="w-full bg-kuning text-hitam font-bold py-3 px-4 rounded-lg hover:bg-kuning hover:ring-2 ring-white hover:text-white transition duration-200">
                                Kirim Permintaan
                            </button>
                        </form>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-white hover:text-hitam hover:text-opacity-80 transition-colors">
                            Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
