<?php
class Thesis{
    public $thesis_type;
    public $topic;
    public $supervisor;
    public $department;
    public $abstractUrl;
    public $programme;
    public $track;
    public $available;

    public function __construct($type, $topic, $supervisor, $department,
                                $programme, $track, $abstractUrl, $available){

        $this->thesis_type = $type; 
        $this->topic = $topic;
        $this->supervisor = $supervisor;
        $this->department = $department;
        $this->programme = $programme;
        $this->track = $track;
        $this->available = $available;
        $this->abstractUrl = $abstractUrl;
    }
    public function getAssoc(){ 
      $obj_assoc = array("thesis_type"=>$this->thesis_type,
          "topic" => $this->topic,
          "supervisor" => $this->supervisor,
          "department" => $this->department, 
          "abstractUrl" => $this->abstractUrl,
          "programme" => $this->programme,
          "track" => $this->track
       );
      return $obj_assoc;
    }
    public function isFree(){
        $params = explode("/", $this->available);
        $params = array_map('trim', $params);
        $params = array_map('intval', $params);
        $conditions = array();
        if($params[0] == $params[1] || $params[0]>$params[1]){
            return false; 
        } 
        return true;
    }
}
?>
