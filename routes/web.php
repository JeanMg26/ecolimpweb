<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//    return view('welcome');
// });
Auth::routes();

Route::middleware(['auth'])->group(function () {

   Route::resource('/', MainController::class);
   // *************** PERMISOS ****************************
   Route::resource('permisos', PermisoController::class);
   Route::get('permisos-data', [PermisoController::class, 'datatables'])->name('permisos.data');
   Route::post('permisos/update', [PermisoController::class, 'update'])->name('permisos.update');
   Route::get('permisos/destroy/{id}', [PermisoController::class, 'destroy']);
   // Cambiar estado
   Route::get('cambiar-estadopermiso', [PermisoController::class, 'cambiarEstadoPermiso'])->name('cambiar.estadopermiso');

   // *************** ROLES ****************************
   Route::resource('roles', RolController::class);
   Route::get('roles-data', [RolController::class, 'datatables'])->name('roles.data');
   Route::get('roles/destroy/{id}', [RolController::class, 'destroy']);
   // Cambiar estado
   Route::get('cambiar-estadorol', [RolController::class, 'cambiarEstadoRol'])->name('cambiar.estadorol');

   // ****************** USUARIOS ***********************
   Route::resource('usuarios', UserController::class);
   Route::get('usuarios-data', [UserController::class, 'datatables'])->name('usuarios.data');
   Route::get('usuarios/destroy/{id}', [UserController::class, 'destroy']);
   // Resetear contraseña
   Route::get('reset-password', [UserController::class, 'resetPassword'])->name('reset.password');
   // Cambiar estado
   Route::get('cambiar-estadousuario', [UserController::class, 'cambiarEstadoUsuario'])->name('cambiar.estadousuario');
   // Editar Perfil Usuario - Modal
   Route::get('usuarios/{id}/editar_perfil', [UserController::class, 'editarPerfilUsuario'])->name('editar_perfil.usuario');
   Route::post('usuarios/actualizar_perfil', [UserController::class, 'actualizarPerfilUsuario'])->name('actualizar_perfil.usuario');
   // ********** RECARGAR SOLO LA FOTO Y NOMBRE DEL USUARIO AL EDITAR DESDE MODAL *************
   Route::get('/load_perfil', function () {
      return view('segmentos.load_perfil');
   });

   // ****************** EMPLEADOS ***********************
   Route::resource('empleados', EmpleadoController::class);
   Route::get('empleados-data', [EmpleadoController::class, 'datatables'])->name('empleados.data');
   Route::get('empleados/destroy/{id}', [EmpleadoController::class, 'destroy']);
   // Cambiar estado
   Route::get('cambiar-estadoempleado', [EmpleadoController::class, 'cambiarEstadoEmpleado'])->name('cambiar.estadoempleado');

   // ****************** CATEGORIA ***********************
   Route::resource('categorias', CategoriaController::class);
   Route::get('categorias-data', [CategoriaController::class, 'datatables'])->name('categorias.data');
   Route::post('categorias/update', [CategoriaController::class, 'update'])->name('categorias.update');
   Route::get('categorias/destroy/{id}', [CategoriaController::class, 'destroy']);
   // Cambiar estado
   Route::get('categorias-estadocategoria', [CategoriaController::class, 'cambiarEstadoCategoria'])->name('cambiar.estadocategoria');

   // ****************** PRODUCTOS ***********************
   Route::resource('productos', ProductoController::class);
   Route::get('productos-data', [ProductoController::class, 'datatables'])->name('productos.data');
   Route::get('productos/destroy/{id}', [ProductoController::class, 'destroy']);
   // Cambiar estado
   Route::get('productos-estadoproducto', [ProductoController::class, 'cambiarEstadoProducto'])->name('cambiar.estadoproducto');
   // Nueva CAtegoria
   Route::get('productos-nuevacategoria', [ProductoController::class, 'nuevaCaegoria'])->name('productos.nuevacategoria');
   // Buscar productos
   Route::get('filtrar_producto', [ProductoController::class, 'filtrar_producto'])->name('filtrar_producto');

   // ****************** INSTALACIONES ***********************
   Route::resource('instalaciones', InstalacionController::class);
   Route::get('instalaciones-data', [InstalacionController::class, 'datatables'])->name('instalaciones.data');
   Route::get('instalaciones/destroy/{id}', [InstalacionController::class, 'destroy']);
   // Cambiar estado
   Route::get('instalaciones-estadoinstalacion', [InstalacionController::class, 'cambiarEstadoInstalacion'])->name('cambiar.estadoinstalacion');
   // Ubigeo
   Route::get('/instalaciones_provincias.data', [InstalacionController::class, 'instalaciones_provincias'])->name('instalaciones_provincias.data');
   Route::get('instalaciones_comunas.data', [InstalacionController::class, 'instalaciones_comunas'])->name('instalaciones_comunas.data');
   // Buscar instalaciones
   Route::get('filtrar_instalacion', [InstalacionController::class, 'filtrar_instalacion'])->name('filtrar_instalacion');

// ****************** PROVEEDORES ***********************
   Route::resource('proveedores', ProveedorController::class);
   Route::get('proveedores-data', [ProveedorController::class, 'datatables'])->name('proveedores.data');
   Route::get('proveedores/destroy/{id}', [ProveedorController::class, 'destroy']);
   // Cambiar estado
   Route::get('proveedores-estadoproveedor', [ProveedorController::class, 'cambiarEstadoProveedor'])->name('cambiar.estadoproveedor');
   // Ubigeo
   Route::get('proveedor_provincias.data', [ProveedorController::class, 'proveedor_provincias'])->name('proveedor_provincias.data');
   Route::get('proveedor_comunas.data', [ProveedorController::class, 'proveedor_comunas'])->name('proveedor_comunas.data');
   // Buscar proveedores
   Route::get('filtrar_proveedor', [ProveedorController::class, 'filtrar_proveedor'])->name('filtrar_proveedor');

   // ****************** INGRESO DE PRODUCTOS ***********************
   Route::resource('ingresos', IngresoController::class);
   Route::get('ingresos-data', [IngresoController::class, 'datatables'])->name('ingresos.data');
   Route::post('ingresos/update', [IngresoController::class, 'update'])->name('ingresos.update');
   Route::get('ingresos/destroy/{id}', [IngresoController::class, 'destroy']);
   // Traer Datos del Proveedor
   Route::get('datos_proveedor', [IngresoController::class, 'datos_proveedor'])->name('datos_proveedor');
   // Autocomplete
   Route::get('buscar/productos/ingresos', [IngresoController::class, 'buscar_producto'])->name('buscar_producto');
   Route::get('buscar/proveedores', [IngresoController::class, 'buscar_proveedor'])->name('buscar_proveedor');
   // Impresiones
   Route::get('impresion_ingreso', [IngresoController::class, 'impresion_pdf'])->name('impresion.ingresos');

   // ****************** SALIDA DE PRODUCTOS ***********************
   Route::resource('salidas', SalidaController::class);
   Route::get('salidas-data', [SalidaController::class, 'datatables'])->name('salidas.data');
   Route::post('salidas/update', [SalidaController::class, 'update'])->name('salidas.update');
   Route::get('salidas/destroy/{id}', [SalidaController::class, 'destroy']);
   Route::get('buscar/productos/salidas', [SalidaController::class, 'buscar_producto'])->name('buscar_producto.salida');
   Route::get('datos_instalacion', [SalidaController::class, 'datos_instalacion'])->name('datos_instalacion.salida');
   Route::get('buscar/instalaciones', [SalidaController::class, 'buscar_instalaciones'])->name('buscar_instalacion');
   // Impresiones
   Route::get('impresion_egreso', [SalidaController::class, 'impresion_pdf'])->name('impresion.salidas');

   // ****************** CONSULTAS DE MATERIALES ENTREGADOS ***********************
   Route::resource('consultas', ConsultaController::class);
   Route::get('consultas-data', [ConsultaController::class, 'datatables'])->name('consultas.data');
   Route::get('buscar/productos/consultas', [ConsultaController::class, 'buscar_producto'])->name('buscar_producto.consulta');
   Route::get('buscar/instalaciones/consultas', [ConsultaController::class, 'buscar_instalaciones'])->name('buscar_instalacion.consulta');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
