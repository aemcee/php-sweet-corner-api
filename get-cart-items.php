<?php 
// METHOD GET
// GETS cart id via query string (GET)
// returns items in cart

// $cartItems = [
//     [
//         'product_name' => 'Cupcake',
//         'product_cost' => 200,
//         'cart_item_quantity' => 2,
//         'image' => [
//             'src' => '/image/path.jpg',
//             'alt' => 'This is a product image'
//         ],
//         'user_id' => 1,
//         'cart_id' => 1,
//         'product_id' => 2
//     ]
// ];

$output = [
    'success' => false
];

require('setup.php');

if(isset($_GET['cart-id'])){
    $cart_id = $_GET['cart-id'];
}else{
    throw new ApiException([], 406, 'No cart id'); 
}

$query = "SELECT u.id as userid, u.name as nameid
FROM `users` as `u`
JOIN `cart` as `c` on c.user_id = u.id";


