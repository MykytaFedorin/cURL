<?php
    require_once("thesises_module.php");
    require_once("exceptions/ThesisRequestException.php");
    header('Content-Type: application/json');

    function getThesisesBy($postData){
        $department = $postData["department"];
        $thesis_type = $postData["thesis_type"];
        if(isset($department) && is_string($department) &&
           isset($thesis_type) && is_string($thesis_type)){     

            $url = getDepartmentUrl($department);
            $thesises = getThesises($url);
            $filteredThesises = filterThesises($thesises, $thesis_type, $department);
            echo json_encode($filteredThesises);
        }
        else{ 
            throw new ThesisRequestException(); 
        }
        # echo json_encode(array("Empty request body error")); 
    }
?>
