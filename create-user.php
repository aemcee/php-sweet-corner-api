<?php

$output = [
    'success' => false
];

// user data needed to make a new user
$name = null;
$email = null;
$password = null;

if(isset($_POST['name'])){
    $name = $_POST['name'];
};

// things to improve: validate email
if(isset($_POST['email'])){
    $email = $_POST['email'];
};

// things to improve: validate valid password
if(isset($_POST['password'])){
    $password = hash('sha256',$_POST['password']);
};

// Test echos to make sure we are getting the correct data
// echo 'Name: '.$name;
// echo '<br>';
// echo 'Email: '.$email;
// echo '<br>';
// echo 'Password: '.$password;
// echo '<br>';

// can create more detailed error messages with an array
if(!$name || !$email || !$password){
    $output['error'] = 'Missing user data';
};

require_once('mysql-connect.php');

// above might throw an error therefore we need a check
if(empty($output['error'])){

    // WHEN DOING AN INSERT YOU WILL NOT GET A RESULT BACK!!!
    $query = "INSERT INTO `users` (`name`,`email`,`password`,`created_at`,`updated_at`) 
        VALUES ('$name','$email','$password', CURRENT_TIME, CURRENT_TIME)";

    // print $query;
    // exit;

    $result = mysqli_query($conn, $query);

    // echo '<pre>';
    // var_dump($result);
    // echo '</pre>';

    if($result){
        // mysqli_affected_rows will tell you how much rows were affected. This case how many users changed/added
        if(mysqli_affected_rows($conn)){
            $insertedId = mysqli_insert_id($conn);

            $output['success'] = true;
            $output['user-id'] = $insertedId; 
            $output['message'] = "Successfully created User ID of $insertedId";
        }else{
            $output['error'] = 'User not created';
        };
    }else{
        $output['error'] = 'Database error';
    }
};

print json_encode($output);