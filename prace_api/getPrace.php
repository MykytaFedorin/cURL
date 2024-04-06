<?php
    header('Content-Type: application/json');
    $postData = json_decode(file_get_contents("php://input"), true);
    if(!$postData){
        echo json_encode(array("Empty request body error")); 
    }
    else{ 
        $department = $postData["department"];
        $thesis_type = $postData["thesis_type"];
        try{ 
            require_once("thesises_module.php");
            $url = "https://is.stuba.sk/auth/pracoviste/prehled_temat.pl?pracoviste=816;";
            $thesises = getThesises($url);
            if($thesises){
                $filteredThesises = filterThesises($thesises, $thesis_type, $department);
                echo json_encode($filteredThesises);
            }
            else{
                #echo "nic";
            }
        }
        catch(Exception $e){
            echo json_encode(array("error"=>$e->getMessage)); 
        }
    }
?>
