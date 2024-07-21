<?php 

class Request
{
    public function get_ratelimit_info($start_date, $end_date) {

        $rate_limit = [];
        $url = $this->prep_url($start_date, $end_date);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $header_lines = explode("\r\n", $headers);
        $header_array = [];

        foreach ($header_lines as $line) {
            $parts = explode(": ", $line);
            if (count($parts) == 2) {
                $header_array[$parts[0]] = $parts[1];
            }
        }

        if (isset($header_array["x-ratelimit-remaining"]) && isset($header_array["x-ratelimit-limit"])) {
            $rate_limit[0] = $header_array["x-ratelimit-limit"];
            $rate_limit[1] = $header_array["x-ratelimit-remaining"];
            return $rate_limit;
        } else {
            
            $rate_limit[0] = "?";
            $rate_limit[1] = "?";
            return $rate_limit;
        }
        
        /*
        $body_data = json_decode($body, true);

        if ($body_data === NULL) {
            die("decoding error");
        }

        $csv_file = "apod_data.csv";

        $file = fopen($csv_file, "a"); 

        if ($file === FALSE) {
            die("Error occurred while opening the CSV file for writing.");
        }

        if (is_array($body_data)) {
            foreach ($body_data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $value = json_encode($value);
                }
                fputcsv($file, [$key, $value]);
                if (fputcsv($file, [$key, $value]) === false) {
                    die('Error writing to the CSV file.');
                }
            }
        }

        fclose($file);
        */
    }

    private function prep_url($start_date, $end_date) {
        $key = "fCjpNqkghLpl6bIkdeTcOvpBHAWTQFv4rOelBvUL";
        $url = "https://api.nasa.gov/planetary/apod?start_date=" . $start_date . "&end_date=" . $end_date . "&api_key=" . $key;
        
        return $url;
    }
}

?>