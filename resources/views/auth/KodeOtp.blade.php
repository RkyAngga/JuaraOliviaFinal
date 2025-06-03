<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode OTP</title>
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
            background-color: #f7fafc; /* Menambahkan warna latar body */
        }
        
        .container-wrapper {
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
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
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
            background: linear-gradient(90deg, #f2be2e, #f59e0b);
        }
        
        h2 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px; /* Sedikit penyesuaian margin */
        }

        .subtitle {
            color: #718096;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        /* Style untuk notifikasi sukses */
        .success-message {
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
        
        .mb-4 {
            margin-bottom: 25px;
            text-align: left;
        }
        
        .block {
            display: block;
        }
        
        .label-style {
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            padding-left: 5px;
        }
        
        .w-full {
            width: 100%;
        }
        
        .input-field {
            width: 100%;
            padding: 12px 16px 12px 50px; /* Padding disesuaikan untuk ikon */
            border-width: 2px;
            border-color: #e2e8f0;
            border-radius: 12px;
            outline: none;
            font-size: 16px;
            color: #2d3748;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
            border-color: #f2be2e;
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
        
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 8px;
            text-align: left;
            padding-left: 5px;
        }
        
        .submit-button {
            width: 100%;
            background: linear-gradient(135deg, #f2be2e, #f59e0b);
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
        
        .submit-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .submit-button:active {
            transform: translateY(0);
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
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-wrapper">
        <div class="max-w-md">
            <div class="bg-white">
                <h2 class="text-2xl font-bold">Masukkan Kode OTP</h2>
                <p class="subtitle">Kami telah mengirimkan kode verifikasi ke email Anda.</p>
                
                @if(session('message'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('message') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="otp" class="block label-style">Kode OTP</label>
                        <div class="input-container">
                            <i class="fas fa-key input-icon"></i>
                            <input type="text" id="otp" name="otp" maxlength="6" class="input-field" placeholder="Masukkan 6 digit kode" required>
                        </div>
                        @error('otp')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">
                        Lanjutkan
                    </button>
                </form>
                
                <p class="back-link">
                    Tidak menerima kode? <a href="#">Kirim Ulang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Animasi interaktif untuk elemen form
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi tombol
            const button = document.querySelector('.submit-button');
            if (button) {
                button.addEventListener('mouseenter', () => {
                    button.style.transform = 'translateY(-3px)';
                    button.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.15)';
                });
                button.addEventListener('mouseleave', () => {
                    button.style.transform = 'translateY(0)';
                    button.style.boxShadow = 'none';
                });
            }

            // Animasi input
            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach(input => {
                const icon = input.previousElementSibling; // Mengambil ikon
                input.addEventListener('focus', () => {
                    input.parentElement.style.borderColor = '#f2be2e';
                    if(icon) icon.style.color = '#f2be2e';
                });
                input.addEventListener('blur', () => {
                    input.parentElement.style.borderColor = '#e2e8f0';
                    if(icon) icon.style.color = '#a0aec0';
                });
            });
        });
    </script>
</body>
</html>