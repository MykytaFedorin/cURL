<?php
try{
    require_once "../config.global.php";
}
catch(PDOConnectionFailedException $e){
    echo json_encode(array("message" => $e->getMessage())); 
}
// Обработка запр
$requestMethod = $_SERVER["REQUEST_METHOD"];

$path = $_SERVER["REQUEST_URI"];
$pathSegments = explode('/', $path);
$resource = end($pathSegments);

switch ($requestMethod) {
    case 'GET':
        if($resource==="subjects"){
            include 'getSubjects.php';
        }
        else{ 
            http_response_code(404);
            echo json_encode(array("message" => "Resource not found.", "path" => $resource));
        }
        break;
    case 'POST':
        if($resource==="subjects"){
            include 'createSubject.php';
        }
        else{ 
            http_response_code(404);
            echo json_encode(array("message" => "Resource not found.", "path" => $resource));
        }
        break;
    case 'PUT':
        if($resource==="subjects"){
            include 'updateSubject.php';
        }
        else{ 
            http_response_code(404);
            echo json_encode(array("message" => "Resource not found.", "path" => $resource));
        }
        break;
    case 'DELETE':
        if($resource==="subjects"){
            include 'deleteSubject.php';
        }
        else{ 
            http_response_code(404);
            echo json_encode(array("message" => "Resource not found.", "path" => $resource));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
}
?>

