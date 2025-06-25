document.addEventListener("DOMContentLoaded", async function () {
  
  const precioProducto = document.getElementById("precioProducto");
  const codProducto = document.getElementById("codProducto");
 

  try {
    const response = await fetch(
      "index.php?action=verificacionCodigoProductos",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ codProducto: codProducto.value }), 
      }
    );

    const data = await response.json();

    if (data.success) {
      if (data.producto && data.producto.PrecioVenta) {

        precioProducto.value = parseInt(data.producto.PrecioVenta);

      } else {
        alert("Datos del Producto no Disponibles.");
      }
    } else {
      
    }
  } catch (error) {
    console.error("Error al obtener la información del producto:", error);
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const precioVenta = document.getElementById("precioVenta");
  const cantSalidaInput = document.querySelector("input[name='cantSal']");
  const precioProductoInput = document.getElementById("precioProducto");

  // Escuchar cambios en la cantidad de salida
  cantSalidaInput.addEventListener("input", function () {
    // Convertir valores a número correctamente
    const cantSalida = parseFloat(cantSalidaInput.value.replace(",", ".")) || 0;
    const precioProducto =
      parseFloat(precioProductoInput.value.replace(",", ".")) || 0;

    // Calcular el precio de venta
    const precioVentaOpe = cantSalida * precioProducto;

    // Mostrar el resultado correctamente sin formato de comas
    precioVenta.value = Math.floor(precioVentaOpe);
  });
});
