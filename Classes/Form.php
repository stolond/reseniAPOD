<?php 
Class Form
{
    public $date_from;
    public $date_to;

    public function validate_form(){
        
    }

    public function calculate_date($start_date, $duration){
        $date = new DateTime($start_date);
        $date->modify("+ " . $duration . " days");
        $date_to = $date->format('Y-m-d');

        if($date_to > date("Y-m-d")){
            return "error";
        } else {
            return $date_to;
        }
    }

    public function get_form_data(){
        if(isset($_POST["period_from"])) {
            $date_from = $_POST["period_from"];
        }
        
        if(isset($_POST["period_to"])) {
            $date_to = $_POST["period_to"];
        }
        

        //return $date_from $date_to;
    }
}
 
?>