document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formReporte");
    const fechaInc = form.querySelector('input[name="fechaInc"]');
    const fechaFin = form.querySelector('input[name="fechaFin"]');
    

    form.addEventListener("submit", function (e) {
        const hoy = new Date().toISOString().split("T")[0];

        if (fechaInc.value > hoy) {
            alert("La fecha inicial no puede ser una fecha futura.");
            e.preventDefault();
            return;
        }

        if (fechaFin.value < fechaInc.value) {
            alert("La fecha final no puede ser anterior a la fecha inicial.");
            e.preventDefault();
            return;
        }
    });
});