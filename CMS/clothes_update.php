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
        <form class="mx-auto bg-white" action="clothes_update.php?update=<?php echo $_GET["update"]; ?>" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Check if update ID is set
                if(isset($_GET["update"])) {
                    $id = $_GET["update"];
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
                            // If no errors, proceed with database update
                            $query = "UPDATE tbl_clothes SET clothes_type = '$clothes_type', brand_name = '$brand_name', stocks = '$stocks', price = '$price' WHERE clothes_code = $id";
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
                    } else {
                        // Retrieve record data when form is initially loaded
                        $sql = "SELECT * FROM tbl_clothes WHERE clothes_code = $id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $clothes_type = $row["clothes_type"];
                        $brand_name = $row["brand_name"];
                        $stocks = $row["stocks"];
                        $price = $row["price"];
                    }
                } else {
                    echo "<div class='alert alert-danger'>No record ID specified for update.</div>";
                }
            ?>
            <div class="mb-3">
                <label for="clothes_type" class="form-label">Clothes Type</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="clothes_type">
                        <option value="" disabled> - Select Clothes Type - </option>
                        <option value="Dress" <?php if(isset($clothes_type) && $clothes_type === 'Dress') echo 'selected'; ?>>Dress</option>
                        <option value="Shirt" <?php if(isset($clothes_type) && $clothes_type === 'Shirt') echo 'selected'; ?>>Shirt</option>
                        <option value="Short" <?php if(isset($clothes_type) && $clothes_type === 'Short') echo 'selected'; ?>>Short</option>
                        <option value="Pants" <?php if(isset($clothes_type) && $clothes_type === 'Pants') echo 'selected'; ?>>Pants</option>
                        <option value="Jacket" <?php if(isset($clothes_type) && $clothes_type === 'Jacket') echo 'selected'; ?>>Jacket</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="brand_name">
                        <option value="" disabled> - Select Clothes Type - </option>
                        <option value="H&M" <?php if(isset($brand_name) && $brand_name === 'H&M') echo 'selected'; ?>>H&M</option>
                        <option value="Bench" <?php if(isset($brand_name) && $brand_name === 'Bench') echo 'selected'; ?>>Bench</option>
                        <option value="Uniqlo" <?php if(isset($brand_name) && $brand_name === 'Uniqlo') echo 'selected'; ?>>Uniqlo</option>
                        <option value="Penshoppe" <?php if(isset($brand_name) && $brand_name === 'Penshoppe') echo 'selected'; ?>>Penshoppe</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="text" class="form-control" id="stocks" name="stocks" value="<?php echo isset($stocks) ? $stocks : ''; ?>" placeholder="Enter stocks" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo isset($price) ? $price : ''; ?>" placeholder="Enter price" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="clothes.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>