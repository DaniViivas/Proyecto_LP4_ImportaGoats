<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once 'controllers/Personacontroller.php';

// Obtener la entidad desde la URL (por ejemplo: 'personas' o 'productos')
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$resource = isset($uri[3]) ? $uri[3] : null; // Asume que tienes algo como /api/index.php/{entidad}

// Obtener el método HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Inicializar el controlador si el recurso es 'personas'
$controller = null;
if ($resource === 'personas') {
    $controller = new Personacontroller();
}

// Manejar la solicitud según el método HTTP
if ($controller) {
    switch ($method) {
        case 'GET': 
            if (isset($_GET['id'])) {
                $controller->obtener($_GET['id']);
            } else {
                $controller->leer();
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $controller->crear($data);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $controller->actualizar($data);
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            $controller->eliminar($data);
            break;

        default:
            http_response_code(405); // Método no permitido
            echo json_encode(["message" => "Método no soportado"]);
            break;
    }
} else {
    http_response_code(404); // Recurso no encontrado
    echo json_encode(["message" => "Recurso no encontrado"]);
}
