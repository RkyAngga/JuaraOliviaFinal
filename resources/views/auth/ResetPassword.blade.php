<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Baru</title>
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
            background-color: #f7fafc;
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
            margin-bottom: 15px;
        }

        .subtitle {
            color: #718096;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .mb-4 {
            margin-bottom: 25px;
            text-align: left;
        }

        .mb-6 {
             margin-bottom: 30px; /* Jarak untuk error message */
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
            padding: 12px 16px 12px 50px;
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
                <h2>Reset Password Baru</h2>
                <p class="subtitle">Password baru Anda harus berbeda dari password sebelumnya.</p>
                
                <form method="POST" action="{{ route('password.reset.save') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block label-style">Password Baru</label>
                        <div class="input-container">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="input-field" placeholder="Masukkan password baru" required>
                        </div>
                    </div>

                    <div class="mb-6"> <label for="password_confirmation" class="block label-style">Konfirmasi Password</label>
                        <div class="input-container">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Konfirmasi password baru" required>
                        </div>
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">
                        Reset Password
                    </button>
                </form>

                 <p class="back-link">
                    Kembali ke halaman <a href="{{ route('login') }}">Masuk</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Animasi interaktif untuk elemen form (sama seperti sebelumnya)
        document.addEventListener('DOMContentLoaded', function() {
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

            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach(input => {
                const icon = input.previousElementSibling;
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