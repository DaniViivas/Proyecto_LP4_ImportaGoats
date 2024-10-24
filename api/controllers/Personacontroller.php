<?php 

    
    
include_once './config/Database.php';
include_once './models/Persona.php';

class Personacontroller{
private $Persona;
    
public function __construct() {
    $database = new Database();
    $db = $database->conectar();
    $this->Persona = new Persona($db);
}

//obtener todos los registros
public function leer(){
    $stmt = $this->Persona->leer();
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($personas);
    
}

//obtener las personas por ID
public function obtener($id){
    $stmt = $this->Persona->obtener($id);
    $persona = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($persona);
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
   $this->Persona->idtipo_persona_fk= $data->idtipo_persona_fk;

   if($this->Persona->crear()){
    echo json_encode(array('message' => 'Persona Creada'));
   }else{
    echo json_encode(array('message' => 'Persona No Creada'));
   }
}   

//Actualizar persona
public function actualizar($data){
    $this->Persona->idpersona= $data->idpersona;
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
    $this->Persona->idtipo_persona_fk= $data->idtipo_persona_fk;

    if($this->Persona->actualizar()){
        echo json_encode(array('message' => 'Persona Actualizada'));
       }else{
        echo json_encode(array('message' => 'Persona No Actualizada'));
       }
}   

//ELIMINAR PERSONA
public function eliminar($data){
    $this->Persona->idpersona= $data->idpersona;
    if($this->Persona->eliminar()){
        echo json_encode(array('message' => 'Persona Eliminada'));
       }else{
        echo json_encode(array('message' => 'Persona No Eliminada'));
       }
}

}



    
