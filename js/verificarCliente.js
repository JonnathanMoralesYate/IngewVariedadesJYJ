// Funcion para verificar si el cliente esta registrado
document.getElementById('documCliente').addEventListener('blur', async function () {
    
    // Obtener el código de barras
    const numDocum = document.getElementById('documCliente').value;

    // Evita consulta si el campo del input está vacío
    if (numDocum === "") {
        return;
    }

    try {
        const response = await fetch("index.php?action=verificacionCliente", {
        method: "POST",
        headers: {
        "Content-Type": "application/json",
        },
        body: JSON.stringify({ numIdentCliente: numDocum }), // Enviar datos al servidor como JSON
        });

        const data = await response.json();

        if (data.success) {
            alert("El Cliente ya esta Registrado");
            //limpia el campo de numero documento del cliente
            document.getElementById("documCliente").value = '';
        } else {
            
        }
    } catch (error) {
        console.error("Error al obtener la información del Cliente:", error);
    }

});







