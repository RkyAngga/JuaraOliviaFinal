<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="icon" href="{{ asset('img/logo/icon.png') }}" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .min-h-screen {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .max-w-md {
            max-width: 480px;
            width: 100%;
        }
        
        .bg-white {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .bg-white::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #f2be2e 0%);
        }
        
        h2 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-6 {
            margin-bottom: 30px;
        }
        
        .bg-green-50 {
            background-color: #f0fff4;
            border-left: 4px solid #48bb78;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 25px;
            text-align: left;
            color: #2f855a;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease;
        }
        
        .text-green-700 {
            color: #2f855a;
        }
        
        .mb-4 {
            margin-bottom: 25px;
            text-align: left;
        }
        
        .block {
            display: block;
        }
        
        .text-gray-700 {
            color: #4a5568;
        }
        
        .text-sm {
            font-size: 14px;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .mb-2 {
            margin-bottom: 8px;
            padding-left: 5px;
        }
        
        .w-full {
            width: 100%;
        }
        
        .px-4 {
            padding-left: 16px;
            padding-right: 16px;
        }
        
        .py-2 {
            padding-top: 12px;
            padding-bottom: 12px;
        }
        
        .border {
            border-width: 2px;
        }
        
        .border-gray-300 {
            border-color: #e2e8f0;
        }
        
        .rounded-md {
            border-radius: 12px;
        }
        
        .focus\:outline-none:focus {
            outline: none;
        }
        
        .focus\:ring-2:focus {
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .focus\:ring-yellow-500:focus {
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        }
        
        .focus\:border-transparent:focus {
            border-color: #f2be2e;
        }
        
        input {
            padding-left: 50px !important;
            position: relative;
            font-size: 16px;
            color: #2d3748;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-container {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
            z-index: 10;
        }
        
        .text-red-500 {
            color: #e53e3e;
        }
        
        .mt-1 {
            margin-top: 8px;
        }
        
        .bg-yellow-400 {
            background: linear-gradient(135deg, #f2be2e);
            color: white;
            border: none;
            font-weight: 600;
            padding: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 18px;
        }
        
        .bg-yellow-400:hover {
            transform: translateY(-3px);
        }
        
        .bg-yellow-400:active {
            transform: translateY(0);
        }
        
        
        .text-black {
            color: white;
        }
        
        .font-medium {
            font-weight: 600;
        }
        
        .transition {
            transition: all 0.3s ease;
        }
        
        .duration-300 {
            transition-duration: 0.3s;
        }
        
        .back-link {
            margin-top: 25px;
            color: #718096;
            font-size: 15px;
        }
        
        .back-link a {
            color: #f2be2e;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .illustration {
            margin: 30px auto 20px;
            max-width: 200px;
            opacity: 0.8;
        }
        
        .illustration svg {
            width: 100%;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 576px) {
            .bg-white {
                padding: 30px 20px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            input, .bg-yellow-400 {
                padding: 14px 14px 14px 50px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="max-w-md w-full mx-4">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Lupa Password</h2>
                
                <!-- Session message -->
                @if(session('message'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <p class="text-green-700">{{ session('message') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('forgot.sendOtp') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="input-container">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                                placeholder="Masukkan email Anda" required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-4 rounded-md transition duration-300">
                        Kirim Permintaan
                    </button>
                </form>
                
                <p class="back-link">
                    Ingat password? <a href="{{ route('login') }}">Masuk disini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Animasi tombol saat dihover
        const button = document.querySelector('.bg-yellow-400');
        if (button) {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-3px)';
                button.style.boxShadow = '0 15px 25px';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
                button.style.boxShadow = '0 10px 20px rgba(102, 126, 234, 0.3)';
            });
            
            button.addEventListener('mousedown', () => {
                button.style.transform = 'translateY(1px)';
            });
            
            button.addEventListener('mouseup', () => {
                button.style.transform = 'translateY(-3px)';
            });
        }
        
        // Animasi input saat fokus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.style.borderColor = '#f2be2e';
                input.style.boxShadow = '0 0 0 4px rgba(102, 126, 234, 0.1)';
            });
            
            input.addEventListener('blur', () => {
                input.style.borderColor = '#e2e8f0';
                input.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>