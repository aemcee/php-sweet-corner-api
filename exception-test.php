<?php

require_once('error-handle.php');

$value = $_GET['v'];

try{
    if($value > 1){
        throw new Exception('The value was greater than 1');
    }else {
        // print "<h1>The value is $value</h1>";
        throw new ApiException([], 404, 'The value was too small');
    }    
}

catch(ApiException $ex){
    $ex->sendError();
}

// what type of class are we expecting
catch(Exception $ex){
    // 'skinny' arrow is like a . (dot) in javascript
    print 'The Error was '.$ex->getMessage();
}



