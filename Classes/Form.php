<?php 
Class Form
{
    private $errors = [];
    private $data;

    public function __construct($postData) {
        $this->data = $postData;
    }

    public function validate_form(){
        $this->validate_radio();

        if (isset($this->data["radio_choice"])) {
            if ($this->data["radio_choice"] === "from_to") {
                $this->validate_from_to();
            } elseif ($this->data["radio_choice"] === "start_date") {
                $this->validate_start_date();
            }
        }
        return empty($this->errors);
    }

    private function validate_radio() 
    {
        if (empty($this->data["radio_choice"])) 
        {
            $this->errors["radio_choice"] = "Please select a lookup option.";
        }
    }

    private function validate_from_to() {
        if (empty($this->data["period_from"])) {
            $this->errors["period_from"] = "Starting period is required.";
        }

        if (empty($this->data["period_to"])) {
            $this->errors["period_to"] = "End period is required.";
        }

        if (!empty($this->data["period_from"]) && !empty($this->data["period_to"])) {
            $fromDate = DateTime::createFromFormat("Y-m-d", $this->data["period_from"]);
            $toDate = DateTime::createFromFormat("Y-m-d", $this->data["period_to"]);

            if ($fromDate && $toDate && $fromDate > $toDate) {
                $this->errors["period_to"] = "Period to must be after period from.";
            }
        }
    }

    private function validate_start_date() {
        if (empty($this->data["start_date"])) {
            $this->errors["start_date"] = "Starting date is required.";
        }

        if (empty($this->data["duration"])) {
            $this->errors["duration"] = "Duration is required.";
        } elseif (!ctype_digit($this->data["duration"]) || (int)$this->data["duration"] <= 0) {
            $this->errors["duration"] = "Duration must be a positive integer.";
        }
    }

    public function get_errors() {
        return $this->errors;
    }

    public function calculate_date($start_date, $duration){
        $date = new DateTime($start_date);
        $date->modify("+ " . $duration . " days");
        $date_to = $date->format("Y-m-d");

        echo $date_to;

        if($date_to > date("Y-m-d")){
            $this->errors["period_to"] = "Date cannot be set to the future.";
        } else {
            return $date_to;
        }
    }
}
 
?>