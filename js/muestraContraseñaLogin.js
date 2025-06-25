document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('togglePassword');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      const passwordInput = document.getElementById('contrasena');
      const icon = this.querySelector('i');

      const tipo = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', tipo);

      icon.classList.toggle('bi-eye');
      icon.classList.toggle('bi-eye-slash');
    });
  }
});