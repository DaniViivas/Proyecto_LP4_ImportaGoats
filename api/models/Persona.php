<?php 

Class Persona  { 

private $conn;
public $id_persona_pk;
public $nombre;
public $apellido;
public $genero;
public $direccion;
public $correo_electronico;
public $telefono;
public $fecha_afiliacion;
public $DNI;
public $fecha_nacimiento;
public $usuario;
public $contrasena;
public $id_tipo_persona_fk; 

public function __construct($db){
    $this->conn = $db;
}       

//LEER TODAS LAS PERSONAS
public function leer(){    
    $query = "CALL sp_leer_personas()";    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

// OBTENER UNA PERSONA POR ID
public function obtener($id) {
    $query = "CALL sp_obtener_personas(:p_id_persona_pk)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':p_id_persona_pk', $id);
    $stmt->execute();
    return $stmt;
}

// CREAR UNA PERSONA// CREAR UNA PERSONA
// Método crear de la clase Persona
public function crear(){    
    $query = "CALL sp_crear_persona(:p_nombre, :p_apellido, :p_genero, :p_direccion, :p_correo_electronico, :p_telefono, :p_fecha_afiliacion, :p_DNI, :p_fecha_nacimiento, :p_usuario, :p_contrasena, :p_id_tipo_persona_fk)";    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':p_nombre', $this->nombre);
    $stmt->bindParam(':p_apellido', $this->apellido);
    $stmt->bindParam(':p_genero', $this->genero);
    $stmt->bindParam(':p_direccion', $this->direccion); 
    $stmt->bindParam(':p_correo_electronico', $this->correo_electronico);
    $stmt->bindParam(':p_telefono', $this->telefono);
    $stmt->bindParam(':p_fecha_afiliacion', $this->fecha_afiliacion);
    $stmt->bindParam(':p_DNI', $this->DNI);
    $stmt->bindParam(':p_fecha_nacimiento', $this->fecha_nacimiento);
    $stmt->bindParam(':p_usuario', $this->usuario);
    $stmt->bindParam(':p_contrasena', $this->contrasena);
    $stmt->bindParam(':p_id_tipo_persona_fk', $this->id_tipo_persona_fk);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Manejo del error, puedes usar $e->getMessage() para obtener detalles del error
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        return false;
    }
}

   
 // ACTUALIZAR UNA PERSONA
 public function actualizar() {
    $query = "CALL sp_actualizar_personas(:p_id_persona_pk, :p_nombre, :p_apellido, :p_genero, :p_direccion, :p_correo_electronico, :p_telefono, :p_fecha_afiliacion, :p_DNI, :p_fecha_nacimiento, :p_usuario, :p_contrasena, :p_id_tipo_persona_fk)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':p_id_persona_pk', $this->id_persona_pk);
    $stmt->bindParam(':p_nombre', $this->nombre);
    $stmt->bindParam(':p_apellido', $this->apellido);
    $stmt->bindParam(':p_genero', $this->genero);
    $stmt->bindParam(':p_direccion', $this->direccion);
    $stmt->bindParam(':p_correo_electronico', $this->correo_electronico);
    $stmt->bindParam(':p_telefono', $this->telefono);
    $stmt->bindParam(':p_fecha_afiliacion', $this->fecha_afiliacion);
    $stmt->bindParam(':p_DNI', $this->DNI);
    $stmt->bindParam(':p_fecha_nacimiento', $this->fecha_nacimiento);
    $stmt->bindParam(':p_usuario', $this->usuario);
    $stmt->bindParam(':p_contrasena', $this->contrasena);
    $stmt->bindParam(':p_id_tipo_persona_fk', $this->id_tipo_persona_fk);

   
    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Manejo del error, puedes usar $e->getMessage() para obtener detalles del error
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        return false;
    }
}




 // ELIMINAR UNA PERSONA
  public function eliminar($id) {
        $query = "CALL sp_eliminar_personas(:p_id_persona_pk)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_id_persona_pk', $id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Manejo del error, puedes usar $e->getMessage() para obtener detalles del error
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }

  

}
    




