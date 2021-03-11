<?php

use Illuminate\Support\Facades\Route;

//<!***** Ingreso *****!>
Route::get('/', 'UserController@mostrarLogin')->name('login');
Route::post('/', 'UserController@verificarDatos');
Route::post('logout', 'UserController@logout')->name('logout');
Route::get('logout', 'UserController@logout');
Route::get('/Registro', 'UserController@mostrarFrmRegistro')->name('Registro');
Route::post('/Registro', 'UserController@Registro');
Route::get('home', 'PerfilController@mostrarFrmInicio')->name('home');
Route::get('home/cambiarfoto', 'PerfilController@mostrarFrmFoto')->name('cambiarfoto');
Route::post('home/cambiarfoto', 'PerfilController@guardarFoto');

//***************************** RUTAS PARA EL TRABAJADOR
Route::resource('abastecimiento/mesas', 'MesaController');
Route::resource('abastecimiento/tipoplato', 'TipoPlatoController');
Route::get('abastecimiento/tipoplato/{id}/confirmar', 'TipoPlatoController@confirmar')->name('tipoplato.confirmar');
Route::resource('abastecimiento/plato', 'PlatoController');
Route::get('abastecimiento/plato/{id}/confirmar', 'PlatoController@confirmar')->name('plato.confirmar');

Route::resource('abastecimiento/categoria', 'CategoriaController');
Route::get('abastecimiento/categoria/{id}/confirmar', 'CategoriaController@confirmar')->name('categoria.confirmar');
Route::resource('abastecimiento/producto', 'ProductoController');
Route::get('abastecimiento/producto/{id}/confirmar', 'ProductoController@confirmar')->name('producto.confirmar');

Route::resource('abastecimiento/programacion', 'ProgramacionController');
Route::get('abastecimiento/programacion/{id}/confirmar', 'ProgramacionController@confirmar')->name('programacion.confirmar');
Route::get('abastecimiento/programacion/{id}/detalles', 'ProgramacionController@detalles')->name('programacion.detalles');

Route::get('ventas/enlocal/pedidos/{id}/crearPedido', 'TPedidoController@crearPedido')->name('tpedidos.crearPedido');
Route::get('ventas/enlocal/mesas/{id}/liberar', 'MesaController@liberarMesa')->name('mesas.liberarMesa');
Route::post('ventas/enlocal/mesas/{id}/liberar', 'MesaController@liberar');
Route::resource('ventas/delivery/pedidos', 'TPedidoController');

Route::get('consultas/clientes', 'ClienteController@mostrarclientes')->name('consultas.clientes');
Route::get('consultas/clientes/{id}/pedidos', 'ClienteController@pedidosxclientes')->name('consultas.clientes.pedidos');
Route::get('consultas/pedidos', 'PedidoController@listaPedidos')->name('consultas.pedidos');
Route::get('consultas/pedidos/{id}/detalles', 'PedidoController@detalles')->name('consultas.pedidos.detalles');

Route::resource('cobranza/recibos', 'ReciboController');
Route::get('consultas/pedidosAtendidos', 'PedidoController@pedidosAtendidos')->name('consultas.pedidos.atendidos');
Route::get('/BuscarTipo/{id}', 'ReciboController@BuscarTipo');
Route::get('consultas/recibos', 'ReciboController@ListarRecibos')->name('consultas.recibos');
Route::get('consultas/recibos/{id}/detallesRecibo', 'ReciboController@detallesRecibo')->name('recibos.detallesRecibo');
Route::get('consultas/ventasdiarias', 'ReciboController@ventasdiarias')->name('consultas.ventasdiarias');

Route::get('home/atencion', 'PedidoController@listaPendientes')->name('home.atencion');
Route::get('home/atencion/{id}/atender', 'PedidoController@atender')->name('home.atencion.atender');
Route::post('home/atencion/{id}/atender', 'PedidoController@atendido');
Route::get('home/atencion/{id}/anular', 'PedidoController@anular')->name('home.atencion.anular');
Route::post('home/atencion/{id}/anular', 'PedidoController@anulado');
Route::get('/BuscarPedido/{id}', 'ClienteController@PedidoCodigo');


//***************************** RUTAS PARA EL CLIENTE
Route::get('home/hoy', 'ProgramacionController@mostrarProgramacion')->name('home.hoy');
Route::resource('operaciones/pedidosCliente', 'PedidoController');
Route::get('consultas/pedidosCliente', 'PedidoController@inicio')->name('pedidosCliente.inicio');
Route::get('consultas/pedidosCliente/{id}/confirmar', 'PedidoController@confirmar')->name('pedidosCliente.confirmar');
Route::get('consultas/pedidosCliente/{id}/detalles', 'Pedidocontroller@detalles_pedido')->name('pedidosCliente.detalles');
Route::get('consultas/recibosCliente', 'ReciboController@listarRecibosxCliente')->name('recibosCliente.listarRecibos');
Route::get('consultas/recibosCliente/{id}/detalles', 'ReciboController@detallesRec')->name('recibosCliente.detallesRec');

//***************************** RUTAS IMPRIMIR
Route::get('reportes/Recibo/{id}', 'ReporteController@imprimirRecibo')->name('imprimirRecibo');
Route::get('reportes/Pedido/{id}', 'ReporteController@imprimirPedido')->name('imprimirPedido');
Route::get('reportes/tVentasDiarias', 'ReporteController@imprimirtVentasDiarias')->name('imprimirtVentasDiarias');
Route::get('reportes/VentasDiariasTotales', 'ReporteController@imprimirVentasTotalesDiarias')->name('imprimirVentasTotalesDiarias');

//***************************** RUTAS PARA EL ADMINISTRADOR
Route::resource('trabajadores/MiGente', 'TrabajadorController');
Route::get('trabajadores/ListaTrabajadores', 'TrabajadorController@ListaTrabajadores')->name('ListaTrabajadores');
Route::get('trabajadores/ClavePersonal', 'TrabajadorController@ClavePersonal')->name('ClavePersonal');
Route::post('trabajadores/ClavePersonal', 'TrabajadorController@CambiarClavePersonal');

Route::get('consultas/MiGente', 'TrabajadorController@ListaTrabajadores_')->name('ListaTrabajadores_');
Route::get('consultas/MiGente/{id}/foto', 'TrabajadorController@foto')->name('foto');
Route::post('consultas/MiGente/{id}/foto', 'TrabajadorController@storeFoto');
Route::get('consultas/MisClientes', 'TrabajadorController@ListaClientes')->name('ListaClientes');
Route::get('consultas/Recibos', 'TrabajadorController@ListaRecibos')->name('ListaRecibos');
Route::get('consultas/MontoEnCaja', 'TrabajadorController@MontoEnCaja')->name('MontoEnCaja');
Route::get('consultas/ResumenCaja', 'CajaController@Resumen')->name('resumencaja');

//
Route::get('home/AperturarCaja', 'CajaController@AperturarCaja')->name('aperturarcaja');
Route::post('home/AperturarCaja', 'CajaController@Aperturar');
Route::get('home/CerrarCaja', 'CajaController@CerrarCaja')->name('cerrarcaja');
Route::post('home/CerrarCaja', 'CajaController@Cerrar');

//***************************** RUTAS PARA EL COCINERO
Route::get('home/atenderPedidos', 'CPedidoController@listaConfirmados')->name('home.listaConfirmados');
Route::get('home/atenderPedidos/{id}/atender', 'CPedidoController@mostrarPedido')->name('home.mostrarPedido');
Route::post('home/atenderPedidos/{id}/atender', 'CPedidoController@atender');


//Cajero
Route::get('VerificarPassword/{clave}', 'TPedidoController@VerificarPassword');

Route::resource('clientes', 'MClienteController');


Route::get('AtenderPedidos', 'TPedidoController@AtenderPedidos')->name('AtenderPedidos');
Route::get('AtenderPedidos/{id}/Atender', 'TPedidoController@Atender')->name('AtenderPedido');
Route::post('AtenderPedidos/{id}/Atender', 'TPedidoController@Atendido');

Route::get('ModificarPedidos', 'TPedidoController@ModificarPedidos')->name('ModificarPedidos');
Route::get('ModificarPedidos/{id}/Modificar', 'TPedidoController@Modificar')->name('ModificarPedido');
Route::post('ModificarPedidos/{id}/Modificar', 'TPedidoController@Modificado');
//Test
Route::get('CrearAdmin', 'AdminController@CrearAdmin');

//admin
route::resource('NotaIngreso', 'NotaController');
route::get('home/ReporteBebidas', 'ReporteAdminController@StockProductos')->name('stockProductos');
route::get('home/ReportePlatos', 'ReporteAdminController@StockPlatos')->name('stockPlatos');


route::get('CobrarPedido/{id}', 'ReciboController@CobrarPedido')->name('cobrarpedido');
route::post('CobrarPedido/{id}', 'ReciboController@Cobrado');


route::get('home/ImprimirPedido/{id}', 'TPedidoController@ImprimirPedido')->name('imprimirTPedido');
route::get('home/ImprimirPedidoEstado/{id}', 'TPedidoController@ImprimirPedidoEstado')->name('imprimirTPedidoEstado');
route::get('GenerarProgramacion', 'ProgramacionController@GenerarProgramacion')->name('GenerarProgramacion');

Route::get('VerMostrador', 'MostradorController@VerMostrador')->name('VerMostrador');
Route::get('CobranzaPedidos', 'MostradorController@CobranzaPedidos')->name('CobranzaPedidos');

