<?php

// php endpoint that takes care of updates
/*

0. Get the database connection
1. Create an associative array to hold all of the updates
2. Gather each field in $_POST into our updates
    - name
    - email
    - password (don't forget to encrypt)
    2.a. Make sure there are updates to apply
3. Decide which user to update (by id)
    The client should specifiy which id
    Check $_GET for which id
4. Build a query string that holds an update statement
    Then send the query string to the database with mysqli_query

*/

$output = [
    'success' => false
];

// $name = null;
// $email = null;
// $password = null;

$updates = [];

// gather field in $_POST into updates
if(isset($_POST['name'])){
    $updates['name'] = $_POST['name'];
};

if(isset($_POST['email'])){
    $updates['email'] = $_POST['email'];
};

if(isset($_POST['password'])){
    $updates['password']= hash('sha256',$_POST['password']);
};

// gather id field in $_GET
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $output['error'] = 'Missing user id';
};


if(empty($updates)){
    $output['error'] = 'No fields provided for update';
    exit;
}

// ensure update data is all provided
// Note: Don't really need all fields to be provided for an update therefore an update associative array is used
// if(!$name || !$email || !$password){
//     $output['error'] = 'Missing an input field';
// };

// get database connection
require_once('mysql-connect.php');

// if no error messages
if(empty($output['error'])){

    // Note: this is long. Also you can use updates associative array to build this string instead
    $query = "UPDATE `users` SET `name` = '$name', `email` = '$email', `password` = '$password' WHERE `id` = $id";
    $result = mysqli_query($conn, $query);

    // $error = mysqli_error($conn);
    // print $error;
   
    echo '<pre>';
    print_r($result);
    echo '</pre>';

    // if received result form the mysqli query 
    if($result){
        $output['success'] = true;
        $output['user'] = null;

        if(mysqli_affected_rows($conn)){
            // maybe implement a json print of what was changed
            // $output['user'] = mysqli_fetch_assoc($result);
            $output['message'] = "Updated user with ID of $id";
        }else{
            $output['message'] = "No user with ID of $id found";
        };
    }else{
        $output['error'] = 'Error getting data from database';
    };
};

print json_encode($output);


