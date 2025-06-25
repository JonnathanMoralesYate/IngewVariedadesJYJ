// Funcion para verificar codigo del producto ya esta registrado
document.getElementById('codProduc').addEventListener('blur', async function () {
    
    // Obtener el código de barras
    const codigoBarras = document.getElementById('codProduc').value;

        // Evita consulta si el campo del input está vacío
        if (codigoBarras === "") {
            return;
        }

        try {
            const response = await fetch(
            "index.php?action=verificacionCodigoProductos",
            {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ codProducto: codigoBarras }), // Enviar datos al servidor como JSON
            }
            );

                // Conviértelo a un objeto JSON
                const data = await response.json();

                    if (data.success) {
                            alert("El Codigo de Barras ya esta Registrado");
                            //limpia el campo del Codigo del producto
                            document.getElementById("codProduc").value = '';
                        } else {
                            
                        }
        } catch (error) {
            console.error('Error al verificar Codigo del Producto:', error);
            }

});