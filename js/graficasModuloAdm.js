//Grifica de productos con mayor venta

let myChart = null; // Variable global para almacenar la instancia de la gráfica

async function ActualizarGraficaMayorVenta() {

    try {
      const response = await fetch('index.php?action=productosMayorVenta', {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (!data || !data.mayorVenta || !Array.isArray(data.mayorVenta) || data.mayorVenta.length === 0) {
      console.error("No hay datos de menor stock para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const mayorVenta = data.mayorVenta;
    const nombres = mayorVenta.map(item => item.Producto);
    const cantidades = mayorVenta.map(item => parseFloat(item.totalVendido));

    // Obtener el contexto del canvas
    const canvas = document.getElementById('myChart');
      if (!canvas) {
        console.error("No se encontró el elemento canvas con id 'myChart'.");
        return;
      }

    const ctx = canvas.getContext('2d');

      // Destruir la gráfica anterior si existe
      if (myChart) {
        myChart.destroy();
      }

      // Crear nueva gráfica
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: nombres,
          datasets: [{
            label: 'producto Mas Vendido',
            data: cantidades,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(0, 200, 0, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(0, 200, 0, 1)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          //responsive: true, // Permite ajustar el tamaño
          //maintainAspectRatio: false, // Permite ocupar toda la altura del contenedor
          layout: {
              //padding: 20 // Ajusta el espacio interno si es necesario
          },
          plugins: {
              legend: {
                  labels: {
                      color: 'white' // Color del texto en la leyenda
                  }
              }
          },
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      color: 'white'
                  },
                  grid: {
                      color: 'rgba(255, 255, 255, 0.2)' // Líneas de la cuadrícula
                  }
              },
              x: {
                  ticks: {
                      color: 'white'
                  },
                  grid: {
                      color: 'rgba(255, 255, 255, 0.2)'
                  }
              }
          }
      }
      });
  } catch (error) {
    console.error("Error al obtener los datos del producto:", error);
  }
}

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaMayorVenta);

//=================================================================================================================================

//Grifica de que muestra ventas por dia

  let myChart1 = null; // Variable global para almacenar la instancia de la gráfica

  async function ActualizarGraficaVentaPorDia() {

    try {
      const response = await fetch('index.php?action=ventasPorDias', {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (!data || !data.ventaPorDia || !Array.isArray(data.ventaPorDia) || data.ventaPorDia.length === 0) {
      console.error("No hay datos de Ventas Por Dias para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const ventaPorDia = data.ventaPorDia;
    const nombres = ventaPorDia.map(item => item.Fecha);
    const cantidades = ventaPorDia.map(item => parseFloat(item.TotalVendido));

    // Obtener el contexto del canvas
    const canvas = document.getElementById('myChart1');
      if (!canvas) {
        console.error("No se encontró el elemento canvas con id 'myChart1'.");
        return;
      }

    const ctx1 = canvas.getContext('2d');

      // Destruir la gráfica anterior si existe
      if (myChart1) {
        myChart1.destroy();
      }

      new Chart(ctx1, {
        type: 'radar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Total Venta del dia',
                data: cantidades,
                backgroundColor: 'rgba(255, 255, 255, 0.2)',
                borderColor: 'white',
                pointBackgroundColor: 'white',
                pointBorderColor: 'black',
                pointRadius: 5,
                borderWidth: 2
            }]
        },
        options: {
            //responsive: true,
            //maintainAspectRatio: false, // Permite que se ajuste al contenedor
            layout: {
                padding: 20
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            },
            scales: {
                r: {
                    angleLines: {
                        color: 'rgba(255, 255, 255, 0.3)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    },
                    pointLabels: {
                        color: 'white',
                        font: {
                            size: 12
                        }
                    },
                    ticks: {
                        color: 'white',
                        backdropColor: 'transparent',
                    }
                }
            }
        }
      });
    } catch (error) {
      console.error("Error al obtener los datos del producto:", error);
    } 

  }

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaVentaPorDia);

//==========================================================================================================================================

let myChart2 = null; // Variable global para almacenar la instancia de la gráfica

  async function ActualizarGraficaMayorEntradaProducto() {

    try {
      const response = await fetch('index.php?action=mayorEntProductos', {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (!data || !data.mayorEntrada || !Array.isArray(data.mayorEntrada) || data.mayorEntrada.length === 0) {
      console.error("No hay datos de Ventas Por Dias para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const mayorEntrada = data.mayorEntrada;
    const nombres = mayorEntrada.map(item => item.Producto);
    const cantidades = mayorEntrada.map(item => parseFloat(item.TotalEntradas));

    // Obtener el contexto del canvas
    const canvas = document.getElementById('myChart2');
      if (!canvas) {
        console.error("No se encontró el elemento canvas con id 'myChart2'.");
        return;
      }


    const ctx2 = canvas.getContext('2d');

    // Destruir la gráfica anterior si existe
    if (myChart2) {
      myChart1.destroy();
    }

new Chart(ctx2, {
  type: 'polarArea',
  data: {
    labels: nombres,
    datasets: [{
      label: 'No. de UND Entrada',
      data: cantidades,
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(0, 200, 0, 0.6)'
      ],
      borderColor: 'white',
      borderWidth: 2
    }]
  },
  options: {
    //responsive: true, // Hace que la gráfica se ajuste automáticamente
    //maintainAspectRatio: false, // Permite ocupar el contenedor completo
    layout: {
      padding: 20
    },
    plugins: {
      legend: {
        labels: {
          color: 'white',
          font: { size: 12 }
        }
      }
    },
    scales: {
      r: {
        grid: {
          color: 'rgba(255, 255, 255, 0.2)'
        },
        angleLines: {
          color: 'rgba(255, 255, 255, 0.3)'
        },
        ticks: {
          color: 'white',
          backdropColor: 'transparent'
        }
      }
    }
  }
});
} catch (error) {
  console.error("Error al obtener los datos:", error);
} 

}

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaMayorEntradaProducto);

//=======================================================================================================================================

//Grifica de productos de menor estock

let myChart3 = null; // Variable global para almacenar la instancia de la gráfica

async function ActualizarGraficaMenorStock() {
    try {
      const response = await fetch('index.php?action=productosMenorStock', {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const data = await response.json();

    // Validar que la respuesta contiene los datos esperados
    if (!data || !data.menorStock || !Array.isArray(data.menorStock) || data.menorStock.length === 0) {
      console.error("No hay datos de menor stock para mostrar.");
      return;
    }

    // Extraer nombres y cantidades
    const menorStock = data.menorStock;
    const nombres = menorStock.map(item => item.Producto);
    const cantidades = menorStock.map(item => parseFloat(item.CantActual));

    // Obtener el contexto del canvas
    const canvas = document.getElementById('myChart3');
      if (!canvas) {
        console.error("No se encontró el elemento canvas con id 'myChart3'.");
        return;
      }

    const ctx3 = canvas.getContext('2d');

      // Destruir la gráfica anterior si existe
      if (myChart3) {
        myChart3.destroy();
      }

      // Crear nueva gráfica
      myChart3 = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Stock disponible',
                data: cantidades,
                borderColor: 'white',
                backgroundColor: 'rgba(255, 255, 255, 0.3)',
                pointBackgroundColor: 'lightblue',
                pointBorderColor: 'white',
                pointRadius: 6,
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            //responsive: true, // Permite ajustar tamaño dinámicamente
            //maintainAspectRatio: false, // Permite que ocupe todo el contenedor
            layout: {
                //padding: 10 // Ajusta el espacio interno si es necesario
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white',
                        font: { size: 12 }
                    }
                }
            },
            scales: {
                x: { 
                    ticks: { color: 'white' }, 
                    grid: { color: 'rgba(255, 255, 255, 0.2)' } 
                },
                y: { 
                    beginAtZero: true, 
                    ticks: { color: 'white' }, 
                    grid: { color: 'rgba(255, 255, 255, 0.2)' } 
                }
            }
        }
    });
  } catch (error) {
    console.error("Error al obtener los datos del producto:", error);
  }
}

// Llamar la función cuando cargue la página
document.addEventListener("DOMContentLoaded", ActualizarGraficaMenorStock);