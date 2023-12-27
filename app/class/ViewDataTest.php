<?php

// Llamar:
// new ViewDataTest( $data );

class ViewDataTest {

    /**
     * Setup exception.
     *
     * @param array  $data Extra error data.
     */
    public function __construct( $data = array() ) 
    {
        // header("Content-Type: text/json; charset=UTF-8");
        echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

}