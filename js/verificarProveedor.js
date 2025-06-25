//Funcion para verificar si el proveedor esta registrado 
document.getElementById('nitProveedor').addEventListener('blur', async function() {

    const nit = document.getElementById("nitProveedor").value.trim();

    //alert("nit: " + nit);

            // Evita consulta si el campo del input está vacío
        if (nit === "") {
            return;
        }

        try {
            const response = await fetch('index.php?action=verificacionNitProveedor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nitProveedor: nit })  // Enviar datos al servidor como JSON
            });

            const data = await response.json();
    
            if (data.success) {
                alert("El Proveedor ya esta Registrado");
                //limpia el campo del Nit del proveedor
                document.getElementById("nitProveedor").value = '';
            } else {
                    
            }
        } catch (error) {
            console.error('Error al obtener la información del proveedor:', error);            
        }

});