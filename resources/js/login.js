// Toggle password visibility
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('togglePassword');
    if (toggleButton) {
        toggleButton.addEventListener('click', togglePassword);
    }
});

// Form validation
function validateForm() {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    let isValid = true;

    // Reset error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Username validation
    if (!username || !username.value) {
        showError('username', 'Username harus diisi');
        isValid = false;
    }

    // Password validation
    if (!password || !password.value) {
        showError('password', 'Password harus diisi');
        isValid = false;
    }

    return isValid;
}

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-merah text-sm mt-1';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

// Loading state
function showLoading() {
    const button = document.querySelector('button[type="submit"]');
    if (!button) return null;
    
    const originalText = button.textContent;
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...';
    return originalText;
}

function hideLoading(button, originalText) {
    if (!button) return;
    
    button.disabled = false;
    button.textContent = originalText;
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            const originalText = showLoading();
            if (originalText) {
            // Simulate form submission (replace with actual form submission)
            setTimeout(() => {
                form.submit();
            }, 1000);
            }
        }
    });
});