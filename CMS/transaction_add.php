<?php
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $storeAddress = $_POST['store_address'];
        $clothes_code = $_POST['clothes_code'];
        $clothes_type = isset($_POST['clothes_type']) ? $_POST['clothes_type'] : null;
        $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $fullName = "$fname $mname $lname";
        
        // Include the database connection file
        require_once "includes/dbh.inc.php";
        
        // Insert data into tbl_transaction
        $sql = "INSERT INTO tbl_transaction (customer_name, store_address, clothes_type, brand_name, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $fullName, $storeAddress, $clothes_type, $brand_name, $price);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            // Redirect back to the form page or any other page
            header("Location: transaction.php");
            exit();
        } else {
            // Handle database error
            echo "SQL statement preparation failed: " . mysqli_error($conn);
            exit();
        }
    }
?>
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
        <form class="mx-auto bg-white" action="transaction_add.php" method="post">
            <div class="row g-3">
            <div class="col-md-4">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>
            <div class="col-md-4">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="mname" name="mname" required>
            </div>
            <div class="col-md-4">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="store_address" class="form-label">Store Address</label>
                    <select class="form-select" id="store_address" name="store_address" required>
                        <option value="" disabled selected> - Select Store Address - </option>
                        <?php
                            // Include the database connection file
                            require_once "includes/dbh.inc.php";
                            // Fetch store addresses from the database
                            $sql = "SELECT * FROM tbl_store ORDER BY store_address";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['store_address'] . "'>" . $row['store_address'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-3">
                <label for="clothes_code" class="form-label">Clothes Code</label> 
                <div class="form-group">
                    <select class="form-select" id="clothes_code" name="clothes_code">
                        <option value="none" disabled selected> - Select Clothes Code - </option>
                        <?php
                            // Fetch clothes codes from the database
                            $sql = "SELECT * FROM tbl_clothes ORDER BY clothes_code";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['clothes_code'] . "'>" . $row['clothes_code'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <label for="clothes_type" class="form-label">Clothes Type</label>
                <input class="form-control" type="text" id="clothes_type" name="clothes_type" required>
            </div>
            <div class="col-md-3">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input class="form-control" type="text" id="brand_name" name="brand_name" required>
            </div>
            <div class="col-md-3">
                <label for="price" class="form-label">Price</label>
                <input class="form-control" type="text" id="price" name="price" required>
            </div>
        </div>  
        <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
        <a class="btn btn-secondary mt-3" href="transaction.php" role="button">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find the clothes_code select element
            const clothesCodeSelect = document.getElementById('clothes_code');

            // Find the clothes_type input element
            const clothesTypeInput = document.getElementById('clothes_type');
            
            // Add change event listener to the clothes_code select element
            clothesCodeSelect.addEventListener('change', function(event) {
                // Get the selected clothes code
                const selectedClothesCode = event.target.value;
                
                // Make an AJAX request to fetch clothes details
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'clothes_details.php?clothes_code=' + selectedClothesCode, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            console.error(response.error);
                        } else {
                            // Update the UI with the retrieved clothes details
                            clothesTypeInput.value = response.clothes_type;
                            document.getElementById('brand_name').value = response.brand_name;
                            document.getElementById('price').value = response.price;
                        }
                    } else {
                        console.error('Error fetching clothes details. Status code: ' + xhr.status);
                    }
                };
                xhr.send();
            });
        });
    </script>
</body>
</html>
