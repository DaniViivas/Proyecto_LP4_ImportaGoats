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
            $stmt = $this->Producto->obtener($id); // Llama al método obtener del modelo Producto
            
            // Verifica si se obtuvieron resultados
            if ($stmt && !empty($stmt)) {
                $Producto = $stmt; // Se asume que el método obtener retorna el producto
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
    











    
    public function crear($combinedData)
    {
        // Extrae los datos y el archivo del objeto combinado
        $data = $combinedData->data;
        $file = $combinedData->file;

        // Verifica que los datos y el archivo estén presentes
        if (!$data || !$file) {
            echo json_encode(["mensaje" => "Datos incompletos."]);
            return;
        }

        // Asigna los datos de $data a las propiedades del modelo Producto
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

        // Manejo de la imagen
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $target_dir = "./imagenes_productos/"; // Directorio de destino para las imagenes
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $unique_name = uniqid() . '_' . time() . '.' . $extension;
            $target_file = $target_dir . $unique_name;

            // Mueve el archivo al directorio de destino
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $this->Producto->ruta_imagen = $unique_name; // Guarda el nombre de la imagen en la BD
            } else {
                echo json_encode(["mensaje" => "Error al subir la imagen."]);
                return;
            }
        } else {
            echo json_encode(["mensaje" => "No se recibió ninguna imagen válida."]);
            return;
        }

        // Llama al método de creación en el modelo y devuelve el resultado
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
        $this->Producto->pais_de_origen = $data->pais_de_origen;
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
    // METODO PARA ACTUALIZAR LA FOTO DE UN PRODUCTO
    public function actualizarFile($id, $file)
    {
        // Verificar si el archivo fue proporcionado
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(["mensaje" => "No se recibió una imagen válida."]);
            return;
        }

        // Buscar el registro para obtener la foto anterior
        $producto = $this->Producto->obtener($id);
        if (!$producto) {
            echo json_encode(["mensaje" => "Producto no encontrado."]);
            return;
        }

        // Eliminar la imagen anterior si existe
        $oldImagePath = "../imagenes_productos/" . $producto->ruta_imagen;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        // Subir la nueva imagen
        $target_dir = "../imagenes_productos/";
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $unique_name = uniqid() . '_' . time() . '.' . $extension;
        $target_file = $target_dir . $unique_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Actualizar la ruta de la nueva imagen en la BD
            $this->Producto->ruta_imagen = $unique_name;
            $this->Producto->id_producto_pk = $id;
            if ($this->Producto->actualizarFile()) {
                echo json_encode(["mensaje" => "Foto actualizada exitosamente."]);
            } else {
                echo json_encode(["mensaje" => "Error al actualizar la foto en la BD."]);
            }
        } else {
            echo json_encode(["mensaje" => "Error al subir la nueva imagen."]);
        }
    }


    // ELIMINAR UN PRODUCTO
    public function eliminar($id)
    {
        // Buscar el registro para obtener la foto
        $producto = $this->Producto->obtener($id);
        if (!$producto) {
            echo json_encode(["mensaje" => "Producto no encontrado."]);
            return;
        }
    
        // Eliminar la imagen si existe
        $imagePath = "./imagenes_productos/" . ($producto->ruta_imagen ?? '');
    
        if (!empty($producto->ruta_imagen) && is_file($imagePath)) {
            unlink($imagePath);
        }
        
        if ($this->Producto->eliminar($id)) {
            echo json_encode(["mensaje" => "Producto eliminado exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al eliminar el producto."]);
        }
    }
    
}
