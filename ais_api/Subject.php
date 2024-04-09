<?php
class Subject {
    public $day;
    public $subject_type;
    public $subject_name;
    public $room;
    
    public function __construct($day, $subject_type, $subject_name, $room) {
        $this->day = $day;
        $this->subject_type = $subject_type;
        $this->subject_name = $subject_name;
        $this->room = $room;
    }

    public function commit(){
        global $pdo;

        $stmt = $pdo->prepare("SELECT type_id FROM subject_type WHERE type_name=:type_name");
        $stmt->bindParam(":type_name", $this->subject_type, PDO::PARAM_STR);
        try{
            $stmt->execute();
            $type_id = $stmt->fetch(PDO::FETCH_ASSOC)["type_id"];
        }
        catch(Exception $e){
            echo $e->getMessage(); 
        }

        $stmt = $pdo->prepare("INSERT INTO subjects (name, day, room, subject_type)
                                            VALUES  (:name, :day, :room, :subject_type)"); 
        $stmt->bindParam(":name", $this->subject_name, PDO::PARAM_STR);
        $stmt->bindParam(":day", $this->day, PDO::PARAM_STR);
        $stmt->bindParam(":room", $this->room, PDO::PARAM_STR);
        $stmt->bindParam(":subject_type", $type_id, PDO::PARAM_INT);

        try{
            $stmt->execute();
        }catch(Exception $e){
            echo $e->getMessage(); 
        }


    }
}
?>
