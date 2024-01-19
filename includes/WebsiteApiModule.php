<?php

class WebsiteApiModule
{
    var $faqs;
    var $pricing;

    function __construct()
    {

    }

    function fetch_data($end_point, $apiSource = 'admin')
    {
        if ($apiSource === 'admin') {
            $base_url = $_ENV['ADMIN_API_BASE_URL'];
        } else {
            $base_url = $_ENV['API_BASE_URL'];
        }
        // Initialize a cURL session
        $ch = curl_init();

        // Set cURL options
        $url = $base_url . "/api/marketing-website/" . $end_point;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the result as a string
        curl_setopt($ch, CURLOPT_HEADER, 0); // To exclude header from output
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects, if any
        curl_setopt($ch, CURLOPT_HTTPGET, true); // Set request type to GET

        // Execute the cURL session and store the result in $output
        $output = curl_exec($ch);

        // Check if any error occurred
        if (curl_errno($ch)) {
//            echo 'Curl error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        $json = json_decode($output, true);
        return $json;
    }

}

?>
