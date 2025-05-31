
<div class="container mx-auto max-w-md mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Reset Password Baru</h2>
    <form method="POST" action="{{ route('password.reset.save') }}">
        @csrf
        <label class="block mb-2">Password Baru:</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2 mb-2" required>
        <label class="block mb-2">Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 mb-2" required>
        @error('password') <div class="text-red-600 mb-2">{{ $message }}</div> @enderror
        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded w-full">Reset Password</button>
    </form>
</div>

