
<div class="container mx-auto max-w-md mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Masukkan Kode OTP</h2>
    @if(session('message')) <div class="mb-2 text-green-600">{{ session('message') }}</div> @endif
    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <label class="block mb-2">Kode OTP:</label>
        <input type="text" name="otp" maxlength="6" class="w-full border rounded px-3 py-2 mb-2" required>
        @error('otp') <div class="text-red-600 mb-2">{{ $message }}</div> @enderror
        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded w-full">Lanjutkan</button>
    </form>
</div>

