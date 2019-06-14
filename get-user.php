<?php

$output = [
    'success' => false
];

$id = null;

if(isset($_GET['user-id'])){
    $id = $_GET['user-id'];
}else{
    $output['error'] = 'No user ID received';
};

// connect to database
require_once('mysql-connect.php');

if(empty($output['error']) && $id){

    // make query variable of what you want from the database
    $query = "SELECT `id`,`name`,`email`,`created_at`,`updated_at` FROM `users` WHERE `id`=$id";

    // note: result isn't the actual data 
    $result = mysqli_query($conn,$query);

    // check what $result looks likes
    // echo '<pre>';
    // print_r($result);
    // echo '</pre>';

    if($result){
        $output['success'] = true;
        $output['user'] = null;

        if(mysqli_num_rows($result)){
            $output['user'] = mysqli_fetch_assoc($result);
        }else{
            $output['message'] = "No user with ID of $id found";
        }
    }else{
        $output['error'] = 'Error getting data from database';
    }
};

print json_encode($output);