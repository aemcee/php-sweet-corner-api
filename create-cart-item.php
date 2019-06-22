<?php

// METHOD POST
// GETS a Cart id and product id via POST
// and quantity via POST if no quantity default to 1
// Remember to set created at and updated at to current time
// Creates a new cart item
// On success, success => true, message => 'item added to cart', cart_id => 2

require_once('setup.php');

$output = [
    'success' => false
];

if(isset($_POST['cart-id'])){
    $cart_id = $_POST['cart-id'];
}else{
    $output['errors'][] = 'Missing Cart ID';
};

if(isset($_POST['product-id'])){
    $product_id = $_POST['product-id'];
}else{
    $output['errors'][] = 'Missing Product ID';
};

if(isset($_POST['quantity'])){
    $quantity = $_POST['quantity'];
}else{
    $quantity = 1;
    $output['message'][] = 'quantity of 1 defaulted';
};

if(!empty($output['errors'])){
    throw new ApiException($output, 422);
};

$query = "INSERT INTO `cart_items` (`cart_id`,`product_id`,`quantity`,`updated_at`,`created_at`) 
    VALUES ('$cart_id','$product_id','$quantity', CURRENT_TIME, CURRENT_TIME)";

$result = $conn->query($query);
// $result = mysqli_query($conn,$query);

echo '<pre>';
print_r($result);
print_r($conn);
echo '</pre>';

if($result){
    // $conn->affected_row??? is affected row a part of $conn?
    if($conn->insert_id){
        // $insertedId = $conn->insert_id;
        $output['success'] = true;
        $output['message'][] = 'Item added to cart';
        $output['cart_id'] = $cart_id;
    }else{
        throw new ApiException($output, 406, 'Could not add item to cart');
    }
}else{
    throw new ApiException($output, 500, 'Database error');
}

print json_encode($output);