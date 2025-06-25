
   //Funcion al ingresar el codigo del Producto verifica si esta registrado y agrege la fecha actual automaticamente y 
document.getElementById('codProducto').addEventListener('blur', async function() {

    const codigoBarras = document.getElementById("codProducto").value.trim();

    agregarFechaActual();

        // Evita consulta si el campo del input está vacío
    if (codigoBarras === "") {
        //remueve el contenido de la eqtiqueta <p id"resultado"></p>
        document.getElementById("resultado").textContent = "";
        //limpia el campo de fecha de entrada
        document.getElementById("fechaEnt").value = "";
        return; 
    }

    try {
        const response = await fetch('index.php?action=verificacionCodigoProductos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ codProducto: codigoBarras })  
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById("resultado").innerText = "✅";
        } else {
            document.getElementById("resultado").innerText = "❌";
            document.getElementById("fechaEnt").value = "";
        }
    } catch (error) {
        console.error('Error al obtener la información del producto:', error);
        document.getElementById("resultado").innerText = "⚠️";
    }

    
});


//Funcion al ingresar el nit del Proveedor verifica si esta registrado 
document.getElementById('nitProveedor').addEventListener('blur', async function() {

    const nit = document.getElementById("nitProveedor").value.trim();

            // Evita consulta si el campo del input está vacío
        if (nit === "") {
            //remueve el contenido de la eqtiqueta <p id"resultado"></p>
            document.getElementById("resultado1").textContent = "";
            return;
        }

        try {
            const response = await fetch('index.php?action=verificacionNitProveedor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nitProveedor: nit }) 
            });

            const data = await response.json();
    
            if (data.success) {
                document.getElementById("resultado1").innerText = "✅";
            } else {
                document.getElementById("resultado1").innerText = "❌";
            }
        } catch (error) {
            console.error('Error al obtener la información del proveedor:', error);
            document.getElementById("resultado1").innerText = "⚠️";
            
        }
});


//Funcion para agregar la fecha actual de salida del producto
function agregarFechaActual() {

    const inputFechaEnt = document.getElementById("fechaEnt");

    // Obtener la fecha y hora actual
    const fechaHoraActual = new Date();

    // Obtener el año, mes, día, hora, minutos y formatearlos, // Los meses en JavaScript son de 0 a 11
    const anio = fechaHoraActual.getFullYear();
    const mes = String(fechaHoraActual.getMonth() + 1).padStart(2, '0'); 
    const dia = String(fechaHoraActual.getDate()).padStart(2, '0');
    const hora = String(fechaHoraActual.getHours()).padStart(2, '0');
    const minutos = String(fechaHoraActual.getMinutes()).padStart(2, '0');

    // Formatear la fecha y hora en el formato requerido (YYYY-MM-DDTHH:MM)
    const fechaHoraFormateada = `${anio}-${mes}-${dia}T${hora}:${minutos}`;

    // Asignar la fecha y hora formateada al input
    inputFechaEnt.value = fechaHoraFormateada;

}