<?php 
Class Request
{
    public function exec_request($start_date, $end_date) {
        $url = $this->prep_url($start_date, $end_date);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $this->save_to_csv($body);
        $ratelimits = $this->get_ratelimits($header);
        return $ratelimits;
    }

    private function save_to_csv($data) {
        $body_data = json_decode($data, true);
        $headers = ["date", "title", "media_type", "hdurl", "url"];
        $csv_file = "apod_data.csv";

        $filtered_data = array_intersect_key($body_data, array_flip($headers));

        $file = fopen($csv_file, "a"); 

        if ($file === false) {
            die("Error opening file: " . $csv_file);
        }

        // if file doesnt exist write header row
        if (ftell($file) == 0) {
            fputcsv($file, array_keys($filtered_data));
        }

        if (fputcsv($file, $filtered_data) === false) {
            die('Error writing to the CSV file.');
        }

        fclose($file);
    }

    private function get_ratelimits($data) {
        //display rate limits
        $rate_limit = [];
        $header_array = [];
        $header_lines = explode("\r\n", $data);
        
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
    }

    private function prep_url($start_date, $end_date) {
        $key = "fCjpNqkghLpl6bIkdeTcOvpBHAWTQFv4rOelBvUL";
        $url = "https://api.nasa.gov/planetary/apod?start_date=" . $start_date . "&end_date=" . $end_date . "&api_key=" . $key;
        
        return $url;
    }
}

?>