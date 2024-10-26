<?php
include_once './config/Database.php'; // Incluye la configuración de la base de datos
include_once './models/Producto.php'; // Incluye el modelo de producto

class Productocontroller
{
    private $Producto; // Nombre del modelo de la clase 

    // Constructor de la clase
    public function __construct()
    {
        $database = new Database(); // Crea una nueva instancia de la clase Database
        $db = $database->getConnection(); // Obtiene la conexión a la base de datos    
        $this->Producto = new Producto($db); // Crea una nueva instancia de Producto con la conexión
    }



    // METODO PARA LEER UNA PERSONA
    public function leer()
    {
        try {
            $stmt = $this->Producto->leer(); // Llama al método leer del modelo Producto
            // Verifica si se obtuvieron resultados
            if ($stmt && $stmt->rowCount() > 0) {
                $Producto = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos los productos
                echo json_encode(["mensaje" => "Productos obtenid@s exitosamente.", "datos" => $Producto]); // Mensaje de éxito
            } else {
                // Si no se obtuvieron resultados
                echo json_encode(["mensaje" => "No se encontraron productos."]); // Mensaje de que no hay productos
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de una excepción
            echo json_encode(["mensaje" => "Error al obtener producto: " . $e->getMessage()]); // Mensaje de error
        }
    }


    // METODO PARA OBTENER UN PRODUCTO
    public function obtener($id)
    {
        try {
            $stmt = $this->Producto->obtener($id); // Llama al método leer del modelo Producto
            // Verifica si se obtuvieron resultados
            if ($stmt && $stmt->rowCount() > 0) {
                $Producto = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos los productos
                echo json_encode(["mensaje" => "Producto obtenido exitosamente.", "datos" => $Producto]); // Mensaje de éxito
            } else {
                // Si no se obtuvieron resultados
                echo json_encode(["mensaje" => "No se encontraron Productos."]); // Mensaje de que no hay productos
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de una excepción
            echo json_encode(["mensaje" => "Error al obtener el Producto: " . $e->getMessage()]); // Mensaje de error
        }


    }

    // METODO PARA CREAR UN PRODUCTO
    public function crear($data)
    {
        $this->Producto->nombre_del_producto = $data->nombre_del_producto;
        $this->Producto->categoria = $data->categoria;
        $this->Producto->marca = $data->marca;
        $this->Producto->pais_de_origen = $data->pais_de_origen;
        $this->Producto->codigo_de_barras = $data->codigo_de_barras;
        $this->Producto->cantidad_en_stock = $data->cantidad_en_stock;
        $this->Producto->precio_de_compra = $data->precio_de_compra;
        $this->Producto->precio_de_venta = $data->precio_de_venta;
        $this->Producto->fecha_ingreso = $data->fecha_ingreso;
        $this->Producto->estado = $data->estado;


        if ($this->Producto->crear()) {
            echo json_encode(["mensaje" => "Producto creado exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al crear el producto."]);
        }
    }
    // METODO PARA ACTUALIZAR UN PRODUCTO
    public function actualizar($data)
    {
        $this->Producto->id_producto_pk = $data->id_producto_pk;
        $this->Producto->nombre_del_producto = $data->nombre_del_producto;
        $this->Producto->categoria = $data->categoria;
        $this->Producto->marca = $data->marca;
        $this->Producto->codigo_de_barras = $data->codigo_de_barras;
        $this->Producto->cantidad_en_stock = $data->cantidad_en_stock;
        $this->Producto->precio_de_compra = $data->precio_de_compra;
        $this->Producto->precio_de_venta = $data->precio_de_venta;
        $this->Producto->fecha_ingreso = $data->fecha_ingreso;
        $this->Producto->estado = $data->estado;

        if ($this->Producto->actualizar()) {
            echo json_encode(["mensaje" => "Producto actualizado exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al actualizar el producto."]);
        }
    }


    // ELIMINAR UN PRODUCTO
    public function eliminar($id)
    {
        if ($this->Producto->eliminar($id)) {
            echo json_encode(["mensaje" => "Producto eliminado exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "El producto no existe"]);
        }
    }


}
