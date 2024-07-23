<?php 
Class Request
{
    private $start_date;
    private $end_date;

    public function __construct($start_date, $end_date) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function exec_request() {
        $url = $this->prep_url();
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
        try {
            $headers = ["date", "hdurl", "media_type", "title", "url"];
            $csv_file = "apod_data.csv";

            $body_data = json_decode($data, true);

            if ($body_data === null) {
                throw new Exception("JSON Decode Error: " . json_last_error_msg());
            }

            $file = fopen($csv_file, "a");

            if ($file === false) {
                throw new Exception("Error opening file for writing, please ensure it is closed.");
            }

            foreach ($body_data as $record) {
                if (!is_array($record)) {
                    throw new Exception("API returned an error.");
                } else {
                    $filtered_data = array_intersect_key($record, array_flip($headers));

                    // if file doesnt exist, add headers
                    if (ftell($file) == 0) {
                        fputcsv($file, $headers);
                    }

                    if (fputcsv($file, $filtered_data) === false) {
                        throw new Exception("Error writing to file.");
                    }
                }                
            }

            fclose($file);
            echo "<p class='valid'>File saved successfully.</p>";

        } catch (Exception $e) {
            echo "<p class='error'>" . $e->getMessage() . "</p>";
        }
    }

    private function get_ratelimits($data) {
        $rate_limit = [];
        $header_array = [];
        $header_lines = explode("\r\n", $data);
        
        foreach ($header_lines as $line) {
            $parts = explode(": ", $line);
            if (count($parts) == 2) {
                $header_array[$parts[0]] = $parts[1];
            }
        }
        // find the right headers and return them
        if (isset($header_array["x-ratelimit-remaining"]) && isset($header_array["x-ratelimit-limit"])) {
            $rate_limit[0] = $header_array["x-ratelimit-limit"];
            $rate_limit[1] = $header_array["x-ratelimit-remaining"];
            return $rate_limit;
        } else {
            unset($rate_limit);
            return $rate_limit;
        }
    }

    private function prep_url() {
        $key = "fCjpNqkghLpl6bIkdeTcOvpBHAWTQFv4rOelBvUL";
        $url = "https://api.nasa.gov/planetary/apod?start_date=".$this->start_date."&end_date=".$this->end_date."&api_key=".$key;
        
        //echo $url;
        return $url;
    }
}

?>