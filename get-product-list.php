<?php

/*
    0. Get a database connection
    1. Select all of the product data
        (join it with the image data)
    2. Return all of the data as a JSON array
*/

// template output response
$output = [
    'success' => false
];

// get database connection
require('mysql-connect.php');

// if there are no errors from connecting with the mysql database
if(empty($output['errors'])){
    $query = "SELECT p.id,p.name,p.cost,i.id as image_id,i.alt_text,i.file_path FROM `products` as `p` JOIN `images` as `i` on `p`.`image_id` = `i`.`id`";

    // send connection object and query to mysql database
    $result = mysqli_query($conn, $query);

    // echo '<pre>';
    // print_r(mysqli_fetch_assoc($result));
    // print_r(mysqli_fetch_assoc($result));
    // echo '</pre>';

    if($result){
        $output['success'] = true;

        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                $output['result'][] = [
                    'id' => (int) $row['id'],
                    'name' => $row['name'],
                    'cost' => (int) $row['cost'],
                    'image' => [
                        'id' => (int) $row['image_id'],
                        'alt' => $row['alt_text'],
                        'src' => $row['file_path']
                    ]
                ];
            };
        }else{
            $output['message'] = 'Empty array in the database';
        };

    }else{
        $output['error'] = "Error with result from mysqli query";
    };

};

print json_encode($output);
