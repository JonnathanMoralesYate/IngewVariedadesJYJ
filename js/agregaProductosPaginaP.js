// Variables globales para paginación (solo para productos por clase)
let productosPaginados = [];
const productosPorPagina = 9;
let paginaActual = 1;

// Obtener productos por clase
async function obtenerInforProductoPorClase(idClase) {

    try {
        const response = await fetch("index.php?action=productosPorClase", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ idClase: idClase }),
        });

        const data = await response.json();

        if (data.success) {
            productosPaginados = data.inforProducto;
            mostrarPagina(1);
        } else {

        }
    } catch (error) {
        console.error("Error al obtener los datos del producto:", error);
    }
}


// Mostrar productos por página
function mostrarProductos(productosPagina) {
    const contenedor = document.getElementById("productos-container");
    contenedor.innerHTML = "";

    productosPagina.forEach((producto) => {
        const productoHTML = `
            <div class="col">
                <div class="card mx-auto h-100" style="width: 14rem;">
                    <img src="photo/${producto.Foto}" class="card-img-top rounded" alt="${producto.Producto}">
                    <div class="card-body">
                        <h6 class="card-title">${producto.Producto}</h6>
                        <p class="card-text">${producto.Descripcion}</p>
                    </div>
                </div>
            </div>
        `;
        contenedor.innerHTML += productoHTML;
    });
}

// Mostrar paginación con máximo de 10 botones
function mostrarPaginacion() {
    
    const totalPaginas = Math.ceil(productosPaginados.length / productosPorPagina);
    const paginacionContenedor = document.getElementById("paginacion-container");
    paginacionContenedor.innerHTML = "";

    if (totalPaginas <= 1) return; // Oculta si solo hay 1 página

    const nav = document.createElement("nav");
    const ul = document.createElement("ul");
    ul.className = "pagination justify-content-center flex-wrap mt-3";

    // Botón Anterior
    const liAnterior = document.createElement("li");
    liAnterior.className = "page-item " + (paginaActual <= 1 ? "disabled" : "");
    const aAnterior = document.createElement("a");
    aAnterior.className = "page-link";
    aAnterior.href = "#";
    aAnterior.textContent = "Anterior";
    aAnterior.addEventListener("click", (e) => {
        e.preventDefault();
        if (paginaActual > 1) mostrarPagina(paginaActual - 1);
    });
    liAnterior.appendChild(aAnterior);
    ul.appendChild(liAnterior);

    // Lógica para mostrar máximo de 10 botones
    const maxVisibles = 10;
    let inicio = Math.max(1, paginaActual - Math.floor(maxVisibles / 2));
    let fin = inicio + maxVisibles - 1;

    if (fin > totalPaginas) {
        fin = totalPaginas;
        inicio = Math.max(1, fin - maxVisibles + 1);
    }

    for (let i = inicio; i <= fin; i++) {
        const li = document.createElement("li");
        li.className = "page-item " + (paginaActual === i ? "active" : "");
        const a = document.createElement("a");
        a.className = "page-link";
        a.href = "#";
        a.textContent = i;
        a.addEventListener("click", (e) => {
            e.preventDefault();
            mostrarPagina(i);
        });
        li.appendChild(a);
        ul.appendChild(li);
    }

    // Botón Siguiente
    const liSiguiente = document.createElement("li");
    liSiguiente.className = "page-item " + (paginaActual >= totalPaginas ? "disabled" : "");
    const aSiguiente = document.createElement("a");
    aSiguiente.className = "page-link";
    aSiguiente.href = "#";
    aSiguiente.textContent = "Siguiente";
    aSiguiente.addEventListener("click", (e) => {
        e.preventDefault();
        if (paginaActual < totalPaginas) mostrarPagina(paginaActual + 1);
    });
    liSiguiente.appendChild(aSiguiente);
    ul.appendChild(liSiguiente);

    nav.appendChild(ul);
    paginacionContenedor.appendChild(nav);
}


// Mostrar página específica
function mostrarPagina(pagina) {
    paginaActual = pagina;
    const inicio = (paginaActual - 1) * productosPorPagina;
    const fin = inicio + productosPorPagina;
    const productosPagina = productosPaginados.slice(inicio, fin);
    mostrarProductos(productosPagina);
    mostrarPaginacion();
}

// Buscar por nombre (formulario)
document.getElementById("formBuscarProducto").addEventListener("submit", function (e) {
    e.preventDefault();
    const nombre = document.getElementById("inputNombreProducto").value.trim();
    if (nombre !== "") {
        obtenerInforProductoPorNombre(nombre);
    }
});

// Obtener productos más vendidos (no cambia)
async function ProductosMayorVenta() {
    try {
        const response = await fetch("index.php?action=productosMayorVentaP", {
            method: "GET",
            headers: { "Content-Type": "application/json" },
        });

        const data = await response.json();
        mostrarProductosMayorVenta(data.mayoresVenta);
    } catch (error) {
        console.error("Error al obtener los datos del producto:", error);
    }
}

function mostrarProductosMayorVenta(producto) {
    const contenedor = document.getElementById("productos-container");
    contenedor.innerHTML = "";

    producto.forEach((productos) => {
        const productoHTML = `
            <div class="col">
                <div class="card mx-auto h-100" style="width: 14rem;">
                    <img src="photo/${productos.Foto}" class="card-img-top rounded" alt="${productos.Producto}">
                    <div class="card-body">
                        <h6 class="card-title">${productos.Producto}</h6>
                        <p class="card-text">${productos.Descripcion}</p>
                    </div>
                </div>
            </div>
        `;
        contenedor.innerHTML += productoHTML;
    });
}

document.addEventListener("DOMContentLoaded", ProductosMayorVenta);

// Buscar producto por nombre (necesario si estás usando input de búsqueda)
async function obtenerInforProductoPorNombre(nombre) {
    try {
        const response = await fetch("index.php?action=consultaProductoNombre", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ Nombre: nombre }),
        });

        const data = await response.json();

        if (data.success) {
            productosPaginados = data.inforProducto;
            mostrarPagina(1);
        }
    } catch (error) {
        console.error('Error al obtener los datos del producto:', error);
    }
}
