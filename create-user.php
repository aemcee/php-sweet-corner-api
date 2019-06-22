<?php

require_once('setup.php');

$output = [
    'success' => false
];

// user data needed to make a new user
$name = null;
$email = null;
$password = null;

if(isset($_POST['name'])){
    $name = $_POST['name'];
}else{
    // throw new ApiException($output, 422, 'Missing Name');
    $output['errors'][] = 'Missing Name';
}

// things to improve: validate email
if(isset($_POST['email'])){
    $email = $_POST['email'];
}else{
    $output['errors'][] = 'Missing Email';
}

// things to improve: validate valid password
if(isset($_POST['password'])){
    $password = hash('sha256',$_POST['password']);
}else{
    $output['errors'][] = 'Missing Password';
}

// Test echos to make sure we are getting the correct data
// echo 'Name: '.$name;
// echo '<br>';
// echo 'Email: '.$email;
// echo '<br>';
// echo 'Password: '.$password;
// echo '<br>';

// can create more detailed error messages with an array
// if(!$name || !$email || !$password){
//     $output['error'] = 'Missing user data';
// };

if(!empty($output['errors'])){
    throw new ApiException($output, 422);
};

// require_once('mysql-connect.php');


// WHEN DOING AN INSERT YOU WILL NOT GET A RESULT BACK!!!
$query = "INSERT INTO `users` (`name`,`email`,`password`,`created_at`,`updated_at`) 
    VALUES ('$name','$email','$password', CURRENT_TIME, CURRENT_TIME)";

// print $query;
// exit;

$result = $conn->query($query);

echo '<pre>';
var_dump($result);
var_dump($conn);
echo '</pre>';

if($result){
    // mysqli_affected_rows will tell you how much rows were affected. This case how many users changed/added
    if($conn->affected_rows){
        $insertedId = $conn->insert_id;

        $output['success'] = true;
        $output['user-id'] = $insertedId; 
        $output['message'] = "Successfully created User ID of $insertedId";
    }else{
        throw new ApiException($output, 406, 'User not created');
    };
}else{
    throw new ApiException($output, 500, 'Database error');
}

print json_encode($output);