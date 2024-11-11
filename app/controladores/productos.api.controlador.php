<?php 

require_once 'app/modelos/productos.modelo.php';
require_once 'app/vistas/json.vista.php';

class productosApiControlador {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new productosModelo();
        $this->vista = new JSONVista();
    }

    // api/productos (GET)
    public function obtenerProductos($req, $res) {
        $filtrarSinStock = false;
        if(isset($req->query->sin_stock)) {
            $filtrarSinStock = $req->query->sin_stock;
        }

        $orderBy = false;
        if(isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }

        // Obtener el parámetro orderDirection (ASC o DESC)
        $orderDirection = 'ASC';
        if (isset($req->query->orderDirection)) {
            $orderDirection = $req->query->orderDirection;
        }

        $productos = $this->modelo->obtenerProductos($filtrarSinStock, $orderBy, $orderDirection);

        return $this->vista->response($productos);
    }

    // api/productos/:id (GET)
    public function obtenerProducto($req, $res) {
        $ID_producto = $req->params->id;

        $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);

        if(!$producto) {
            return $this->vista->response("El producto con el id=$ID_producto no existe", 404);
        }

        return $this->vista->response($producto);
    }

    // api/productos/:id (DELETE)
    public function eliminarProducto($req, $res) {
        $ID_producto = $req->params->id;

        $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);

        if(!$producto){
            return $this->vista->response("El producto con el id=$ID_producto no existe", 404);
        }

        $this->modelo->borrarProducto($ID_producto);
        $this->vista->response("El producto con el id=$ID_producto se eliminó con éxito", 200);
    }

    // api/productos (POST)
    public function agregarProducto($req, $res) {
        if(empty($req->body->nombre_producto) || empty($req->body->precio) || empty($req->body->stock) || empty($req->body->ID_categoria) || empty($req->body->foto_url)) {
            return $this->vista->response("Faltan completar datos", 400);
        }

        $nombre_producto = $req->body->nombre_producto;
        $precio = $req->body->precio;
        $stock = $req->body->stock;
        $ID_categoria = $req->body->ID_categoria;
        $foto_url = $req->body->foto_url;

        $ID_producto = $this->modelo->insertarProducto($nombre_producto, $precio, $stock, $ID_categoria, $foto_url);
        if (!$ID_producto) {
            return $this->vista->response("Error al insertar la tarea", 500);
        }

        $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);
        return $this->vista->response($producto, 201);
    }

    // api/productos/:id (PUT)
    public function editarProducto($req, $res) {
        $ID_producto = $req->params->id;

        $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);

        if(!$producto){
            return $this->vista->response("El producto con el id=$ID_producto no existe", 404);
        }

        if(empty($req->body->nombre_producto) || empty($req->body->precio) || empty($req->body->stock) || empty($req->body->ID_categoria) || empty($req->body->foto_url) || empty($req->body->sin_stock)) {
            return $this->vista->response("Faltan completar datos", 400);
        }

        $nombre_producto = $req->body->nombre_producto;
        $precio = $req->body->precio;
        $stock = $req->body->stock;
        $ID_categoria = $req->body->ID_categoria;
        $foto_url = $req->body->foto_url;
        $sin_stock = $req->body->sin_stock;

        $editado = $this->modelo->editarProducto($ID_producto, $nombre_producto, $precio, $stock, $ID_categoria, $foto_url, $sin_stock);

        if ($editado) {
            $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);
            return $this->vista->response($producto, 200);
        } else {
            return $this->vista->response("No se pudo actualizar el producto", 500);
        }
    }

    // ACTUALIZO EL STOCK api/productos/:id/sin_stock
    // public function actualizarProducto($req, $res) {
    //     $ID_producto = $req->params->id;

    //     // verifico que exista
    //     $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);
    //     if (!$producto) {
    //         return $this->vista->response("El producto con el id=$ID_producto no existe", 404);
    //     }

    //     // valido los datos obligatorios
    //     if (!isset($req->body->sin_stock)) {
    //         return $this->vista->response("Faltan completar datos", 400);
    //     }

    //     // valido tipo de datos
    //     if ($req->body->sin_stock !== 1 && $req->body->sin_stock !== 0) {
    //         return $this->vista->response("Tipo de dato incorrecto", 400);
    //     }

    //     // finalizamos
    //     $this->modelo->actualizarProducto($ID_producto, $req->body->sin_stock);

    //      // obtengo la tarea modificada y la devuelvo en la respuesta
    //      $producto = $this->modelo->obtenerDetallesDelProducto($ID_producto);
    //      $this->vista->response($producto, 200);
    // }

}