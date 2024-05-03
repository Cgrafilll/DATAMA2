<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>CMS</title>
</head>
<body>
    <div class="container my-5">
        <form class="mx-auto bg-white" action="clothes_add.php" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // PHP code for handling form submission
                if (isset($_POST["submit"])) {
                    $clothes_type = isset($_POST["clothes_type"]) ? $_POST["clothes_type"] : null;
                    $brand_name = isset($_POST["brand_name"]) ? $_POST["brand_name"] : null;
                    $stocks = $_POST["stocks"];
                    $price = $_POST["price"];
                    $errors = array();
                    if (empty($clothes_type) || empty($brand_name) || empty($stocks) || empty($price)) {   // Requires all fields
                        array_push($errors, "All fields are required.");    
                    } else {
                        if (!is_numeric($stocks)) {
                            array_push($errors, "Stocks must be an integer.");
                        }
                        if (!is_numeric($price)) {
                            array_push($errors, "Price must be an integer.");
                        }
                    }
                    if (count($errors) > 0) {
                        // Display errors if any
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // If no errors, proceed with database insertion
                        $query = "INSERT INTO tbl_clothes (clothes_type, brand_name, stocks, price) VALUES ('$clothes_type', '$brand_name', '$stocks', '$price');";
                        $stmt = mysqli_query($conn, $query);
                        if ($stmt) {
                            // Redirect to appropriate dashboard based on user type
                            header("Location: clothes.php");
                            exit(); // Make sure to exit after redirection
                        } else {
                            // Handle database error
                            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                }
            ?>
            <div class="mb-3">
                <label for="clothes_type" class="form-label">Clothes Type</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="clothes_type">
                        <option value="none" disabled selected> - Select Clothes Type - </option>
                        <option value="Dress">Dress</option>
                        <option value="Shirt">Shirt</option>
                        <option value="Short">Short</option>
                        <option value="Pants">Pants</option>
                        <option value="Jacket">Jacket</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="brand_name" class="form-label">Clothes Type</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="brand_name">
                        <option value="none" disabled selected> - Select Brand - </option>
                        <option value="H&M">H&M</option>
                        <option value="Bench">Bench</option>
                        <option value="Uniqlo">Uniqlo</option>
                        <option value="Penshoppe">Penshoppe</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="text" class="form-control" id="stocks" name="stocks" placeholder="Enter stocks" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="clothes.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>