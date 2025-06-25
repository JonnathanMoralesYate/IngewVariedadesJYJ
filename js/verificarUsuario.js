//Funcion para verificar si el Usuario esta registrado 
document.getElementById('documUsu').addEventListener('blur', async function() {

    const identUsua = document.getElementById("documUsu").value.trim();

            // Evita consulta si el campo del input está vacío
        if (identUsua === "") {
            return;
        }

        try {
            const response = await fetch('index.php?action=verificarUsuario', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ documUsu: identUsua })  // Enviar datos al servidor como JSON
            });

            const data = await response.json();
    
            if (data.success) {
                alert("El Empleado ya esta Registrado");
                //limpia el campo del numero documento del usuario
                document.getElementById("documUsu").value = '';
            } else {
                    
            }
        } catch (error) {
            console.error('Error al obtener la información del Usuario:', error);            
        }

});