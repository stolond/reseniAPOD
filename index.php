<?php

require_once("Classes/Form.php");
require_once("Classes/Request.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = new Form($_POST);
    if ($validator->validate_form()) {

        $time_from = $_POST["period_from"];
        $time_to = $_POST["period_to"];

        echo "Form is valid!<br>";

        $req = new Request();
        //$data = $req->get_data($time_from, $time_to);
        $limit = $req->get_ratelimit_info($time_from, $time_to);

        echo "<h3>Request limit: " . $limit[0] . " per hour</h3>";
        echo "<h3>Remaining requests: " . $limit[1]. "</h3>";

    } else {
        $errors = $validator->get_errors();
        foreach ($errors as $field => $error) {
            echo "<p class='error'>Error in $field: $error</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Form</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <h2>APOD form</h2>
        <form method="POST">
            <p>Select a lookup method:</p>

            <input type="radio" id="radio_from_to" name="radio_choice" value="from_to">Select period between two dates.<br>
            <input type="radio" id="radio_start_date" name="radio_choice" value="start_date">Select starting date and duration.<br><br>

            <div>
                <label for="period_from">Starting period:</label>
                <input type="date" id="period_from" name="period_from"><br>

                <label for="period">End period:</label>
                <input type="date" id="period_to" name="period_to"><br><br>
            </div>       
            
            <div>
                <label for="start_date">Starting date:</label>
                <input type="date" id="start_date" name="start_date"><br>

                <label for="duration">Duration (days):</label>
                <input type="text" id="duration" name="duration"><br><br>
            </div>

            <input type="submit" value="Submit">
        </form>
    </body>
</html>