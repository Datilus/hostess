<?php

// Llamar el error:
// throw new DataError( 123, 'mensaje', 400 );

class DataStatusResponse extends Exception {

    private $error_data = [];

    /**
     * Setup exception.
     *
     * @param int    $code_error        Error code, e.g '101'.
     * @param string $message           User-friendly translated error message, e.g. 'Publicador ID is invalid'.
     * @param int    $http_status_code  Proper HTTP status code to respond with, e.g. 400.
     * @param array  $meta_data         Extra error data.
     */
    public function __construct($is_error = true, $code_error, $meta_data = array(),  $http_status_code = 400, $message, $response = array())
    {
        $this->error_data = array_merge( array( 'code_error' => $code_error ) );
        
        http_response_code($http_status_code);
        header("Content-Type: text/json; charset=UTF-8");
        die( json_encode(["error" => $is_error, "code_error" => $code_error, "meta_data" => $meta_data, "message" => $message, "response" => $response ], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) );
    }

}