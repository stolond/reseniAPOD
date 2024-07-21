<?php

require_once("Classes/Form.php");
require_once("Classes/Request.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = new Form($_POST);
    if ($validator->validate_form()) {

        $time_from = $_POST["period_from"];
        $time_to = $_POST["period_to"];

        echo "<p class='valid'>Form is valid.</p><br>";

        $req = new Request();
        $limits = $req->exec_request($time_from, $time_to);

        echo "<h4>Request limit: " . $limits[0] . " per hour</h4>";
        echo "<h4>Remaining requests: " . $limits[1]. "</h4>";

    } else {
        $errors = $validator->get_errors();
        foreach ($errors as $field => $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h2>APOD form</h2>
            <form method="POST">
                <h4>Select a lookup method:</h4>
                <div class="divider">
                    <input type="radio" class="radio" name="radio_choice" value="from_to"><br><br>
                    <label for="radio_choice">Select period between two dates. </label>
                    <label for="period_from">Starting period: </label>
                    <input type="date" id="period_from" name="period_from"><br>

                    <label for="period">End period: </label>
                    <input type="date" id="period_to" name="period_to"><br><br>
                </div>
                <div class="divider">
                <input type="radio" class="radio" name="radio_choice" value="start_date"><br><br>
                    <label for="radio_choice">Select starting date and duration. </label>
                    <label for="start_date">Starting date: </label>
                    <input type="date" id="start_date" name="start_date"><br>

                    <label for="duration">Duration (days): </label>
                    <input type="text" id="duration" name="duration"><br><br>
                </div>
                <input id="submit" type="submit" value="Submit">
            </form>
        </div>
    </body>
</html>