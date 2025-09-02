document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('communicationForm');
    const submitButton = document.getElementById('submitButton');

    if (form && submitButton) {
        form.addEventListener('submit', function () {
            submitButton.disabled = true;
            submitButton.textContent = 'Enviando...';
        });
    }
});