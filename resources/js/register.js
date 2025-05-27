document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const form = document.querySelector('form');
    const nikInput = document.getElementById('nik');
    const phoneInput = document.getElementById('nomor_telepon');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');
    const submitButton = form.querySelector('button[type="submit"]');

    // Validation patterns
    const patterns = {
        nik: /^\d{16}$/,
        phone: /^\d{8,14}$/,
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/
    };

    // Error messages
    const errorMessages = {
        nik: 'NIK harus 16 digit angka',
        phone: 'Nomor telepon harus 8-14 digit angka',
        email: 'Format email tidak valid',
        password: 'Password harus minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan karakter khusus',
        passwordMatch: 'Password tidak sama'
    };

    // Real-time validation
    function validateInput(input, pattern, errorMessage) {
        const isValid = pattern.test(input.value);
        const errorElement = input.parentElement.querySelector('.error-message') || 
                            document.createElement('p');
        
        errorElement.className = 'error-message text-red-500 text-sm mt-1';
        
        if (!isValid && input.value) {
            errorElement.textContent = errorMessage;
            if (!input.parentElement.querySelector('.error-message')) {
                input.parentElement.appendChild(errorElement);
            }
            input.classList.add('border-red-500');
        } else {
            errorElement.remove();
            input.classList.remove('border-red-500');
        }
        
        return isValid;
    }

    // Password strength indicator
    function updatePasswordStrength(password) {
        let strength = 0;
        const indicators = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            number: /\d/.test(password),
            special: /[@$!%*#?&]/.test(password)
        };

        strength = Object.values(indicators).filter(Boolean).length;

        const strengthElement = passwordInput.parentElement.querySelector('.password-strength') || 
                               document.createElement('div');
        strengthElement.className = 'password-strength text-sm mt-2';

        const strengthTexts = [
            'Sangat lemah',
            'Lemah',
            'Sedang',
            'Kuat',
            'Sangat kuat'
        ];

        const strengthColors = [
            'text-red-500',
            'text-orange-500',
            'text-yellow-500',
            'text-green-500',
            'text-emerald-500'
        ];

        strengthElement.textContent = `Kekuatan password: ${strengthTexts[strength-1]}`;
        strengthElement.className = `password-strength text-sm mt-2 ${strengthColors[strength-1]}`;

        if (!passwordInput.parentElement.querySelector('.password-strength')) {
            passwordInput.parentElement.appendChild(strengthElement);
        }
    }

    // Input event listeners
    nikInput.addEventListener('input', () => validateInput(nikInput, patterns.nik, errorMessages.nik));
    phoneInput.addEventListener('input', () => validateInput(phoneInput, patterns.phone, errorMessages.phone));
    emailInput.addEventListener('input', () => validateInput(emailInput, patterns.email, errorMessages.email));
    passwordInput.addEventListener('input', () => {
        validateInput(passwordInput, patterns.password, errorMessages.password);
        updatePasswordStrength(passwordInput.value);
    });

    // Password confirmation validation
    passwordConfirmInput.addEventListener('input', () => {
        const errorElement = passwordConfirmInput.parentElement.querySelector('.error-message') || 
                            document.createElement('p');
        errorElement.className = 'error-message text-red-500 text-sm mt-1';

        if (passwordConfirmInput.value && passwordConfirmInput.value !== passwordInput.value) {
            errorElement.textContent = errorMessages.passwordMatch;
            if (!passwordConfirmInput.parentElement.querySelector('.error-message')) {
                passwordConfirmInput.parentElement.appendChild(errorElement);
            }
            passwordConfirmInput.classList.add('border-red-500');
        } else {
            errorElement.remove();
            passwordConfirmInput.classList.remove('border-red-500');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const isNikValid = validateInput(nikInput, patterns.nik, errorMessages.nik);
        const isPhoneValid = validateInput(phoneInput, patterns.phone, errorMessages.phone);
        const isEmailValid = validateInput(emailInput, patterns.email, errorMessages.email);
        const isPasswordValid = validateInput(passwordInput, patterns.password, errorMessages.password);
        const isPasswordMatch = passwordInput.value === passwordConfirmInput.value;
        const isTermsAccepted = termsCheckbox.checked;

        if (isNikValid && isPhoneValid && isEmailValid && isPasswordValid && 
            isPasswordMatch && isTermsAccepted) {
            form.submit();
        } else {
            // Show error message for terms if not checked
            if (!isTermsAccepted) {
                const termsError = termsCheckbox.parentElement.querySelector('.error-message') || 
                                  document.createElement('p');
                termsError.className = 'error-message text-red-500 text-sm mt-1';
                termsError.textContent = 'Anda harus menyetujui syarat dan ketentuan';
                if (!termsCheckbox.parentElement.querySelector('.error-message')) {
                    termsCheckbox.parentElement.appendChild(termsError);
                }
            }
        }
    });
});