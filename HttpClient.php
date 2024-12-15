<?php

public static function get(string $url): array {
    $response = file_get_contents($url);
    if ($http_response_header[0] === 'HTTP/1.1 200 OK') {
        return json_decode($response, true);
    } else if ($http_response_header[0] === 'HTTP/1.1 204 No Content') {
        return true;     
    } else {
        throw new Exception('Error: ' . $http_response_header[0]);
    }
}



public static function post(array $data) {
    $response = file_get_contents($url);
    if ($http_response_header[0] === 'HTTP/1.1 200 OK') {
        return json_decode($response, true);
    } else if ($http_response_header[0] === 'HTTP/1.1 204 No Content') {
        return true;     
    } else {
        throw new Exception('Error: ' . $http_response_header[0]);
    }
}


public function test() {
        try {
        return HttpClient::get($this->base . '/test.json');
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }
    ?>