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
        <form class="mx-auto bg-white" action="suppliers_update.php?update=<?php echo $_GET["update"]; ?>" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Check if update ID is set
                if(isset($_GET["update"])) {
                    $id = $_GET["update"];
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
                            // If no errors, proceed with database update
                            $query = "UPDATE tbl_supplier SET supplier_contact = '$supplier_contact', supplier_catalog = '$supplier_catalog', supplier_company = '$supplier_company', manufacturer_id = '$manufacturer_id' WHERE supplier_id = $id";
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
                    } else {
                        // Retrieve record data when form is initially loaded
                        $sql = "SELECT * FROM tbl_supplier WHERE supplier_id = $id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $supplier_contact = $row["supplier_contact"];
                        $supplier_catalog = $row["supplier_catalog"];
                        $supplier_company = $row["supplier_company"];
                        $manufacturer_id = $row["manufacturer_id"];
                    }
                } else {
                    echo "<div class='alert alert-danger'>No record ID specified for update.</div>";
                }
            ?>
            <div class="mb-3">
                <label for="supplier_contact" class="form-label">Supplier Contact</label>
                <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" value="<?php echo isset($supplier_contact) ? $supplier_contact : ''; ?>" placeholder="Enter supplier contact" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="supplier_catalog" class="form-label">Supplier Catalog</label> 
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="supplier_catalog" aria-label="Floating label select example">
                        <option value="" disabled> - Select Supplier Catalog - </option>
                        <option value="Dress" <?php if(isset($supplier_catalog) && $supplier_catalog === 'Dress') echo 'selected'; ?>>Dress</option>
                        <option value="Shirt" <?php if(isset($supplier_catalog) && $supplier_catalog === 'Shirt') echo 'selected'; ?>>Shirt</option>
                        <option value="Short" <?php if(isset($supplier_catalog) && $supplier_catalog === 'Short') echo 'selected'; ?>>Short</option>
                        <option value="Pants" <?php if(isset($supplier_catalog) && $supplier_catalog === 'Pants') echo 'selected'; ?>>Pants</option>
                        <option value="Jacket" <?php if(isset($supplier_catalog) && $supplier_catalog === 'Jacket') echo 'selected'; ?>>Jacket</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="supplier_company" class="form-label">Supplier Company</label>
                <input type="text" class="form-control" id="supplier_company" name="supplier_company" value="<?php echo isset($supplier_company) ? $supplier_company : ''; ?>" placeholder="Enter supplier company" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="manufacturer_id" class="form-label">Manufacturer ID</label>
                <input type="text" class="form-control" id="manufacturer_id" name="manufacturer_id" value="<?php echo isset($manufacturer_id) ? $manufacturer_id : ''; ?>" placeholder="Enter manufacturer ID" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="suppliers.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>