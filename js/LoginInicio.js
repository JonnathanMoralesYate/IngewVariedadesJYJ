document.addEventListener("DOMContentLoaded", function () {
  const loginBtn = document.getElementById("login_inic");
  const loginForm = document.getElementById("login_form");
  const cerrarBtn = document.getElementById("cerrarL");

  // Mostrar/Ocultar formulario
  loginBtn.addEventListener("click", function (event) {
    event.preventDefault();
    loginForm.style.display =
      loginForm.style.display === "block" ? "none" : "block";
  });

  // Cerrar con botón X
  cerrarBtn.addEventListener("click", function () {
    loginForm.style.display = "none";
  });

  // Cerrar al hacer clic fuera
  document.addEventListener("click", function (event) {
    const isClickInside = loginForm.contains(event.target) || loginBtn.contains(event.target);
    if (!isClickInside) {
      loginForm.style.display = "none";
    }
  });

  // Cerrar con tecla ESC
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      loginForm.style.display = "none";
    }
  });
});