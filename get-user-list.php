<?php

require_once('setup.php');

// use this format for endpoints. To protect your database---->
$output = [
    'success' => false,
];


// if no errors occurred from mysql-connect.php 
// begin creating query sql
$query = "SELECT `id`,`name`,`email` FROM `users`";

// send query to to $conn data
$result = $conn->query($query);

// if there is a result then do the below
if($result){

    // set output to success true since we got a result from the query
    $output['success'] = true;

    // if there is a pointer to the row
    if($result->num_rows){
        // saving a value into row. can set values inside a while loop. will return associative array or false
        while($row = $result->fetch_assoc()){
            // using print_r because variable is an associative array
            //print_r($row);
            // push onto array new value (associative array) of row
            $output['users'][] = $row;
            echo '<pre>';
            print_r($output['users']);
            echo '</pre>';
        };
    }else{
        // empty array if no users in database
        $output['users'] = [];
    };
}else{
    // server was unable to return data
    throw new ApiException($output, 500, 'Database Error');
};


print json_encode($output);


