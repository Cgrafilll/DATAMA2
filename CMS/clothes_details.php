<?php
// Include the database connection file
require_once "includes/dbh.inc.php";

// Check if clothes_code is provided in the GET request
if(isset($_GET["clothes_code"])) {
    // Sanitize the input to prevent SQL injection
    $clothes_code = mysqli_real_escape_string($conn, $_GET["clothes_code"]);

    // Prepare and execute the SQL query to retrieve details based on clothes_code
    $sql = "SELECT clothes_type, brand_name, price FROM tbl_clothes WHERE clothes_code = '$clothes_code'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($result) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);

        // Check if a row was found
        if($row) {
            // Create an array to hold the details
            $details = array(
                'clothes_type' => $row['clothes_type'],
                'brand_name' => $row['brand_name'],
                'price' => $row['price']
            );

            // Return the details as a JSON response
            echo json_encode($details);
        } else {
            // No matching row found
            echo json_encode(array('error' => 'No matching record found'));
        }
    } else {
        // Query execution failed
        echo json_encode(array('error' => 'Failed to execute query'));
    }
} else {
    // clothes_code parameter not provided
    echo json_encode(array('error' => 'clothes_code parameter not provided'));
}
?>
