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
        <form class="mx-auto bg-white" action="suppliers_add.php" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // PHP code for handling form submission
                if (isset($_POST["submit"])) {
                    $supplier_contact = $_POST["supplier_contact"];
                    $supplier_catalog = $_POST["supplier_catalog"];
                    $supplier_company = $_POST["supplier_company"];
                    $manufacturer_id = $_POST["manufacturer_id"];
                    $errors = array();
                    if (empty($supplier_contact) || empty($supplier_catalog) || empty($supplier_company) || empty($manufacturer_id)) {   // Requires all fields
                        array_push($errors, "All fields are required.");    
                    } else {
                        if (strlen($supplier_contact) !== 11) {
                            array_push($errors, "Please enter a valid contact number (11 characters).");
                        }
                        if (!is_numeric($manufacturer_id)) {
                            array_push($errors, "Manufacturer's ID must be an integer.");
                        }
                    }
                    if (count($errors) > 0) {
                        // Display errors if any
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // If no errors, proceed with database insertion
                        $query = "INSERT INTO tbl_supplier (supplier_contact, supplier_catalog, supplier_company, manufacturer_id) VALUES ('$supplier_contact', '$supplier_catalog', '$supplier_company', '$manufacturer_id');";
                        $stmt = mysqli_query($conn, $query);
                        if ($stmt) {
                            // Redirect to appropriate dashboard based on user type
                            header("Location: suppliers.php");
                            exit(); // Make sure to exit after redirection
                        } else {
                            // Handle database error
                            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                }
            ?>
            <div class="mb-3">
                <label for="supplier_contact" class="form-label">Supplier Contact</label>
                <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" placeholder="Enter supplier contact" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="supplier_catalog" class="form-label">Supplier Catalog</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="supplier_catalog">
                        <option value="" disabled selected> - Select Supplier Catalog - </option>
                        <option value="Dress">Dress</option>
                        <option value="Shirt">Shirt</option>
                        <option value="Short">Short</option>
                        <option value="Pants">Pants</option>
                        <option value="Jacket">Jacket</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="supplier_company" class="form-label">Supplier Company</label>
                <input type="text" class="form-control" id="supplier_company" name="supplier_company" placeholder="Enter supplier company" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="manufacturer_id" class="form-label">Manufacturer ID</label>
                <input type="text" class="form-control" id="manufacturer_id" name="manufacturer_id" placeholder="Enter manufacturer ID" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="suppliers.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>