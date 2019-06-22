<?php

// METHOD POST
// GETS a user id via POST
// Remember to set created at and updated at to current time
// Creates a new cart
// On success, success => true, message => 'Cart created successfully', cart_id => 2

require_once('setup.php');

$output = [
    'success' => false
];

if(isset($_POST['user-id'])){
    $user_id = $_POST['user-id'];
}else{
    throw new ApiException([], 406, 'Internal Server Error'); 
};

$query = "INSERT INTO `cart`(`user_id`, `created_at`, `updated_at`) VALUES ($user_id, CURRENT_TIME, CURRENT_TIME)";

$result = $conn->query($query);

echo '<pre>';
print_r($result);
print_r($conn);
print_r($conn->affected_rows);
echo '</pre>';
