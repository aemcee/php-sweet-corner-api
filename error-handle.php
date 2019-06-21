<?php

class ApiException extends Exception{

    private $output; 

    // 500 is an internal server error
    public function __construct($output = [], $code = 500, $message = 'Internal Server Error', Exception $previous = null){

        // accessing a property of object use 'skinny' arrow
        $this->output = $output;

        // this is how we call the parent constructor
        // :: used to access static method/property
        parent::__construct($message, $code, $previous);
    }

    public function sendError(){
        // print '<h1>Sending Error</h1>';
        // print_r($this->output);

        if(empty($this->output['error']) && empty($this->output['errors'])){
            // set the error message if we didnt already set it elsewhere
            $this->output['error'] = $this->message;
        };

        // message and code are original properties from Exception
        $this->output['error'] = $this->message;
        http_response_code($this->code);

        print json_encode($this->output);

        // like exit for for errors. can pass in a message
        die();
    }

    // static function test(){
    //     // does stuff
    // }

    // public function doStuff(){
    
    // }
}

function defaultExceptionHandler($ex){
    $ex->sendError();
}

set_exception_handler('defaultExceptionHandler');

// accessing static property ApiException::test(); off constructor

// accessing instance of the class
// $ex = new ApiException();
// $ex->doStuff();