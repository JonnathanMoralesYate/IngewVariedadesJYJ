//Grifica de productos con mayor venta

let myChart = null; // Variable global para almacenar la instancia de la gráfica

async function ActualizarGraficaMayorVenta() {

  try {
    const response = await fetch("index.php?action=productosMayorVenta", {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (
      !data ||
      !data.mayorVenta ||
      !Array.isArray(data.mayorVenta) ||
      data.mayorVenta.length === 0
    ) {
      console.error("No hay datos de menor stock para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const mayorVenta = data.mayorVenta;
    const nombres = mayorVenta.map((item) => item.Producto);
    const cantidades = mayorVenta.map((item) => parseFloat(item.totalVendido));

    // Obtener el contexto del canvas
    const canvas = document.getElementById("myChart");
    if (!canvas) {
      console.error("No se encontró el elemento canvas con id 'myChart'.");
      return;
    }

    const ctx = canvas.getContext("2d");

    // Destruir la gráfica anterior si existe
    if (myChart) {
      myChart.destroy();
    }

    // Crear nueva gráfica
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: nombres,
        datasets: [
          {
            label: "Producto Más Vendido",
            data: cantidades,
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)",
              "rgba(0, 200, 0, 0.2)",
            ],
            borderColor: [
              "rgba(255, 99, 132, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)",
              "rgba(0, 200, 0, 1)",
            ],
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true, // Permite ajustar el tamaño dinámicamente
        maintainAspectRatio: false, // Permite ocupar toda la altura del contenedor
        layout: {
          padding: 20, // Ajusta el espacio interno si es necesario
        },
        plugins: {
          legend: {
            labels: {
              color: "white", // Color del texto en la leyenda
            },
          },
        },
        // No es necesario configurar los ejes (scales) para gráficos doughnut
      },
    });

  } catch (error) {
    console.error("Error al obtener los datos del producto:", error);
  }
}

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaMayorVenta);

//==========================================================================================

//Grifica de productos de menor estock

let myChart3 = null; // Variable global para almacenar la instancia de la gráfica

async function ActualizarGraficaMenorStock() {
  try {
    const response = await fetch("index.php?action=productosMenorStock", {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (
      !data ||
      !data.menorStock ||
      !Array.isArray(data.menorStock) ||
      data.menorStock.length === 0
    ) {
      console.error("No hay datos de menor stock para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const menorStock = data.menorStock;
    const nombres = menorStock.map((item) => item.Producto);
    const cantidades = menorStock.map((item) => parseFloat(item.CantActual));

    // Obtener el contexto del canvas
    const canvas = document.getElementById("myChart3");
    if (!canvas) {
      console.error("No se encontró el elemento canvas con id 'myChart3'.");
      return;
    }

    const ctx3 = canvas.getContext("2d");

    // Destruir la gráfica anterior si existe
    if (myChart3) {
      myChart3.destroy();
    }

    // Crear nueva gráfica
    myChart3 = new Chart(ctx3, {
      type: "bar", // Cambiado de "horizontalBar" a "bar"
      data: {
        labels: nombres,
        datasets: [
          {
            label: "Stock disponible",
            data: cantidades,
            borderColor: "white", // Puedes usar un color más visible si es necesario
            // Colores de las barras (puedes usar colores distintos o gradientes)
            backgroundColor: [
              "rgba(255, 99, 132, 0.7)", // Rosa
              "rgba(54, 162, 235, 0.7)", // Azul
              "rgba(255, 206, 86, 0.7)", // Amarillo
              "rgba(75, 192, 192, 0.7)", // Verde claro
              "rgba(153, 102, 255, 0.7)", // Morado
              "rgba(255, 159, 64, 0.7)", // Naranja
              "rgba(0, 200, 0, 0.7)", // Verde
            ],
            borderWidth: 2, // Mantén el grosor de borde
            barThickness: 20, // Ajuste opcional para el grosor de las barras
            borderRadius: 5, // Bordes redondeados para las barras
            hoverBackgroundColor: "rgba(255, 159, 64, 1)", // Color cuando se pasa el ratón
            hoverBorderColor: "rgba(255, 255, 255, 1)", // Color del borde al pasar el ratón
          },
        ],
      },
      options: {
        responsive: true, // Permite ajustar el tamaño dinámicamente
        maintainAspectRatio: false, // Permite que ocupe todo el contenedor
        layout: {
          padding: 10, // Ajusta el espacio interno si es necesario
        },
        plugins: {
          legend: {
            labels: {
              color: "white", // Color de las etiquetas de la leyenda
              font: { size: 14 }, // Tamaño de la fuente de la leyenda
            },
          },
          tooltip: {
            backgroundColor: "rgba(0,0,0,0.7)", // Fondo oscuro en los tooltips
            titleColor: "white", // Color del título en los tooltips
            bodyColor: "white", // Color del cuerpo en los tooltips
            borderColor: "white", // Borde del tooltip
            borderWidth: 1, // Grosor del borde del tooltip
          },
        },
        scales: {
          x: {
            ticks: { color: "white" },
            grid: { color: "rgba(255, 255, 255, 0.2)" },
          },
          y: {
            beginAtZero: true,
            ticks: { color: "white" },
            grid: { color: "rgba(255, 255, 255, 0.2)" },
          },
        },
        indexAxis: "y", // Esto asegura que las barras sean horizontales
        animation: {
          duration: 1000, // Duración de la animación (en milisegundos)
          easing: "easeInOutQuad", // Tipo de animación
        },
      },
    });

  } catch (error) {
    console.error("Error al obtener los datos del producto:", error);
  }
}

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaMenorStock);
