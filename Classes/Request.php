<?php 

class Request
{
    public function remaining_requests() {

        $key = "fCjpNqkghLpl6bIkdeTcOvpBHAWTQFv4rOelBvUL";
        $url = "https://api.nasa.gov/planetary/apod?api_key=" . $key;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        $response = curl_exec($curl);
        echo $response;

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);

        curl_close($curl);

        $header_lines = explode("\r\n", $headers);
        $header_array = [];
        foreach ($header_lines as $line) {
            $parts = explode(": ", $line);
            if (count($parts) == 2) {
                $header_array[$parts[0]] = $parts[1];
            }
        }

        if(isset($header_array["x-ratelimit-remaining"])) {
            $rate_remaining = $header_array["x-ratelimit-remaining"];
            return $rate_remaining;
        } else {
            return "?";
        }

    }

    public function request_from_to($date_from, $date_to){
        $response = file_get_contents("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY");


        return $response;
    }

    public function request_exact($date_from, $date_to){
        $response = file_get_contents("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY");


        return $response;
    }
}

?>