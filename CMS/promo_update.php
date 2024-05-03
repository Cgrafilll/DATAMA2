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
        <form class="mx-auto bg-white" action="promo_update.php?update=<?php echo $_GET["update"]; ?>" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Check if update ID is set
                if(isset($_GET["update"])) {
                    $id = $_GET["update"];
                    // PHP code for handling form submission
                    if (isset($_POST["submit"])) {
                        $promo = $_POST["promo"];
                        $validity = $_POST["validity"];
                        $discount = $_POST["discount"];
                        $errors = array();
                        if (empty($promo) || empty($validity) || empty($discount)) {   // Requires all fields
                            array_push($errors, "All fields are required.");    
                        } else {
                            if (!strtotime($validity)) {
                                array_push($errors, "Invalid date format.");
                            }
                        }
                        if (count($errors) > 0) {
                            // Display errors if any
                            foreach($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        } else {
                            // If no errors, proceed with database update
                            $query = "UPDATE tbl_promotions SET promo_code = '$promo', validity_period = '$validity', discounted_prices = '$discount' WHERE promo_id = $id";
                            $stmt = mysqli_query($conn, $query);
                            if ($stmt) {
                                // Redirect to appropriate dashboard based on user type
                                header("Location: promo.php");
                                exit(); // Make sure to exit after redirection
                            } else {
                                // Handle database error
                                echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                            }
                        }
                    } else {
                        // Retrieve record data when form is initially loaded
                        $sql = "SELECT * FROM tbl_promotions WHERE promo_id = $id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $promo = $row["promo_code"];
                        $validity = $row["validity_period"];
                        $discount = $row["discounted_prices"];
                    }
                } else {
                    echo "<div class='alert alert-danger'>No record ID specified for update.</div>";
                }
            ?>
            <div class="mb-3">
                <label for="promo" class="form-label">Promo Code</label>
                <input type="text" class="form-control" id="promo" name="promo" value="<?php echo isset($promo) ? $promo : ''; ?>" placeholder="Enter promo code" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="validity" class="form-label">Validity Period</label> 
                <input type="text" class="form-control" id="validity" name="validity" value="<?php echo isset($validity) ? $validity : ''; ?>" placeholder="Enter validity period" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="text" class="form-control" id="discount" name="discount" value="<?php echo isset($discount) ? $discount : ''; ?>" placeholder="Enter discount" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="promo.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>