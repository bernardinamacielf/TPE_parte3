<?php 

require_once 'app/modelos/config.php';

class productosModelo {
    private $db;

    public function __construct() {
        $this->db = new PDO(
        "mysql:host=".MYSQL_HOST .
        ";dbname=".MYSQL_DB.";charset=utf8", 
        MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    private function deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql =<<<END

		END;
        $this->db->query($sql);
        }
    }

    public function obtenerProductos($filtrarSinStock = null, $orderBy = false, $orderDirection = 'ASC') {
        $sql = 'SELECT * FROM productos';

        if($filtrarSinStock != null) {
            if($filtrarSinStock == 'true')
                $sql .= ' WHERE sin_stock = 1';
            else
                $sql .= ' WHERE sin_stock = 0';
        }

        if (strtoupper($orderDirection) === 'DESC') {
            $orderDirection = 'DESC';
        } else {
            $orderDirection = 'ASC'; // por defecto
        }        

        if($orderBy){
            switch($orderBy) {
                case 'nombre_producto':
                    $sql .= ' ORDER BY nombre_producto ' . $orderDirection;
                    break;
                case 'precio':
                    $sql .= ' ORDER BY precio ' . $orderDirection;
                    break;
                case 'stock':
                    $sql .= ' ORDER BY stock ' . $orderDirection;
                    break;
                case 'ID_categoria':
                    $sql .= ' ORDER BY ID_categoria ' . $orderDirection;
                    break;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    public function obtenerDetallesDelProducto($ID_producto) {
        $query = $this->db->prepare(
           'SELECT productos.*, categorias.nombre_categoria
            FROM productos 
            JOIN categorias ON productos.ID_categoria = categorias.ID_categoria
            WHERE productos.ID_producto = ?'
        );
        $query->execute([$ID_producto]);

        $producto = $query->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    public function insertarProducto($nombre_producto, $precio, $stock, $ID_categoria, $foto_url, $sin_stock = false) {
        $query = $this->db->prepare('INSERT INTO productos(nombre_producto, precio, stock, ID_categoria, foto_url, sin_stock) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$nombre_producto, $precio, $stock, $ID_categoria, $foto_url, $sin_stock]);

        $ID_producto = $this->db->lastInsertId();
        return $ID_producto;
    }

    public function borrarProducto($ID_producto) {
        $query = $this->db->prepare('DELETE FROM productos WHERE ID_producto = ?');
        $query->execute([$ID_producto]);
    }

    public function editarProducto($ID_producto, $nombre_producto, $precio, $stock, $ID_categoria, $foto_url, $sin_stock) {
        $query = $this->db->prepare('UPDATE productos SET nombre_producto = ?, precio = ?, stock = ?, ID_categoria = ?, foto_url = ?, sin_stock = ? WHERE ID_producto = ?');
        $query->execute([$ID_producto, $nombre_producto, $precio, $stock, $ID_categoria, $foto_url, $sin_stock]);
    }

    // public function actualizarProducto($ID_producto, $sin_stock) {
    //     $query = $this->db->prepare('UPDATE productos SET sin_stock = ? WHERE ID_producto = ?');
    //     $query->execute([$sin_stock, $ID_producto]);
    // }
}