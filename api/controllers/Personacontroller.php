<?php
include_once './config/Database.php';
include_once './models/Persona.php';

class Personacontroller
{

    private $Persona;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->Persona = new Persona($db);
    }

    public function leer()
    {
        try {
            $stmt = $this->Persona->leer(); // Llama al método leer del modelo Producto
            // Verifica si se obtuvieron resultados
            if ($stmt && $stmt->rowCount() > 0) {
                $Persona = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos los productos
                echo json_encode(["mensaje" => "Personas obtenidas exitosamente.", "datos" => $Persona]); // Mensaje de éxito
            } else {
                // Si no se obtuvieron resultados
                echo json_encode(["mensaje" => "No se encontraron Personas."]); // Mensaje de que no hay productos
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de una excepción
            echo json_encode(["mensaje" => "Error al obtener personas: " . $e->getMessage()]); // Mensaje de error
        }
    }

    // METODO PARA OBTENER UNA PERSONA
    public function obtener($id)
    {
        try {
            $stmt = $this->Persona->obtener($id); // Llama al método leer del modelo Producto
            // Verifica si se obtuvieron resultados
            if ($stmt && $stmt->rowCount() > 0) {
                $Persona = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos los productos
                echo json_encode(["mensaje" => "Personas obtenidas exitosamente.", "datos" => $Persona]); // Mensaje de éxito
            } else {
                // Si no se obtuvieron resultados
                echo json_encode(["mensaje" => "No se encontraron Personas."]); // Mensaje de que no hay productos
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de una excepción
            echo json_encode(["mensaje" => "Error al obtener personas: " . $e->getMessage()]); // Mensaje de error
        }
    }

    // METODO PARA CREAR UNA PERSONA
    public function crear($data)
    {
        $this->Persona->nombre = $data->nombre;
        $this->Persona->apellido = $data->apellido;
        $this->Persona->genero = $data->genero;
        $this->Persona->direccion = $data->direccion;
        $this->Persona->correo_electronico = $data->correo_electronico;
        $this->Persona->telefono = $data->telefono;
        $this->Persona->fecha_afiliacion = $data->fecha_afiliacion;
        $this->Persona->DNI = $data->DNI;
        $this->Persona->fecha_nacimiento = $data->fecha_nacimiento;
        $this->Persona->usuario = $data->usuario;
        $this->Persona->contrasena = $data->contrasena;
        $this->Persona->id_tipo_persona_fk = $data->id_tipo_persona_fk;

        if ($this->Persona->crear()) {
            echo json_encode(["mensaje" => "Persona creada exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al crear la persona."]);
        }
    }

    // METODO PARA ACTUALIZAR UNA PERSONA
    public function actualizar($data)
    {
        $this->Persona->id_persona_pk = $data->id_persona_pk;
        $this->Persona->nombre = $data->nombre;
        $this->Persona->apellido = $data->apellido;
        $this->Persona->genero = $data->genero;
        $this->Persona->direccion = $data->direccion;
        $this->Persona->correo_electronico = $data->correo_electronico;
        $this->Persona->telefono = $data->telefono;
        $this->Persona->fecha_afiliacion = $data->fecha_afiliacion;
        $this->Persona->DNI = $data->DNI;
        $this->Persona->fecha_nacimiento = $data->fecha_nacimiento;
        $this->Persona->usuario = $data->usuario;
        $this->Persona->contrasena = $data->contrasena;
        $this->Persona->id_tipo_persona_fk = $data->id_tipo_persona_fk;

        if ($this->Persona->actualizar()) {
            echo json_encode(["mensaje" => "Persona actualizada exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al actualizar la persona."]);
        }
    }

    // METODO PARA ELMINAR UNA PERSONA
    public function eliminar($id) {
        if ($this->Persona->eliminar($id)) {
            echo json_encode(["mensaje" => "Persona eliminada exitosamente."]);
        } else {
            echo json_encode(["mensaje" => "Error al eliminar la persona."]);
        }
    }
    
    
  
    
    
    
    
}
