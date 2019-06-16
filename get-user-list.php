<?php

// use this format for endpoints. To protect your database---->
$output = [
    'success' => false,
];

// output variable is availabe in the file. variable scope in php
require_once('mysql-connect.php');

// ---->

// if no errors occurred from mysql-connect.php 
if(empty($output['error'])){
    // begin creating query sql
    $query = "SELECT `id`,`name`,`email` FROM `users`";

    // send query to to $conn data
    $result = mysqli_query($conn, $query);
    
    // if there is a result then do the below
    if($result){

        // set output to success true since we got a result from the query
        $output['success'] = true;

        // if there is a pointer to the row
        if(mysqli_num_rows($result)){
            // saving a value into row. can set values inside a while loop. will return associative array or false
            while($row = mysqli_fetch_assoc($result)){
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
        $output['error'] = 'Error getting data';
    };
};

print json_encode($output);


