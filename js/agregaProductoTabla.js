
// Funcion obtener los datos del producto al ingresar el código de barras
document.getElementById('codProductoS').addEventListener('input', async function () {
    
    // Obtener el código de barras
    const codigoBarras = document.getElementById('codProductoS').value;

    // Evita consulta si el campo del input está vacío
    if (codigoBarras === "") {
        return;
    }

    // Llamamos a la función para obtener el id del producto, el resultado es un string
    const idProducto = await obtenerIdProducto(codigoBarras);

    //Funcion que verifica si el producto tiene existencias en inventario para la venta, , el resultado es un string
    const cantidadActual = await  existenciaInventario(idProducto);

    //Convertimos el resultado en numero
    const CantActual = parseFloat(cantidadActual);

        //Al convertirlo no es un numero  el valor "NaN"
        if (isNaN(CantActual)) {

            alert("Realice el registro de entrada del producto");
            // Limpiar el campo de código de barras después de agregar el producto
            document.getElementById('codProductoS').value = '';

        } else {

            if (CantActual > 0) {

                obtenerInforProducto(idProducto, CantActual);

            }else if(CantActual < 1){

                alert("Producto sin stock disponible o agotado");
                // Limpiar el campo de código de barras después de agregar el producto
                document.getElementById('codProductoS').value = '';
            } 
        }

});

    //Funcion traer la informacion del producto
    async function obtenerInforProducto(idProducto, CantActual) {

            try {
                const response = await fetch(
                "index.php?action=informacionProducto",
                {
                method: "POST",
                headers: {
                "Content-Type": "application/json",
                },
                body: JSON.stringify({ idProducto: idProducto }), 
                });

                const data = await response.json();

                    if (data.success) {
                        const producto = data.producto;
                        agregarProductoATabla(producto, CantActual);  
                    }

            } catch (error) {
            console.error('Error al obtener los datos del producto:', error);
            }
        }


// Función para agregar el producto a la tabla
function agregarProductoATabla(producto, CantActual) {

    const tabla = document.getElementById('productTableBody');

    let productoExistente = false;

    // Verificar si el producto ya está en la tabla
for (let i = 0; i < tabla.rows.length; i++) {
    const fila = tabla.rows[i];
    const codigoProductoEnTabla = fila.cells[1].textContent; // Columna de código

    if (codigoProductoEnTabla === producto.CodProducto) {
        // Si el producto ya existe, actualizar la cantidad
        const cantidadInput = fila.cells[5].querySelector('input');

        // Verificar si la cantidad actual es menor que la cantidad máxima
        if (parseInt(cantidadInput.value) < CantActual) {

            // Aumentar la cantidad
            cantidadInput.value = parseInt(cantidadInput.value) + 1;

            // Actualizar total de esa fila
            actualizarTotal(fila, producto.PrecioVenta, cantidadInput.value);
            productoExistente = true;

            // Limpiar el campo de código de barras después de agregar el producto
            document.getElementById('codProductoS').value = '';
            break;

        } else {

            // Si ya no se puede agregar más, mostrar el mensaje de error
            alert("No se puede agregar más productos, se agotó el producto");
            
            // Limpiar el campo de código de barras después de intentar agregar el producto
            document.getElementById('codProductoS').value = '';
            productoExistente = true;
            break;

        }
    }
}

    // Si el producto no existe, agregarlo a la tabla
    if (!productoExistente) {
        // Crear una nueva fila
        const fila = document.createElement('tr');
        
        // Crear celdas para la fila
        const itemCell = document.createElement('td');
        const codigoCell = document.createElement('td');
        const nombreCell = document.createElement('td');
        const contenidoCell = document.createElement('td');
        const precioCell = document.createElement('td');
        const cantidadCell = document.createElement('td');
        const totalCell = document.createElement('td');
        const accionCell = document.createElement('td');

        // Asignar valores a las celdas
        itemCell.textContent = tabla.rows.length + 1;  // Número de item
        codigoCell.textContent = producto.CodProducto;
        nombreCell.textContent = producto.Producto;
        contenidoCell.textContent = producto.Contenido;
        precioCell.textContent = `$${producto.PrecioVenta.toLocaleString()}`;
        
        // Input de cantidad
        const cantidadInput = document.createElement('input');
        cantidadInput.type = 'number';
        cantidadInput.value = 1;
        cantidadInput.min = 1;
        cantidadInput.max = CantActual;
        cantidadInput.addEventListener('input', function (){
            let cantidad = cantidadInput.value;
                if (cantidad > CantActual) {
                    alert(`La cantidad maxima que se puede agregar para la venta ${CantActual}`);
                    cantidadInput.value = CantActual;
                    cantidad = CantActual; // Ajustar cantidad para evitar errores
                }   
        });
        cantidadInput.addEventListener('input', function () {
            actualizarTotal(fila, producto.PrecioVenta, cantidadInput.value);
        });
        cantidadCell.appendChild(cantidadInput);

        // Total calculado
        totalCell.textContent = `$${producto.PrecioVenta.toLocaleString()}`;

        // Botón para quitar el producto
        const quitarBtn = document.createElement('button');
        quitarBtn.textContent = 'Quitar';
        quitarBtn.className = 'btn btn-outline-secondary';
        quitarBtn.addEventListener('click', function () {
            fila.remove();
            actualizarTotalVenta();
        });

        accionCell.appendChild(quitarBtn);

        // Agregar todas las celdas a la fila
        fila.appendChild(itemCell);
        fila.appendChild(codigoCell);
        fila.appendChild(nombreCell);
        fila.appendChild(contenidoCell);
        fila.appendChild(precioCell);
        fila.appendChild(cantidadCell);
        fila.appendChild(totalCell);
        fila.appendChild(accionCell);

        // Agregar la fila a la tabla
        tabla.appendChild(fila);

        // Limpiar el campo de código de barras después de agregar el producto
        document.getElementById('codProductoS').value = '';
    }

    // Actualizar el total de la venta
    actualizarTotalVenta();
}

// Función para actualizar el total de una fila
function actualizarTotal(fila, precioUnitario, cantidad) {
    const totalCell = fila.cells[6];
    const total = precioUnitario * cantidad;
    totalCell.textContent = `$${total.toLocaleString()}`;
    actualizarTotalVenta();
}

// Función para actualizar el total de la venta
function actualizarTotalVenta() {
    const filas = document.querySelectorAll('#productTableBody tr');
    let totalVenta = 0;
    filas.forEach(fila => {
        const totalCell = fila.cells[6];
        const total = parseFloat(totalCell.textContent.replace('$', '').replace('.', '')) || 0;
        totalVenta += total;
    });
    document.getElementById('totalVenta').textContent = `$${totalVenta.toLocaleString()}`;
}



//evento para registrar datos de salida productos
document.getElementById('registrarSalida').addEventListener('click', async function() {

    // Selecciona todas las filas dentro de <tbody>
    const filas = document.querySelectorAll('#productTableBody tr'); 

    // Creamos un array para almacenar la información extraída
    let datosSalida = [];

    // Obtener los valores de los inputs fijos (fuera de la tabla)
    const cliente = document.getElementById('numIdentCliente').value;

    // Llamamos a la función para obtener el id del cliente
    const clienteId = await obtenerIdCliente(cliente);  

    //Convertimos el resultado en numero
    const idCliente = parseFloat(clienteId);

    if (isNaN(idCliente)) {
        alert('Dato del Cliente Invalidos (null).');
        return;
    }

    const fechaSal = document.getElementById('fechaSal').value; 
    const formaPago = document.getElementById('tipoPago').value; 

    // Validación de datos fijos (cliente, fecha y forma de pago)
    if (!cliente || !fechaSal || !formaPago) {
        alert("Por favor, complete todos los campos antes de registrar.");
        return; // Si falta algún dato, no se envían los datos
    }

    // Iteramos sobre las filas de la tabla
    for (let fila of filas) {
        // Obtén todas las celdas de la fila
        const celdas = fila.getElementsByTagName('td'); 
        
        // Verifica que hay celdas en la fila
        if (celdas.length > 0) {

            const codProducto = celdas[1].innerText.trim();
            
            // Llamamos a la función para obtener el id del producto
            const idProducto = await obtenerIdProducto(codProducto);  

            // Accedemos al valor del input dentro de la celda de "Cantidad"
            const cantidadInput = celdas[5].querySelector('input');  // Asumimos que el input está dentro de la celda 5
            const cantidad = cantidadInput ? cantidadInput.value : '';  // Extraemos el valor del input

            // Si la cantidad está vacía o es 0, no se debe registrar este producto
            if (!cantidad || cantidad <= 0) {
                alert("Por favor, ingrese una cantidad válida para cada producto.");
                return;
            }

            // Total, lo tomamos de la celda correspondiente
            const total = celdas[6].innerText.trim();
            const precio = parseInt(total.replace('$', '').replace('.', ''), 10);  // Convertimos el valor de precio a número

            // Verificamos que el total también esté disponible
            if (!total || total <= 0) {
                alert("El total no es válido.");
                return;
            }

            // Agregamos la información de la fila al array de datos
            datosSalida.push({
                idProducto,          
                idCliente,
                fechaSal,
                cantidad,        
                precio,           
                formaPago,  
            });
        }
    }

    // Si no hay productos en la tabla, mostrar alerta
    if (datosSalida.length === 0) {
        alert("No hay productos para registrar.");
        return;
    }

    registroSalProductos(datosSalida);
});


    //Funcion para registrar salida de productos
    function registroSalProductos(datosSalida) {

            // Enviar los datos al servidor usando AJAX (fetch)
            fetch('index.php?action=registrarSalProductos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosSalida)
                })

                .then(response => response.text())  // Cambié a 'text()' para obtener la respuesta en formato texto
                .then(text => {

            try {

                const data = JSON.parse(text);  // Intenta convertir a JSON

                //Funcion para actualizar inventario con respecto de salidas del producto
                actualizarInventario(datosSalida);

            } catch (error) {

            console.error('Error al convertir la respuesta:', error);
            alert('Hubo un error al registrar los datos. La respuesta del servidor no es válida.');

            }
            })
            .catch(error => {

                console.error('Error al enviar los datos:', error);
                alert('Hubo un error al registrar los datos. Inténtalo nuevamente.');

            });

    }



    //Funcion asincrona para actualizar inventario
    function actualizarInventario(datosSalida) {

            // Enviar los datos al servidor usando AJAX (fetch)
            fetch('index.php?action=actualizarStock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosSalida)
                })

                .then(response => response.text())  // Cambié a 'text()' para obtener la respuesta en formato texto
                .then(text => {

            try {

                const data = JSON.parse(text);  // Intenta convertir a JSON

                //Funcion para actualizar puntos con respecto de salidas del producto
                actualizarPuntosCliente(datosSalida);

            } catch (error) {
                console.error('Error al convertir la respuesta:', error);
                alert('Hubo un error al actualizar los datos. La respuesta del servidor no es válida.');
            }
            })
            .catch(error => {
                console.error('Error al enviar los datos:', error);
                alert('Hubo un error al actualizar los datos. Inténtalo nuevamente.');
            });
    }


    //Funcion asincrona para actualizar inventario
    function actualizarPuntosCliente(datosSalida) {

            // Enviar los datos al servidor usando AJAX (fetch)
            fetch('index.php?action=actualizarPuntosCliente', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosSalida)
                })

                .then(response => response.text())  // Cambié a 'text()' para obtener la respuesta en formato texto
                .then(text => {

            try {

                const data = JSON.parse(text);  // Intenta convertir a JSON

                //mensaje proceso terminado y borrar datos de tabla o actualizar pagina ??
                alert('Se ha Registardo con exito los Productos');
                // Recargar la página
                location.reload();

            } catch (error) {
                console.error('Error al convertir la respuesta:', error);
                alert('Hubo un error al actualizar los datos. La respuesta del servidor no es válida.');
            }
            })
            .catch(error => {
                console.error('Error al enviar los datos:', error);
                alert('Hubo un error al actualizar los datos. Inténtalo nuevamente.');
            });        
    }



    // Función asincrónica para obtener el idProducto
    async function obtenerIdProducto(codigoBarras) {

        if (codigoBarras) {

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

                // Verifica que data.producto esté disponible y tenga idProducto
                if (data.producto && data.producto.idProducto) {

                    return data.producto.idProducto;

                } else {
                    alert('Datos del producto no disponibles.');
                    return null;
                }
            } else {
                alert('No se encontró el producto.');
                return null;
            }
            } catch (error) {
                console.error('Error al obtener el id del producto:', error);
                return null;
            }
        }
        return null;
    }



    // Función asincrónica para obtener el idProducto
    async function obtenerIdCliente(cliente) {

        try {
            const response = await fetch("index.php?action=verificacionCliente", {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ numIdentCliente: cliente }), // Enviar datos al servidor como JSON
            });

            // Conviértelo a un objeto JSON
            const data = await response.json();
    
            if (data.success) {

                // Verifica que data.cliente esté disponible y tenga idCliente
                if (data.cliente && data.cliente.idCliente) {
                    return data.cliente.idCliente;
                } else {
                    alert('Datos del Cliente no disponibles.');
                    return null;
                }
            } else {
                return null;
            }
        } catch (error) {
            console.error('Error al obtener el id del Cliente:', error);
            return null;
        }
    }


    //Funcion al ingresar identificacion verifica si esta registrado el cliente y agrege la fecha actual automaticamente
    document.getElementById('numIdentCliente').addEventListener('blur', async function()  {

        // Obtén el valor del input
        const numCliente = document.getElementById("numIdentCliente").value.trim();

        // Evita consulta si el campo del input está vacío
        if (numCliente === "") {
            //remueve el contenido de la eqtiqueta <p id"resultado"></p>
            document.getElementById("resultado1").textContent = "";
            //limpia el campo de fecha de entrada
            document.getElementById("fechaSal").value = '';
            return;
        }

    try {
        const response = await fetch("index.php?action=verificacionCliente", {
        method: "POST",
        headers: {
        "Content-Type": "application/json",
        },
        body: JSON.stringify({ numIdentCliente: numCliente }), // Enviar datos al servidor como JSON
        });

        const data = await response.json();

        if (data.success) {
        document.getElementById("resultado1").innerText = "✅";
        agregarFechaActual();
        } else {
        document.getElementById("resultado1").innerText = "❌";
        document.getElementById("fechaSal").value = '';
        }
    } catch (error) {
        console.error("Error al obtener la información del producto:", error);
        document.getElementById("resultado").innerText = "⚠️";
    }

    });


    //Funcion para agregar la fecha actual de salida del producto
    function agregarFechaActual() {

        const inputFechaSalida = document.getElementById("fechaSal");

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
        inputFechaSalida.value = fechaHoraFormateada;

    }


    // Función asincrónica para obtener verificar que el producto este en inventario y existencia para la venta
    async function existenciaInventario(idProducto) {

        try {
            const response = await fetch("index.php?action=verificacionStock", {
                method: "POST",
                headers: {
                "Content-Type": "application/json",
                },
              body: JSON.stringify({ idProducto: idProducto }), // Enviar datos al servidor como JSON
            });
        
                const data = await response.json();
    
                // Verificamos que data y data.cantidadActual y data.cantidadActual.CantActual estén definidos
                if (data && data.success && data.stock && data.stock.CantActual) {

                    const stock = data.stock.CantActual;
                    return stock;

                } else {
                    //alert('Producto no esta en inventario, realice la entrada del producto');
                    return false;
                }
            } catch (error) {
                console.error('Error al obtener los datos del producto:', error);
                alert('Hubo un error al obtener los datos del producto.');
            }
        
    }