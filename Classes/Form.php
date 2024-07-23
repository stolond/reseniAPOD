<?php 
Class Form
{
    private $errors = [];
    private $data;

    public function __construct($post_data) {
        $this->data = $post_data;
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
            $this->errors["radio_choice"] = "Please select a lookup method.";
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
            $from_date = $this->string_to_date("period_from");
            $to_date = $this->string_to_date("period_to");

            if ($from_date && $to_date && $from_date > $to_date) {
                $this->errors["period_to"] = "Starting period must be earlier than end period.";
            }

            if ($this->data["period_to"] > date("Y-m-d")) {
                $this->errors["period_to"] = "Date cannot be set to the future.";
            }
        }
    }

    private function validate_start_date() {
        if (empty($this->data["start_date"])) {
            $this->errors["start_date"] = "Starting date is required.";
        }

        if (empty($this->data["duration"])) {
            $this->errors["duration"] = "Duration is required.";
        } 

        if (!empty($this->data["start_date"]) && !empty($this->data["duration"])) {
            if (!ctype_digit($this->data["duration"]) || (int)$this->data["duration"] <= 0) {
                $this->errors["duration"] = "Duration must be a positive integer.";
            } elseif ($this->calculate_date() > date("Y-m-d")){
                $this->errors["duration"] = "Date cannot be set to the future.";
            }
        }
    }

    public function calculate_date() {
        $date = $this->string_to_date("start_date");
        $duration = $this->data["duration"];

        $date->modify("+ " . $duration . " days");
        $date_to = $date->format("Y-m-d");
        
        return $date_to;
    }

    private function string_to_date($data) {
        $result = DateTime::createFromFormat("Y-m-d", $this->data[$data]);
        return $result;
    }

    public function get_errors() {
        return $this->errors;
    }
}
 
?>