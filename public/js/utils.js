function formatOnlyNumbers(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

document.addEventListener('DOMContentLoaded', function () {
    const eyeIcons = document.querySelectorAll('.eye-icon');

    eyeIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);

            if (passwordInput) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                this.classList.toggle('visible');
            }
        });
    });
});

document.getElementById("password").addEventListener("input", function () {
    const value = this.value;
    const strength = document.getElementById("passwordStrength");

    let nivel = 0;
    if (value.length >= 6) nivel++;
    if (/[A-Z]/.test(value)) nivel++;
    if (/[0-9]/.test(value)) nivel++;
    if (/[^A-Za-z0-9]/.test(value)) nivel++;

    if (nivel <= 1) {
        strength.textContent = "Senha fraca";
        strength.className = "password-strength fraca";
    } else if (nivel === 2 || nivel === 3) {
        strength.textContent = "Senha média";
        strength.className = "password-strength media";
    } else if (nivel >= 4) {
        strength.textContent = "Senha forte";
        strength.className = "password-strength forte";
    } else {
        strength.textContent = "";
    }
});