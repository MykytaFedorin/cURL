<?php
    require_once "../../../.config/zadanie2/config.global.php";
    require_once "getPrace.php";
    try{
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];
    }
    catch(Exception $e){
        echo 'Error: script was executed from terminal' . $e->getMessage();
    }
    $pathSegments = explode('/', $path);
    $resource = end($pathSegments);
    
    switch ($requestMethod) {
        case 'POST':
            if($resource==="prace"){
                $postData = json_decode(file_get_contents("php://input"), true);
                try{
                    $thesises = getThesisesBy($postData);
                    echo $thesises;
                }
                catch(ThesisRequestException $e){
                    echo json_encode(array("Empty request body error")); 
                    http_response_code(400);
                }
                catch(ThesisEmptyBodyException $e){
                  echo json_encode(array("message" => "Thesis object body is empty " .$e->getMessage()));
                }
            }
            else{ 
                echo json_encode(array("message" => "Resource not found."));
                http_response_code(404);
            }
            break;
        default:
                http_response_code(400);
                echo json_encode(array("message" => "No handler for the request"));
            break;
    }
?>

