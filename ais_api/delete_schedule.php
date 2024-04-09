<?php    
    try{
        require_once "../config.global.php";
    }
    catch(PDOConnectionFailedException $e){
        echo json_encode(array("message" => $e->getMessage())); 
    }
    $stmt = $pdo->prepare("DELETE FROM subjects");
    try{
        $stmt->execute(); 
        echo "succesfully deleted";
    }
    catch(Except $e){
        echo $e->getMessage();
        echo "error delete";
    }
?>
