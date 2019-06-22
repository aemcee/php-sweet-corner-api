<?php

require_once('setup.php');

// using prepared statements helps to prevent sql injection attacks
// also can reuse the statement as many times as we want
$stmt = $conn->prepare('INSERT INTO `products` (`name`, `description`, `cost`, `image_id`, `updated_at`, `created_at`) VALUES (?, ?, ?, ?, CURRENT_TIME, CURRENT_TIME)');

// bind values to the "?"
$name = 'Cupcake 100';
$description = 'Cupcake 100 description';
$cost = 470;
$image_id = 1;

// a list of datatypes we will pass in, represented by a single letter. order matters
// binds values into query
$stmt->bind_param('ssii', $name, $description, $cost, $image_id);

$stmt->execute();

// NOTE: using prepared statements causes a slight delay
//-----------------------------------------
$name = 'Cupcake 101';
$description = 'Cupcake 101 description';
$cost = 777;

$stmt->execute();
//-----------------------------------------
$name = 'Cupcake 102';
$description = 'Cupcake 102 description';
$cost = 777;

$stmt->execute();
//-----------------------------------------
print 'New products added';