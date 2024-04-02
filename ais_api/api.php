<?php
require_once "../../../.config/zadanie2/config.global.php";

// Обработка запроса
$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        // Получение данных
        $path = $_SERVER["REQUEST_URI"];
        $pathSegments = explode('/', $path);
        $resource = end($pathSegments);
        switch ($resource) {
            case 'subjects':
                // Получить все предметы
                include 'getSubjects.php';
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Resource not found.", "path" => $resource));
        }
        break;
    case 'POST':
        // Создание новой записи
        $postData = json_decode(file_get_contents("php://input"), true);
        $path = $_SERVER["PATH_INFO"];
        $pathSegments = explode('/', $path);
        $resource = $pathSegments[1];
        
        switch ($resource) {
            case 'subjects':
                // Создать новый предмет
                include 'createSubject.php';
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Resource not found."));
        }
        break;
    case 'PUT':
        // Обновление существующей записи
        // Ваш код для обновления записи
        break;
    case 'DELETE':
        // Удаление записи
        // Ваш код для удаления записи
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
}
?>

