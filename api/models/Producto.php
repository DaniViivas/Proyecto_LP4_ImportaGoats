<?php

class Producto
{

    private $conn;
    public $id_producto_pk;
    public $nombre_del_producto;
    public $categoria;
    public $marca;
    public $pais_de_origen;
    public $codigo_de_barras;
    public $cantidad_en_stock;
    public $precio_de_compra;
    public $precio_de_venta;
    public $fecha_ingreso;
    public $estado;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    // LEER TODOS LOS PRODUCTOS
    public function leer()
    {
        $query = "Call sp_leer_producto()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // OBTENER UN PRODUCTO POR ID
    public function obtener($id)
    {
        $query = "Call sp_obtener_producto(:p_id_producto_pk)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_id_producto_pk', $id);
        $stmt->execute();
        return $stmt;
    }

    // CREAR UN PRODUCTO
    public function crear()
    {
        $query = "CALL sp_crear_producto(:p_nombre_del_producto, :p_categoria, :p_marca, :p_pais_de_origen, :p_codigo_de_barras, :p_cantidad_en_stock, :p_precio_de_compra, :p_precio_de_venta, :p_fecha_ingreso, :p_estado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_nombre_del_producto', $this->nombre_del_producto);
        $stmt->bindParam(':p_categoria', $this->categoria);
        $stmt->bindParam(':p_marca', $this->marca);
        $stmt->bindParam(':p_pais_de_origen', $this->marca);
        $stmt->bindParam(':p_codigo_de_barras', $this->codigo_de_barras);
        $stmt->bindParam(':p_cantidad_en_stock', $this->cantidad_en_stock);
        $stmt->bindParam(':p_precio_de_compra', $this->precio_de_compra);
        $stmt->bindParam(':p_precio_de_venta', $this->precio_de_venta);
        $stmt->bindParam(':p_fecha_ingreso', $this->fecha_ingreso);
        $stmt->bindParam(':p_estado', $this->estado);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Manejo del error, puedes usar $e->getMessage() para obtener detalles del error
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }

    // ACTUALIZAR UN PRODUCTO
    public function actualizar()
    {
        $query = "CALL sp_actualizar_producto(:p_id_producto_pk,:p_nombre_del_producto, :p_categoria, :p_marca, :p_pais_de_origen, :p_codigo_de_barras, :p_cantidad_en_stock, :p_precio_de_compra, :p_precio_de_venta, :p_fecha_ingreso, :p_estado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_id_producto_pk', $this->id_producto_pk);
        $stmt->bindParam(':p_nombre_del_producto', $this->nombre_del_producto);
        $stmt->bindParam(':p_categoria', $this->categoria);
        $stmt->bindParam(':p_marca', $this->marca);
        $stmt->bindParam(':p_pais_de_origen', $this->pais_de_origen);
        $stmt->bindParam(':p_codigo_de_barras', $this->codigo_de_barras);
        $stmt->bindParam(':p_cantidad_en_stock', $this->cantidad_en_stock);
        $stmt->bindParam(':p_precio_de_compra', $this->precio_de_compra);
        $stmt->bindParam(':p_precio_de_venta', $this->precio_de_venta);
        $stmt->bindParam(':p_fecha_ingreso', $this->fecha_ingreso);
        $stmt->bindParam(':p_estado', $this->estado);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Manejo del error, puedes usar $e->getMessage() para obtener detalles del error
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar un producto
    public function eliminar($id)
    {
        $query = "CALL sp_eliminar_producto(:p_id_producto_pk)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_id_producto_pk', $id);
        try {
            $stmt->execute();

            // Obtener el número de filas afectadas
            $row_count = $stmt->fetchColumn();
            $stmt->closeCursor(); // Cerrar el cursor

            if ($row_count > 0) {
                return true; // Se eliminó al menos un producto
            } else {
                return false; // No se eliminó ningún producto
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
}
