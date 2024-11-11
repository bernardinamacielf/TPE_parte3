<?php 

    require_once 'libs/router.php';
    require_once 'app/controladores/productos.api.controlador.php';

    $router = new Router();

    #                 endpoint           verbo       controlador                    metodo
    $router->addRoute('productos',       'GET',      'productosApiControlador',     'obtenerProductos');
    $router->addRoute('productos/:id',   'GET',      'productosApiControlador',     'obtenerProducto');
    $router->addRoute('productos/:id',   'DELETE',   'productosApiControlador',     'eliminarProducto');
    $router->addRoute('productos',       'POST',     'productosApiControlador',     'agregarProducto');
    $router->addRoute('productos/:id',   'PUT',      'productosApiControlador',     'editarProducto');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

    //productos?sin_stock=false
    //productos?orderBy=LoQueQuieraOrdenar&sort=asc
