<?php
require_once("Classes/Form.php");
require_once("Classes/Request.php");

$radio_choice;
$date_from;
$date_to;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $radio_choice = $_POST["radio_choice"];
}

if (!isset($radio_choice)) {
    echo "radio not selected";
}

if ($radio_choice == "from_to") {
    $date_from = $_POST["period_from"];
    $date_to = $_POST["period_to"];

    echo $radio_choice;
    echo $date_from;
    echo $date_to;
}

if ($radio_choice == "start_date") {
    $date_from = $_POST["start_date"];
    $duration = $_POST["duration"];

    $form = new Form();
    $date_to = $form->calculate_date($date_from, $duration);

    echo $radio_choice;
    echo $date_from;
    echo $date_to;
}

$req = new Request();
$remaining_requests = $req->remaining_requests();
echo $remaining_requests;










?>