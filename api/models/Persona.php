<?php 

Class Persona  { 

private $conn;
public $id_persona_pk;
public $nombre;
public $apellido;
public $direccion;
public $correo_electronico;
public $telefono;
public $fecha_afiliacion;
public $DNI;
public $fecha_nacimiento;
public $usuario;
public $contraseña;
public $id_tipo_persona_fk; 

public function __construct($db){
    $this->conn = $db;
}       

//LEER TODAS LAS PERSONAS
public function leer(){    
    $query = "CALL sp_leer_persona()";    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

// OBTENER UNA PERSONA POR ID
public function leer_una(){    
    $query = "CALL sp_obtener_persona()";    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_persona_pk);
    $stmt->execute();
    return $stmt;
}

// CREAR UNA PERSONA
public function crear(){    
    $query = "CALL sp_crear_persona(:p_nombre, :p_apellido, :p_direccion, :p_correo_electronico, :p_telefono, :p_fecha_afiliacion, :p_DNI, :p_fecha_nacimiento, :p_usuario, :p_contraseña, :p_id_tipo_persona_fk)";    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':p_nombre', $this->nombre);
    $stmt->bindParam(':p_apellido',$this->apellido);
    $stmt->bindParam('p_direccion',$this->direccion); 
    $stmt->bindParam('p_correo_electronico',$this->correo_electronico);
    $stmt->bindParam('p_telefono',$this->telefono);
    $stmt->bindParam('p_fecha_afiliacion',$this->fecha_afiliacion);
    $stmt->bindParam('p_DNI',$this->DNI);
    $stmt->bindParam('p_fecha_nacimiento',$this->fecha_nacimiento);
    $stmt->bindParam('p_usuario',$this->usuario);
    $stmt->bindParam('p_contraseña',$this->contraseña);
    $stmt->bindParam('p_id_tipo_persona_fk',$this->id_tipo_persona_fk);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}







   
 // ACTUALIZAR UNA PERSONA
 public function actualizar() {
    $query = "CALL sp_actualizar_persona(:p_id_persona_pk, :p_nombre, :p_apellido, :p_fecha_nacimiento, :p_telefono, :p_direccion";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':p_id_persona_pk', $this->id_persona_pk);
    $stmt->bindParam(':p_nombre', $this->nombre);
    $stmt->bindParam(':p_apellido',$this->apellido);
    $stmt->bindParam('p_direccion',$this->direccion); 
    $stmt->bindParam('p_correo_electronico',$this->correo_electronico);
    $stmt->bindParam('p_telefono',$this->telefono);
    $stmt->bindParam('p_fecha_afiliacion',$this->fecha_afiliacion);
    $stmt->bindParam('p_DNI',$this->DNI);
    $stmt->bindParam('p_fecha_nacimiento',$this->fecha_nacimiento);
    $stmt->bindParam('p_usuario',$this->usuario);
    $stmt->bindParam('p_contraseña',$this->contraseña);
    $stmt->bindParam('p_id_tipo_persona_fk',$this->id_tipo_persona_fk);

    if ($stmt->execute()) {
        return true;
    }
 }

 // ELIMINAR UNA PERSONA
  public function eliminar($id) {
        $query = "CALL sp_eliminar_persona(:p_id_persona_pk)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':p_id_persona_pk', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

  

}
    




