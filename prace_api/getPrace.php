<?php
    require_once("thesises_module.php");
    require_once("exceptions/ThesisRequestException.php");
    header('Content-Type: application/json');

    function getThesisesBy($postData){
        $department = $postData["department"];
        $thesis_type = $postData["thesis_type"];
        try{
            $url = getDepartmentUrl($department);
        }
        catch(ThesisRequestException $e){
            throw $e; 
        }
        $thesises = getThesises($url);
        $filteredThesises = filterThesises($thesises, $thesis_type, $department);
        return json_encode($filteredThesises);
        # echo json_encode(array("Empty request body error")); 
    }
?>
