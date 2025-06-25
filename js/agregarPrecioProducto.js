document.addEventListener('DOMContentLoaded', function() {

//Funcion obtener los datos del producto al ingresar el codigo de barras
document
  .getElementById("codProducto")
  .addEventListener("blur", async function () {
    const codProductoInput = document.getElementById("codProducto");
    const precioInput = document.getElementById("precioProducto");
    const cantSalInput = document.getElementById("cantSal");
    const precioVentaInput = document.getElementById("precioVenta");
    const inputFechaSalida = document.getElementById("fechaSal");

    // Obtén el valor del input
    const codigoBarras = document.getElementById("codProducto").value.trim();

    agregarFechaActual();

    // Evita consulta si el campo del input está vacío
    if (codigoBarras === "") {
      //remueve el contenido de la eqtiqueta <p id"resultado"></p>
      document.getElementById("resultado").textContent = "";
      //limpia el campo de fecha de entrada
      document.getElementById("fechaSal").value = "";
      //limpia el campo de Precio Venta Producto
      document.getElementById("precioProducto").value = "";
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

      const data = await response.json();

      if (data.success) {

        if(data.producto && data.producto.idProducto && data.producto.PrecioVenta) { 
          //Precio del Producto encontrado, lo mostramos en los campo del formulario
          precioInput.value = data.producto.PrecioVenta.toLocaleString();

          //ID del producto
          productoId = data.producto.idProducto;

          stockDisponible(productoId);
        }else {
          alert('Datos del Producto no Disponibles.');
        }

      } else {
        document.getElementById("resultado").innerText = "❌❌";
        document.getElementById("fechaSal").value = "";
        document.getElementById("precioProducto").value = "";
      }
    } catch (error) {
      console.error("Error al obtener la información del producto:", error);
      document.getElementById("resultado").innerText = "⚠️";
    }
  });

});

//Funcion para verificar disponibilidad del producto en Stock
async function stockDisponible(productoId) {
  try {
    const response = await fetch("index.php?action=verificacionStock", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ idProducto: productoId }), // Enviar datos al servidor como JSON
    });

    const data = await response.json();

    if (data.success) {
      document.getElementById("resultado").innerText = "✅";
      cantidadDisponible = parseFloat(data.stock.CantActual);
      
    } else {
      document.getElementById("resultado").innerText = "❌";
    }
  } catch (error) {
    console.error("Error al obtener Stock Disponible del producto:", error);
  }
}

//Funcion para verificar si el cliente esta registrado
document
  .getElementById("numIdentCliente")
  .addEventListener("blur", async function () {
    // Obtén el valor del input
    const numCliente = document.getElementById("numIdentCliente").value.trim();

    // Evita consulta si el campo del input está vacío
    if (numCliente === "") {
      //remueve el contenido de la eqtiqueta <p id"resultado"></p>
      document.getElementById("resultado1").textContent = "";
      //limpia el campo de fecha de entrada
      document.getElementById("numIdentCliente").value = "";
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
      } else {
        document.getElementById("resultado1").innerText = "❌";
      }
    } catch (error) {
      console.error("Error al obtener la información del producto:", error);
      document.getElementById("resultado").innerText = "⚠️";
    }
  });

//Funcion para Calcular el precio de la venta al digitar la cantidad
document.getElementById("cantSal").addEventListener("blur", function () {
  // Obtén el valor del input y lo conviete a numero
  const cantidadSal = parseInt(document.getElementById("cantSal").value);

  // Evita consulta si el campo del input está vacío
  if (isNaN(cantidadSal)) {
    //remueve el contenido de la eqtiqueta <p id"resultado"></p>
    document.getElementById("precioVenta").value = "";
    return;
  }

  if (cantidadDisponible >= cantidadSal) {
    ventaTotal();
    return;
  } else {
    if (cantidadDisponible !== 0) {
      alert(
        "Cantidad Maxima disponible del Producto en Stock: " +
          cantidadDisponible
      );
      document.getElementById("cantSal").value = "";
      document.getElementById("precioVenta").value = "";
    }
  }
});

//Funcion para Calcular venta de la venta
function ventaTotal() {
  const precioVentaInput = document.getElementById("precioVenta");

  // Obtén el valor del input
  const cantSalInput = parseFloat(document.getElementById("cantSal").value);

  //Obtiene el valor del precio producto
  const precioInput = document.getElementById("precioProducto").value;

  const precioProducto = precioInput.replace(/\./g, "").replace(",", ".");

  const precioNumero = Number(precioProducto);

  //verifica los valores que sean numericos para poder realizar opreciones
  if (!isNaN(precioNumero) && !isNaN(cantSalInput) && cantSalInput > 0) {
    const precioVenta = precioNumero * cantSalInput;
    precioVentaInput.value = Math.floor(precioVenta).toLocaleString();
  } else {
    precioVentaInput.value = "";
  }
}

//Funcion para agregar la fecha actual de salida del producto
function agregarFechaActual() {
  const inputFechaSalida = document.getElementById("fechaSal");

  // Obtener la fecha y hora actual
  const fechaHoraActual = new Date();

  // Obtener el año, mes, día, hora, minutos y formatearlos, // Los meses en JavaScript son de 0 a 11
  const anio = fechaHoraActual.getFullYear();
  const mes = String(fechaHoraActual.getMonth() + 1).padStart(2, "0");
  const dia = String(fechaHoraActual.getDate()).padStart(2, "0");
  const hora = String(fechaHoraActual.getHours()).padStart(2, "0");
  const minutos = String(fechaHoraActual.getMinutes()).padStart(2, "0");

  // Formatear la fecha y hora en el formato requerido (YYYY-MM-DDTHH:MM)
  const fechaHoraFormateada = `${anio}-${mes}-${dia}T${hora}:${minutos}`;

  // Asignar la fecha y hora formateada al input
  inputFechaSalida.value = fechaHoraFormateada;
}
