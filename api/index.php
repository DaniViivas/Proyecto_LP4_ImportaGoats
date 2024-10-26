<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once 'controllers/Personacontroller.php';
include_once 'controllers/Productocontroller.php';

// Obtener la entidad desde la URL (por ejemplo: 'personas')
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$resource = isset($uri[3]) ? $uri[3] : null; // Asegúrate de ajustar el índice correctamente

// Obtener el método HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];


if ($resource === 'personas') {
    $controller = new Personacontroller(); // Instanciar el controlador de personas

} elseif ($resource === 'productos') {
    $controller = new Productocontroller(); // Instanciar el controlador de productos

} else {
    // Si no es un recurso válido, devolver un error 404
    http_response_code(404); // Código de respuesta para recurso no encontrado
    echo json_encode(["mensaje" => "Recurso no encontrado"]);
    exit;
}


// Manejar la solicitud según el método HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->obtener($_GET['id']); // Obtener un registro específico
        } else {
            $controller->leer(); // Obtener todos los registros
        }
        break;

        case 'POST':
            $data = (object)$_REQUEST; // Cambiado a $_REQUEST para capturar los datos de form-data
            $file = isset($_FILES['ruta_imagen']) ? $_FILES['ruta_imagen'] : null; // Asegura que se pasa el archivo
        
            // Combinar datos y archivo en un solo objeto
            $combinedData = (object)[
                'data' => $data,
                'file' => $file,
            ];
        
            $controller->crear($combinedData);
            break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $controller->actualizar($data);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $controller->eliminar($_GET['id']); // Eliminar un registro
        }
        break;

    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["mensaje" => "Método no soportado"]);
        break;
}
