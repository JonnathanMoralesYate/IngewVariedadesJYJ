document.getElementById('correo').addEventListener('input', function(event) {
    const campo = event.target;
    const emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    const correoError = document.getElementById('correoError');

    if (!emailRegex.test(campo.value)) {
        campo.classList.add('is-invalid');
        correoError.style.display = 'block';
    } else {
        campo.classList.remove('is-invalid');
        correoError.style.display = 'none';
    }
});