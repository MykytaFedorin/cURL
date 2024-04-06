<?php
class Thesis{
    public $thesis_type;
    public $topic;
    public $supervisor;
    public $department;
    public $abstractUrl;
    public $programme;

    public function __construct($type, $topic, $supervisor, $department, $programme, $abstractUrl){
        $this->thesis_type = $type; 
        $this->topic = $topic;
        $this->supervisor = $supervisor;
        $this->department = $department;
        $this->programme = $programme;
        $this->abstractUrl = $abstractUrl;
    }
    public function getAssoc(){ 
      $obj_assoc = array("thesis_type"=>$this->thesis_type,
          "topic" => $this->topic,
          "supervisor" => $this->supervisor,
          "department" => $this->department, 
          "abstractUrl" => $this->abstractUrl,
          "programme" => $this->programme
       );
      return $obj_assoc;
    }

}
?>
