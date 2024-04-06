<?php
class Thesis{
    public $thesis_type;
    public $topic;
    public $supervisor;
    public $department;
    public $abstract_;
    public $programme;

    public function __construct($type, $topic, $supervisor, $department, $programme, $abstract_){
        $this->thesis_type = $type; 
        $this->topic = $topic;
        $this->supervisor = $supervisor;
        $this->department = $department;
        $this->programme = $programme;
        $this->abstract_ = $abstract_;
    }
}
?>
