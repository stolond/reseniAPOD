<?php 

class Request
{
    public function testing() : void
    {
        $response = file_get_contents("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY");
        echo $response;
    }
}

?>