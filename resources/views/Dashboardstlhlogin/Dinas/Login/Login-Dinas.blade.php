@extends('Dashboardstlhlogin.pemerintahpusat.template.templateLogin-pusat')
@section('title', 'Dinas')

@section('content')
<div class="container mx-auto px-4 py-6 flex-grow flex items-center justify-center mt-12">
    <div class="w-full max-w-2xl mx-auto bg-kuning shadow-lg rounded-lg overflow-hidden">
        <div class="p-8 md:p-10">
            <h1 class="text-2xl font-bold text-center mb-6 text-hitam">Masuk</h1>

            <div class="max-w-xl mx-auto">
                <form action="/LaporanMasyarakat" class="space-y-6" id="loginForm">
                    @csrf
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-hitam mb-4">Akun Pemerintah daerah</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Pemda -->
                            <div>
                                <label for="username" class="block text-sm font-medium mb-1">Nama Pemda</label>
                                <input type="text" id="username" name="username" placeholder="Username"
                                    class="w-full px-4 py-3 rounded-md bg-white border-none focus:ring-2 focus:ring-hitam">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                                <input type="password" id="password" name="password" placeholder="********"
                                    class="w-full px-4 py-3 rounded-md bg-white border-none focus:ring-2 focus:ring-hitam">
                            </div>
                        </div>

                        <!-- Email dan Wilayah dalam satu baris -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" id="email" name="email" placeholder="PAL@contoh.com"
                                    class="w-full px-4 py-3 rounded-md bg-white border-none focus:ring-2 focus:ring-hitam">
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label for="wilayah" class="block text-sm font-medium mb-1">Wilayah</label>
                                <select id="wilayah" name="wilayah" 
                                    class="w-full px-4 py-3 rounded-md bg-white border-none focus:ring-2 focus:ring-hitam appearance-none">
                                    <option value="" disabled selected>Wilayah</option>
                                    <!-- Tambahkan opsi wilayah sesuai kebutuhan -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="w-full bg-white text-hitam hover:bg-gray-100 font-bold py-3 px-6 rounded-lg transition-all duration-300">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
