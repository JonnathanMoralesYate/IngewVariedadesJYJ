<?php

require_once('./controllers/controladorPaginaAdmin.php');
require_once('./controllers/controladorPaginaEmple.php');

require_once('./controllers/controladorLogin.php');
require_once('./controllers/controladorUsuario.php');
require_once('./controllers/controladorTipoDocum.php');
require_once('./controllers/controladorRol.php');
require_once('./controllers/controladorClases.php');
require_once('./controllers/controladorPresentacion.php');
require_once('./controllers/controladorUndBase.php');
require_once('./controllers/controladorProducto.php');
require_once('./controllers/controladorFormatoVenta.php');
require_once('./controllers/controladorProveedor.php');
require_once('./controllers/controladorCliente.php');
require_once('./controllers/controladorEntProducto.php');
require_once('./controllers/controladorSalProducto.php');
require_once('./controllers/controladorInventario.php');
require_once('./controllers/controladorModoPago.php');
require_once('./controllers/controladorGenerarCodigo.php');
require_once('./controllers/controladorCarousel.php');

$vistaAdmin = new ControladorPaginaAdmin();
$vistaEmple = new ControladorPaginaEmple();

$controladorLogin = new ControladorLogin();
$controladorUsuario = new ControladorUsuario();
$controladorTipoDocum = new ControladorTipoDocum();
$controladorRol = new ControladorRol();
$controladorClases = new ControladorClases();
$controladorPresentacion = new ControladorPresentacion();
$controladorUndBase = new ControladorUndBase();
$controladorProducto = new ControladorProducto();
$controladorFormatoVenta = new ControladorFormatoVenta();
$controladorProveedor = new ControladorProveedor();
$controladorCliente = new ControladorCliente();
$controladorEntProducto = new ControladorEntProductos();
$controladorSalProducto = new ControladorSalProducto();
$controladorInventario = new ControladorInventario();
$controladorModoPago = new ControladorModoPago();
$controladorGenerarCodigo = new ControladorGenerarCodigo();
$controladorCarousel = new ControladorCarousel();

$action = htmlspecialchars($_GET['action'] ?? 'Principal', ENT_QUOTES, 'UTF-8');

if (!in_array($action, ['Principal', 'Nosotros', 'Servicios', 'login', 'cerrarSesion'])) {
    session_start();
}


switch ($action) {

    case 'Nosotros':
        include('./views/paginasWeb/paginaNosotros.php');
        break;

    case 'Servicios':
        include('./views/paginasWeb/paginaServicios.php');
        break;

    case 'Principal':
        $promociones = $controladorCarousel->consultarCarousel();
        $clases = $controladorProducto->listaClasesP();
        include('./views/paginasWeb/paginaPrincipal.php');
        break;

//============================================================================================================================================

    //Redirecciones Modulo Administrativo
    case 'vistaAdmin':
        $vistaAdmin->index();
        break;


    //Redirecciones Modulo Empleado
    case 'vistaEmple':
        $vistaEmple->index();
        break;

//============================================================================================================================================

    //Login inicio de Sesion
    case 'login':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sesionUsuario = $controladorLogin->validarUsuario();
        }
        break;

    case 'cerrarSesion':
        $controladorLogin->cerrarSesion();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Empleados

    //Registro usuario
    case 'registroUsuario':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorUsuario->registroUsua();
        } else {
            $tipoDocum = $controladorTipoDocum->listaTiposDocum();
            include('./views/usuarios/registroUsuarios.php');
        }
        break;


    //Consulta Usuarios
    case 'consultaUsuarios':
        $tipo = '';
        $filtro = '';
        $data = $controladorUsuario->listaUsuariosVista($tipo, $filtro);
        include('./views/usuarios/consultaUsuario.php');
        break;

    case 'consultaUsuarioDocumento':
        $valor = $_GET['numIdentUsuario'] ?? '';
        $data = $controladorUsuario->listaUsuariosFiltrado('codigo', $valor);
        include('./views/usuarios/consultaUsuario.php');
        break;

    case 'consultaUsuarioNombre':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorUsuario->listaUsuariosFiltrado('nombre', $valor);
        include('./views/usuarios/consultaUsuario.php');
        break;


    //Actualizar usuario
    case 'actualizarUsuarioId':
        $usuarios = $controladorUsuario->datosUsuaGenPorId();
        $tipoRoles = $controladorRol->listaRoles();
        $tipoDocum = $controladorTipoDocum->listaTiposDocum();
        include('./views/usuarios/actualizarUsuario.php');
        break;

    case 'actualizarUsuario':
        $controladorUsuario->actualizarUsuario();
        break;


    //Eliminar usuario
    case 'eliminarUsuarioId':
        $usuarios = $controladorUsuario->eliminarUsuario();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Productos

    //Registro Producto
    case 'registroProductos':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->registroProductos();
        } else {
            $clases = $controladorClases->listaClasesP();
            $presentaciones = $controladorPresentacion->listaPresentacion();
            $undBases = $controladorUndBase->listaUndBase();
            $formatoVents = $controladorFormatoVenta->listaFormatoVenta();
            include('./views/productos/registroProducto.php');
        }
        break;


    //Consulta Producto
    case 'consultaProductos':
        $tipo = 'codigo';
        $filtro = '';
        $data = $controladorProducto->listaProductosVista($tipo, $filtro);
        include('./views/productos/consultaProductos.php');
        break;

    case 'consultaProductosCodigo':
        $valor = $_GET['codProduc'] ?? '';
        $data = $controladorProducto->listaProductosFiltrado('codigo', $valor);
        include('./views/productos/consultaProductos.php');
        break;

    case 'consultaProductosNombre':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorProducto->listaProductosFiltrado('nombre', $valor);
        include('./views/productos/consultaProductos.php');
        break;


    //Actualizar Producto
    case 'actualizarProductosCodigo':
        $productos = $controladorProducto->productoCodigo();
        $clases = $controladorClases->listaClasesP();
        $presentaciones = $controladorPresentacion->listaPresentacion();
        $undBases = $controladorUndBase->listaUndBase();
        $formatoVents = $controladorFormatoVenta->listaFormatoVenta();
        include('./views/productos/actualizarProducto.php');
        break;

    case 'actualizarProducto':
        $controladorProducto->actualizarProducto();
        break;


    //Eliminar Producto
    case 'eliminarProductoCodigo':
        $productos = $controladorProducto->eliminarProducto();
        break;

//============================================================================================================================================

//Modulo Empleado

//Productos

    //registro de producto empleado
    case 'registroProductosEmp':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->registroProductos();
        } else {
            $clases = $controladorClases->listaClasesP();
            $presentaciones = $controladorPresentacion->listaPresentacion();
            $undBases = $controladorUndBase->listaUndBase();
            $formatoVents = $controladorFormatoVenta->listaFormatoVenta();
            include('./views/productos/registroproductosEmp.php');
        }
        break;


    //Consulta Producto empleado
    case 'consultaProductosEmp';
        $tipo = 'codigo';
        $filtro = '';
        $data = $controladorProducto->listaProductosVista($tipo, $filtro);
        include('./views/productos/consultaProductoEmp.php');
        break;

    case 'consultaProductosCodigoEmp';
        $valor = $_GET['codProduc'] ?? '';
        $data = $controladorProducto->listaProductosFiltrado('codigo', $valor);
        include('./views/productos/consultaProductoEmp.php');
        break;

    case 'consultaProductosNombreEmp';
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorProducto->listaProductosFiltrado('nombre', $valor);
        include('./views/productos/consultaProductoEmp.php');
        break;


        //Actualizar Producto
    case 'actualizarProductosCodigoEmp':
        $productos = $controladorProducto->productoCodigo();
        $clases = $controladorClases->listaClasesP();
        $presentaciones = $controladorPresentacion->listaPresentacion();
        $undBases = $controladorUndBase->listaUndBase();
        $formatoVents = $controladorFormatoVenta->listaFormatoVenta();
        include('./views/productos/actualizarProductoEmp.php');
        break;

    case 'actualizarProducto':
        $controladorProducto->actualizarProducto();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Clases

    //Registro Clase
    case 'registroClase':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorClases->registroClase();
        } else {
            include('./views/propiedades/clases/registroClase.php');
        }
        break;


    //Consulta Clase
    case 'consultaClase';
        $tipo = '';
        $filtro = '';
        $data = $controladorClases->listaClases($tipo, $filtro);
        include('./views/propiedades/clases/consultaClase.php');
        break;

    case 'consultaClaseId';
        $valor = $_GET['idClase'] ?? '';
        $data = $controladorClases->listaClasesFiltrado('codigo', $valor);
        include('./views/propiedades/clases/consultaClase.php');
        break;

    case 'consultaClaseNombre';
        $valor = $_GET['nomClase'] ?? '';
        $data = $controladorClases->listaClasesFiltrado('nomClase', $valor);
        include('./views/propiedades/clases/consultaClase.php');
        break;


    //Actualizar Clase
    case 'actualizarClaseId':
        $clases = $controladorClases->consultClaseId();
        include('./views/propiedades/clases/actualizarClase.php');
        break;

    case 'actualizarClase':
        $controladorClases->ActualizarClase();
        break;


    //Eliminar Clase
    case 'eliminarClaseId':
        $clases = $controladorClases->eliminarClase();
        break;

//============================================================================================================================================
    
//Modulo Administrativo

//Presentacion

    //Registro presentacion
    case 'registroPresentacion':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorPresentacion->RegistroPresentacion();
        } else {
            include('./views/propiedades/presentacion/registroPresentacion.php');
        }
        break;


    //Consulta Presentacion
    case 'consultaPresentacion';
        $tipo = '';
        $filtro = '';
        $data = $controladorPresentacion->listaPresentaciones($tipo, $filtro);
        include('./views/propiedades/presentacion/consultaPresentacion.php');
        break;

    case 'consultaPresentacionId';
        $valor = $_GET['idPresentacion'] ?? '';
        $data = $controladorPresentacion->listaPresentacionFiltrado('codigo', $valor);
        include('./views/propiedades/presentacion/consultaPresentacion.php');
        break;

    case 'consultaPresentacionNombre';
        $valor = $_GET['nomPresentacion'] ?? '';
        $data = $controladorPresentacion->listaPresentacionFiltrado('nomPresentacion', $valor);
        include('./views/propiedades/presentacion/consultaPresentacion.php');
        break;


    //Actualizar Presentacion
    case 'actualizarPresentacionId':
        $presentaciones = $controladorPresentacion->ConsultPresentacionId();
        include('./views/propiedades/presentacion/actualizarPresentacion.php');
        break;

    case 'actualizarPresentacion':
        $controladorPresentacion->ActualizarPresentacion();
        break;


    //Eliminar Presentacion
    case 'eliminarPresentacionId':
        $presentaciones = $controladorPresentacion->EliminarPresentacion();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Unidad Base

    //Registro Unidad Base
    case 'registroUndBase':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorUndBase->RegistroUndBase();
        } else {
            include('./views/propiedades/unidadBase/registroUndBase.php');
        }
        break;


    //Consulta Unidad Base
    case 'consultaUndBasen';
        $tipo = '';
        $filtro = '';
        $data = $controladorUndBase->listaUndBases($tipo, $filtro);
        include('./views/propiedades/unidadBase/consultaUndBase.php');
        break;

    case 'consultaUndBaseId';
        $valor = $_GET['idUndBase'] ?? '';
        $data = $controladorUndBase->listaUndBaseFiltrado('codigo', $valor);
        include('./views/propiedades/unidadBase/consultaUndBase.php');
        break;

    case 'consultaUndBaseNombre';
        $valor = $_GET['nomUndBase'] ?? '';
        $data = $controladorUndBase->listaUndBaseFiltrado('nomUndBase', $valor);
        include('./views/propiedades/unidadBase/consultaUndBase.php');
        break;


    //Actualizar Unidad Base
    case 'actualizarUndBaseId':
        $undBases = $controladorUndBase->consultUndBaseId();
        include('./views/propiedades/unidadBase/actualizarUndBase.php');
        break;

    case 'actualizarUndBase':
        $controladorUndBase->ActualizarUndBase();
        break;


    //Eliminar Unidad Base
    case 'eliminarUndBaseId':
        $controladorUndBase->EliminarUndBase();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Formato Venta

    //Registro Formato Venta
    case 'registroFormatoVenta':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorFormatoVenta->RegistroFormatoVenta();
        } else {
            include('./views/propiedades/formatoVenta/registrarFormtVenta.php');
        }
        break;


    //Consulta Formato Venta
    case 'consultaFormatoVenta';
        $tipo = '';
        $filtro = '';
        $data = $controladorFormatoVenta->listaFormatoVentas($tipo, $filtro);
        include('./views/propiedades/formatoVenta/consultaFormtVenta.php');
        break;

    case 'consultaFormatoVentaId';
        $valor = $_GET['idFormatoVenta'] ?? '';
        $data = $controladorFormatoVenta->listaFormatoVentaFiltrado('codigo', $valor);
        include('./views/propiedades/formatoVenta/consultaFormtVenta.php');
        break;

    case 'consultaFormatoVentaNombre';
        $valor = $_GET['nomFormatoVenta'] ?? '';
        $data = $controladorFormatoVenta->listaFormatoVentaFiltrado('nomFormatoVenta', $valor);
        include('./views/propiedades/formatoVenta/consultaFormtVenta.php');
        break;


    //Actualizar Formato Venta
    case 'actualizarFormatoVentaId':
        $formatoVentas = $controladorFormatoVenta->ConsultFormatoVentaId();
        include('./views/propiedades/formatoVenta/actualizarFormtVenta.php');
        break;

    case 'actualizarFormatoVenta':
        $controladorFormatoVenta->ActualizarFormatoVenta();
        break;


    //Eliminar Formato Venta
    case 'eliminarFormatoVentaId':
        $controladorFormatoVenta->EliminarFormatoVenta();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Proveedor

    //Registro Proveedor
    case 'registroProveedor':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProveedor->RegistroProveedor();
        } else {
            include('./views/proveedor/registroProveedor.php');
        }
        break;


    //Consulta Proveedor
    case 'consultaProveedor';
        $tipo = '';
        $filtro = '';
        $data = $controladorProveedor->listaProveedores($tipo, $filtro);
        include('./views/proveedor/consultaProveedor.php');
        break;

    case 'consultaProveedorNit';
        $valor = $_GET['nitProveedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('codigo', $valor);
        include('./views/proveedor/consultaProveedor.php');
        break;

    case 'consultaProveedorNombre';
        $valor = $_GET['nomProveedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('nombreP', $valor);
        include('./views/proveedor/consultaProveedor.php');
        break;

    case 'consultaVendedorNombre';
        $valor = $_GET['nomVendedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('nombreV', $valor);
        include('./views/proveedor/consultaProveedor.php');
        break;


    //Actualizar Proveedor
    case 'actualizarProveedorId':
        $proveedores = $controladorProveedor->proveedorId();
        include('./views/proveedor/actualizarProveedor.php');
        break;

    case 'actualizarProveedor':
        $controladorProveedor->ActualizarProveedor();
        break;


    //Eliminar Proveedor
    case 'eliminarProveedorId':
        $controladorProveedor->EliminarProveedor();
        break;

//============================================================================================================================================

//Modulo Empleado

//Proveedor

    //Registro Proveedor empleado
    case 'registroProveedorEmp':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProveedor->RegistroProveedor();
        } else {
            include('./views/proveedor/registroProveedorEmp.php');
        }
        break;


    //Consulta Proveedor empleado
    case 'consultaProveedorEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorProveedor->listaProveedores($tipo, $filtro);
        include('./views/proveedor/consultaProveedorEmp.php');
        break;

    case 'consultaProveedorNitEmp';
        $valor = $_GET['nitProveedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('codigo', $valor);
        include('./views/proveedor/consultaProveedorEmp.php');
        break;

    case 'consultaProveedorNombreEmp';
        $valor = $_GET['nomProveedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('nombreP', $valor);
        include('./views/proveedor/consultaProveedorEmp.php');
        break;

    case 'consultaVendedorNombreEmp';
        $valor = $_GET['nomVendedor'] ?? '';
        $data = $controladorProveedor->listaProveedoresFiltrado('nombreV', $valor);
        include('./views/proveedor/consultaProveedorEmp.php');
        break;


    //Actualizar Proveedor empleado
    case 'actualizarProveedorIdEmp':
        $proveedores = $controladorProveedor->proveedorId();
        include('./views/proveedor/actualizarProveedorEmp.php');
        break;

    case 'actualizarProveedorEmp':
        $controladorProveedor->ActualizarProveedor();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Clientes

    //Registro Clientes
    case 'registroCliente':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorCliente->registroCliente();
        } else {
            $tipoDocum = $controladorTipoDocum->listaTiposDocum();
            include('./views/cliente/registroCliente.php');
        }
        break;


    //Consulta Clientes
    case 'consultaCliente';
        $tipo = '';
        $filtro = '';
        $data = $controladorCliente->listaClientesVista($tipo, $filtro);
        include('./views/cliente/consultaCliente.php');
        break;

    case 'consultaClienteCedula';
        $valor = $_GET['documCliente'] ?? '';
        $data = $controladorCliente->listaClientesFiltrado('codigo', $valor);
        include('./views/cliente/consultaCliente.php');
        break;

    case 'consultaClienteNombre';
        $valor = $_GET['nomCliente'] ?? '';
        $data = $controladorCliente->listaClientesFiltrado('nomCliente', $valor);
        include('./views/cliente/consultaCliente.php');
        break;


    //Actualizar Cliente
    case 'actualizarClienteId':
        $clientes = $controladorCliente->datosClienteId();
        $tipoDocum = $controladorTipoDocum->listaTiposDocum();
        include('./views/cliente/actualizarCliente.php');
        break;

    case 'actualizarCliente':
        $controladorCliente->ActualizarCliente();
        break;


    //Eliminar Cliente
    case 'eliminarClienteId':
        $controladorCliente->EliminarCliente();
        break;

//============================================================================================================================================

//Modulo Empleado

//Cliente

    //Registro Clientes empleado
    case 'registroClienteEmp':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorCliente->registroCliente();
        } else {
            $tipoDocum = $controladorTipoDocum->listaTiposDocum();
            include('./views/cliente/registroClienteEmp.php');
        }
        break;


    //Consulta Clientes empleado
    case 'consultaClienteEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorCliente->listaClientesVista($tipo, $filtro);
        include('./views/cliente/consultaClienteemp.php');
        break;

    case 'consultaClienteCedulaEmp';
        $valor = $_GET['documCliente'] ?? '';
        $data = $controladorCliente->listaClientesFiltrado('codigo', $valor);
        include('./views/cliente/consultaClienteEmp.php');
        break;

    case 'consultaClienteNombreEmp';
        $valor = $_GET['nomCliente'] ?? '';
        $data = $controladorCliente->listaClientesFiltrado('nomCliente', $valor);
        include('./views/cliente/consultaClienteEmp.php');
        break;


    //Actualizar Cliente  empleado
    case 'actualizarClienteIdEmp':
        $clientes = $controladorCliente->datosClienteId();
        $tipoDocum = $controladorTipoDocum->listaTiposDocum();
        include('./views/cliente/actualizarClienteEmp.php');
        break;

    case 'actualizarClienteEmp':
        $controladorCliente->ActualizarCliente();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Entrada de Productos

    //Registro Entrada Productos
    case 'registroEntProductos':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorEntProducto->RegistroEntProducto();
        } else {
            include('./views/entradaProducto/registrarEntProducto.php');
        }
        break;


    //Consulta Entrada Productos
    case 'consultaEntProductos';
        $tipo = '';
        $filtro = '';
        $data = $controladorEntProducto->listaEntProductosVista($tipo, $filtro);
        include('./views/entradaProducto/consultaEntProductos.php');
        break;

    case 'consultaEntProductoCodigo';
        $valor = $_GET['codProducto'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltrado('codigo', $valor);
        include('./views/entradaProducto/consultaEntProductos.php');
        break;

    case 'consultaEntProductoFecha';
        $valor = $_GET['fechaEnt'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltrado('fechaEnt', $valor);
        include('./views/entradaProducto/consultaEntProductos.php');
        break;


    //Actualizar Entrada Productos
    case 'actualizarEntProductosId':
        $entProductos = $controladorEntProducto->consultaGenEntProductosId();
        include('./views/entradaProducto/actualizarEntProducto.php');
        break;

    case 'actualizarEntProductos':
        $controladorEntProducto->ActualizarEntProducto();
        break;


    //Eliminar Cliente
    case 'eliminarEntProductoId':
        $controladorEntProducto->EliminarEntProducto();
        break;

//============================================================================================================================================

//Modulo Empleado

//Entrada de Productos

    //Registro Entrada Productos
    case 'registroEntProductosEmp':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorEntProducto->RegistroEntProducto();
        } else {
            include('./views/entradaProducto/registrarEntProductosEmp.php');
        }
        break;


    //Consulta Entrada Productos
    case 'consultaEntProductosEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorEntProducto->listaEntProductosVista($tipo, $filtro);
        include('./views/entradaProducto/consultaEntProductosEmp.php');
        break;

    case 'consultaEntProductoCodigoEmp';
        $valor = $_GET['codProducto'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltrado('codigo', $valor);
        include('./views/entradaProducto/consultaEntProductosEmp.php');
        break;

    case 'consultaEntProductoFechaEmp';
        $valor = $_GET['fechaEnt'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltrado('fechaEnt', $valor);
        include('./views/entradaProducto/consultaEntProductosEmp.php');
        break;


    //Actualizar Entrada Productos empleado
    case 'actualizarEntProductosIdEmp':
        $entProductos = $controladorEntProducto->consultaGenEntProductosId();
        include('./views/entradaProducto/actualizarEntProductoEmp.php');
        break;

    case 'actualizarEntProductosEmp':
        $controladorEntProducto->ActualizarEntProducto();
        break;

//==========================================================================================================================================================

//Modulo Administrativo

//Salida de Productos

    //Registro Salida Productos
    case 'registroSalProductos':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorSalProducto->RegistroSalProducto();
        } else {
            $formaPagos = $controladorModoPago->listaModoPago();
            include('./views/salidaProducto/registrarSalProducto.php');
        }
        break;


    //Registro Salida Productos
    case 'registroSalProductosP':
        $formaPagos = $controladorModoPago->listaModoPago();
        include('./views/salidaProducto/registroSalProductos.php');
        break;


    //Consulta Salida Productos
    case 'consultaSalProductos';
        $tipo = '';
        $filtro = '';
        $data = $controladorSalProducto->listaSalProductosVista($tipo, $filtro);
        include('./views/salidaProducto/consultaSalProducto.php');
        break;

    case 'consultaSalProductoCodigo';
        $valor = $_GET['codProducto'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltrado('codigo', $valor);
        include('./views/salidaProducto/consultaSalProducto.php');
        break;

    case 'consultaSalProductoFecha';
        $valor = $_GET['fechaSal'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltrado('fechaSal', $valor);
        include('./views/salidaProducto/consultaSalProducto.php');
        break;


    //Actualizar Salida Productos
    case 'actualizarSalProductosId':
        $salProductos = $controladorSalProducto->consultaGenSalProductosId();
        $formaPagos = $controladorModoPago->listaModoPago();
        include('./views/salidaProducto/actualizarSalProducto.php');
        break;

    case 'actualizarSalProductos':
        $controladorSalProducto->ActualizarSalProductos();
        break;


    //Eliminar Salida Producto
    case 'eliminarSalProductoId':
        $controladorSalProducto->EliminarSalProducto();
        break;

//============================================================================================================================================

//Modulo Empleado

//Salida de Productos

    //Registro Salida por Producto
    case 'registroSalProductosEmp':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorSalProducto->RegistroSalProducto();
        } else {
            $formaPagos = $controladorModoPago->listaModoPago();
            include('./views/salidaProducto/registrarSalProductoEmp.php');
        }
        break;


    //Registro Salida de Productos
    case 'registroSalProductosEmpP':
        $formaPagos = $controladorModoPago->listaModoPago();
        include('./views/salidaProducto/registroSalProductoEmp.php');
        break;


    //Consulta Salida Productos
    case 'consultaSalProductosEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorSalProducto->listaSalProductosVista($tipo, $filtro);
        include('./views/salidaProducto/consultaSalProductoEmp.php');
        break;

    case 'consultaSalProductoCodigoEmp';
        $valor = $_GET['codProducto'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltrado('codigo', $valor);
        include('./views/salidaProducto/consultaSalProductoEmp.php');
        break;

    case 'consultaSalProductoFechaEmp';
        $valor = $_GET['fechaSal'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltrado('fechaSal', $valor);
        include('./views/salidaProducto/consultaSalProductoEmp.php');
        break;


    //Actualizar Salida Productos
    case 'actualizarSalProductosIdEmp':
        $salProductos = $controladorSalProducto->consultaGenSalProductosId();
        $formaPagos = $controladorModoPago->listaModoPago();
        include('./views/salidaProducto/actualizarSalProductosEmp.php');
        break;

    case 'actualizarSalProductosEmp':
        $controladorSalProducto->ActualizarSalProductos();
        break;

//============================================================================================================================================

//Modulo Administrativo

//Reportes

    //Inventario
    case 'reporteInventario':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaInventarioActualizado($tipo, $filtro);
        include('./views/inventario/inventarioActual.php');
        break;

    //Filtra por nombre del Producto
    case 'consultaProductosNombreInventario':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosFiltrado('nombre', $valor);
        include('./views/inventario/inventarioActual.php');
        break;

    //Genera reporte de inventario en PDF
    case 'reporteInventarioPDF':
        $inventarios = $controladorInventario->inventarioActual();
        include('./views/inventario/reporteInventarioPDF.php');
        break;


    //Inventario Bajo de Stock
    case 'reporteSinStock':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaInventarioSinStock($tipo, $filtro);
        include('./views/inventario/inventarioSinStock.php');
        break;

    //Filtra por nombre del Producto
    case 'consultaProductosNombreSinStock':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosFiltradoSinStock('nombre', $valor);
        include('./views/inventario/inventarioSinStock.php');
        break;

    //Genera reporte de inventario Bajo de Stock en PDF
    case 'reporteSinStockPDF':
        $inventarios = $controladorInventario->ProductoSinStock();
        include('./views/inventario/reporteSinStockPDF.php');
        break;


    //Entrada de Productos
    case 'reporteEntProducto':
        include('./views/entradaProducto/generarInforEntProductos.php');
        break;

    //Filtro por fecha de inicio y fin
    case 'reporteEntProductoFecha':
        $tipo = '';
        $filtro = '';
        $data = $controladorEntProducto->listaEntProductos($tipo, $filtro);
        include('./views/entradaProducto/reporteEntProductos.php');
        break;

    case 'consultaEntProductosNombre':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltradoNombre('nombre', $valor);
        include('./views/entradaProducto/reporteEntProductos.php');
        break;

    //Genera reporte de Entrada producto en PDF
    case 'reporteEntProductosPDF':
        $entProductos = $controladorEntProducto->ReporteEntProductos();
        include('./views/entradaProducto/reporteEntProductosPDF.php');
        break;


    //Salida de Productos
    case 'reporteSalProducto':
        include('./views/salidaProducto/generarInforSalProductos.php');
        break;

    //Filtro por fecha de inicio y fin
    case 'reporteSalProductoFecha';
        $tipo = '';
        $filtro = '';
        $data = $controladorSalProducto->listaSalProductos($tipo, $filtro);
        include('./views/salidaProducto/reporteSalProducto.php');
        break;

    case 'consultaSalProductosNombre';
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltradoNombre('nombre', $valor);
        include('./views/salidaProducto/reporteSalProducto.php');
        break;

    //Genera Consulta de reporte de Salida producto en PDF
    case 'reporteSalProductosPDF';
        $salProductos = $controladorSalProducto->ReporteSalProductos();
        include('./views/salidaProducto/reporteSalProductosPDF.php');
        break;


    //Productos Proximos a Vencer
    case 'productosAvencer':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaProductosAvencer($tipo, $filtro);
        include('./views/productosAvencer/productosProximosAvencer.php');
        break;

    //Filtra por nombre del Producto
    case 'productosAvencerNombre':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosAvencerFiltrado('nombre', $valor);
        include('./views/productosAvencer/productosProximosAvencer.php');
        break;

    //Genera reporte de productos a vencer en pdf
    case 'productosAvencerPDF':
        $productosAvencer = $controladorInventario->ProductosAvencer();
        include('./views/productosAvencer/reporteProductosAvencerPDF.php');
        break;

//============================================================================================================================================

//Verificaciones

    //Verificacion codigo de barra del productos
    case 'verificacionCodigoProductos':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->productoCodProducto();
        }
        break;

    //Verificacion Nit proveedor
    case 'verificacionNitProveedor':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProveedor->nitProveedor();
        }
        break;

    //Verificacion Identificacion Cliente
    case 'verificacionCliente':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorCliente->verificacionCliente();
        }
        break;


    //Verificacion de Stock del producto
    case 'verificacionStock':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorInventario->disponibilidadProducto();
        }
        break;


    //Consulta para generar codigo de barras
    case 'generaCodigoProducto':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorGenerarCodigo->ConsecutivoCodigo();
        }
        break;


    //Consulta para traer datos del producto
    case 'informacionProducto':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->informacionProducto();
        }
        break;


    //Actualizacion de puntos Cliente vista salida de productos Varios
    case 'actualizarPuntosCliente':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorCliente->PuntosActualizados();
        }
        break;


    //Actualizacion del Stock del producto del vista salida de productos Varios
    case 'actualizarStock':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorInventario->actualizarInventario();
        }
        break;


    //Proceso de Registro de Salida de Productos Varios
    case 'registrarSalProductos':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorSalProducto->registrosSalProductos();
        }
        break;


    //Consulta de Productos con menor Stock
    case 'productosMenorStock':
        $controladorInventario->ProductosMenorStock();
        break;


    //Consulta de Productos con mayor venta gafica
    case 'productosMayorVenta':
        $controladorSalProducto->ProductosMasVendidos();
        break;


    //Consulta de Ventas por Dias
    case 'ventasPorDias':
        $controladorSalProducto->VentasPorDias();
        break;


    //Consulta Mayor Entrada de Producto
    case 'mayorEntProductos':
        $controladorEntProducto->ProductosMayorEntrada();
        break;


    //Consulta para mostrar productos segun clase paginaP
    case 'productosPorClase':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->ProductosPorClase();
        }
        break;


    //Consulta de Productos con mayor venta pagina principal
    case 'productosMayorVentaP':
        $controladorSalProducto->ProductosMayorVenta();
        break;


    //Consulta para verificar usuario
    case 'verificarUsuario':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorUsuario->ConsultaUsuario();
        }
        break;


    //Consulta de Productos proximos a Vencer
    case 'productosProximosAvencer':
        $controladorInventario->ProductosProximosAvencer();
        break;


    //Consulta de Producto por nombre
    case 'consultaProductoNombre':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorProducto->ProductosPorNombre();
        }
        break;

    //Consulta de Producto por codigo
    case 'verificacionCodigoProductosPromo':
        $controladorInventario->VerificarCodProductoPromo();
        break;

//============================================================================================================================================

//Modulo Empleado

//Reportes

    //Inventario
    case 'reporteInventarioEmp':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaInventarioActualizado($tipo, $filtro);
        include('./views/inventario/inventarioActualEmp.php');
        break;

    //Filtra por nombre del Producto
    case 'consultaProductosNombreInventarioEmp':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosFiltrado('nombre', $valor);
        include('./views/inventario/inventarioActualEmp.php');
        break;


    //Inventario Bajo de Stock
    case 'reporteSinStockEmp':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaInventarioSinStock($tipo, $filtro);
        include('./views/inventario/reporteSinStockEmp.php');
        break;

    //Filtra por nombre del Producto
    case 'consultaProductosNombreSinStockEmp':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosFiltradoSinStock('nombre', $valor);
        include('./views/inventario/reporteSinStockEmp.php');
        break;


    //Entrada de Productos
    case 'reporteEntProductoEmp':
        include('./views/entradaProducto/generarInforEntProductoEmp.php');
        break;

    case 'reporteEntProductoFechaEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorEntProducto->listaEntProductos($tipo, $filtro);
        include('./views/entradaProducto/reporteEntProductosEmp.php');
        break;

        case 'consultaEntProductosNombreEmp':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorEntProducto->listaEntProductosFiltradoNombre('nombre', $valor);
        include('./views/entradaProducto/reporteEntProductosEmp.php');
        break;


    //Salida de Productos
    case 'reporteSalProductoEmp':
        include('./views/salidaProducto/generarSalProductoEmp.php');
        break;

    case 'reporteSalProductoFechaEmp';
        $tipo = '';
        $filtro = '';
        $data = $controladorSalProducto->listaSalProductos($tipo, $filtro);
        include('./views/salidaProducto/reporteSalProductoEmp.php');
        break;

    case 'consultaSalProductosNombreEmp';
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorSalProducto->listaSalProductosFiltradoNombre('nombre', $valor);
        include('./views/salidaProducto/reporteSalProductoEmp.php');
        break;


    //Productos Proximos a Vencer
    case 'productosAvencerEmp':
        $tipo = '';
        $filtro = '';
        $data = $controladorInventario->listaProductosAvencer($tipo, $filtro);
        include('./views/productosAvencer/prodProxAVencerEmp.php');
        break;

    case 'productosAvencerNombreEmp':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorInventario->listaProductosAvencerFiltrado('nombre', $valor);
        include('./views/productosAvencer/prodProxAVencerEmp.php');
        break;

//==============================================================================================================================

//Modulo Administrativo

//Carousel

        //Registro Promociones
    case 'registroPromocion':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controladorCarousel->registroPromociones();
        } else {
            include('./views/promociones/registrarPromocion.php');
        }
        break;


        //Consulta Promociones
    case 'consultaPromociones':
        $tipo = '';
        $filtro = '';
        $data = $controladorCarousel->listaCarouselVista($tipo, $filtro);
        include('./views/promociones/consultaPromociones.php');
        break;

    case 'consultaPromocionesCodigo':
        $valor = $_GET['codProducto'] ?? '';
        $data = $controladorCarousel->listaPromocionesFiltrado('codigo', $valor);
        include('./views/promociones/consultaPromociones.php');
        break;

    case 'consultaPromocionesNombre':
        $valor = $_GET['nombre'] ?? '';
        $data = $controladorCarousel->listaPromocionesFiltrado('nombre', $valor);
        include('./views/promociones/consultaPromociones.php');
        break;


        //Actualizar Promociones
    case 'actualizarPromocionId':
        $promocion = $controladorCarousel->consultarPromocionId();
        include('./views/promociones/actualizarPromociones.php');
        break;

    case 'actualizarPromocion':
        $controladorCarousel->ActualizarPromocion();
        break;


    //Eliminar Promociones
    case 'eliminarPromocionId':
        $controladorCarousel->EliminarPromocion();
        break;


    default:
        $action = 'Principal';
        break;
}
