<?php
try{
    require_once "../../../.config/zadanie2/config.global.php";

    // Обработка запроса
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $path = $_SERVER["REQUEST_URI"];
    $pathSegments = explode('/', $path);
    $resource = end($pathSegments);

    switch ($requestMethod) {
        case 'POST':
            if($resource==="prace"){
                include 'getPrace.php';
            }
            else{ 
                http_response_code(404);
                echo json_encode(array("message" => "Resource not found.", "path" => $resource));
            }
            break;
    }
}
catch(Exception $e){    
    http_response_code(418);
}
?>

