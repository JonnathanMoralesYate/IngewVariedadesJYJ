
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('contrasena');
    const icon = this.querySelector('i'); // Obtén el elemento <i> dentro del botón

    // Cambiar el tipo de input entre 'password' y 'text'
    const tipo = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', tipo);

    // Alternar las clases de los íconos para cambiar entre ojo y ojo tachado
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
});


document.getElementById('contrasena').addEventListener('input', function(event) {
    const campo = event.target;
    const contrasenaError = document.getElementById('passwordError');
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!regex.test(campo.value)) {
        campo.classList.add('is-invalid');
        contrasenaError.style.display = 'block';
    } else {
        campo.classList.remove('is-invalid');
        contrasenaError.style.display = 'none';
    }
});
