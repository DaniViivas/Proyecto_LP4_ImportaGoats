<?php 
include_once './config/Database.php';
include_once './models/Persona.php';


class Personacontroller{
private $Persona;
    
public function __construct() {
    $database = new Database();
    $db = $database->getConnection();
    $this->Persona = new Persona($db);
}

//obtener todos los registros
public function leer(){
    $stmt = $this->Persona->leer();
    $Persona = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($Persona);
    
}

//obtener las personas por ID
public function obtener($id) {
    $stmt = $this->Persona->obtener($id);
    $Persona = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($Persona);
}

//crear una persona 
public function crear($data){
   $this->Persona->nombre= $data->nombre;
   $this->Persona->apellido= $data->apellido;
   $this->Persona->direccion= $data->direccion;
   $this->Persona->correo_electronico= $data->correo_electronico;
   $this->Persona->telefono= $data->telefono;
   $this->Persona->fecha_afiliacion= $data->fecha_afiliacion;
   $this->Persona->DNI= $data->DNI;
   $this->Persona->fecha_nacimiento= $data->fecha_nacimiento;
   $this->Persona->usuario= $data->usuario;
   $this->Persona->contraseña= $data->contraseña;
   $this->Persona->id_tipo_persona_fk= $data->id_tipo_persona_fk;

   if($this->Persona->crear()){
    echo json_encode(array('message' => 'Persona Creada'));
   }else{
    echo json_encode(array('message' => 'Persona No Creada'));
   }
}   

//Actualizar persona
public function actualizar($data){
    $this->Persona->id_persona_pk= $data->id_persona_pk;
    $this->Persona->nombre= $data->nombre;
    $this->Persona->apellido= $data->apellido;
    $this->Persona->direccion= $data->direccion;
    $this->Persona->correo_electronico= $data->correo_electronico;
    $this->Persona->telefono= $data->telefono;
    $this->Persona->fecha_afiliacion= $data->fecha_afiliacion;
    $this->Persona->DNI= $data->DNI;
    $this->Persona->fecha_nacimiento= $data->fecha_nacimiento;  
    $this->Persona->usuario= $data->usuario;
    $this->Persona->contraseña= $data->contraseña;
    $this->Persona->id_tipo_persona_fk= $data->id_tipo_persona_fk;

    if($this->Persona->actualizar()){
        echo json_encode(array('message' => 'Persona Actualizada'));
       }else{
        echo json_encode(array('message' => 'Persona No Actualizada'));
       }
}   

//ELIMINAR PERSONA

public function eliminar($id) {
    if ($this->Persona->eliminar($id)) {
        echo json_encode(["mensaje" => "Persona eliminada exitosamente."]);
    } else {
        echo json_encode(["mensaje" => "Error al eliminar la persona."]);
    }
}

}



    
