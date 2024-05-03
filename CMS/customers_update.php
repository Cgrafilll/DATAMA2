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
        <form class="mx-auto bg-white" action="customers_update.php?update=<?php echo $_GET["update"]; ?>" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Check if update ID is set
                if(isset($_GET["update"])) {
                    $id = $_GET["update"];
                    // PHP code for handling form submission
                    if (isset($_POST["submit"])) {
                        $FNAME = $_POST["FNAME"];
                        $MNAME = $_POST["MNAME"];
                        $LNAME = $_POST["LNAME"];
                        $membership_status = isset($_POST["membership_status"]) ? $_POST["membership_status"] : null;
                        $contact_number = $_POST["contact_number"];
                        $errors = array();
                        if (empty($FNAME) || empty($MNAME) || empty($LNAME) || empty($membership_status) || empty($contact_number)) {   // Requires all fields
                            array_push($errors, "All fields are required.");    
                        } else {
                            if (strlen($contact_number) !== 11) {
                                array_push($errors, "Please enter a valid number (11 characters).");
                            }
                        }
                        if (count($errors) > 0) {
                            // Display errors if any
                            foreach($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        } else {
                            // If no errors, proceed with database update
                            $query = "UPDATE tbl_customers SET FNAME = '$FNAME', MNAME = '$MNAME', LNAME = '$LNAME', membership_status = '$membership_status', contact_number = '$contact_number' WHERE customer_id = $id";
                            $stmt = mysqli_query($conn, $query);
                            if ($stmt) {
                                // Redirect to appropriate dashboard based on user type
                                header("Location: customers.php");
                                exit(); // Make sure to exit after redirection
                            } else {
                                // Handle database error
                                echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                            }
                        }
                    } else {
                        // Retrieve record data when form is initially loaded
                        $sql = "SELECT * FROM tbl_customers WHERE customer_id = $id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $FNAME = $row["FNAME"];
                        $MNAME = $row["MNAME"];
                        $LNAME = $row["LNAME"];
                        $membership_status = $row["membership_status"];
                        $contact_number = $row["contact_number"];
                    }
                } else {
                    echo "<div class='alert alert-danger'>No record ID specified for update.</div>";
                }
            ?>
            <div class="mb-3">
                <label for="FNAME" class="form-label">First Name</label>
                <input type="text" class="form-control" id="FNAME" name="FNAME" value="<?php echo isset($FNAME) ? $FNAME : ''; ?>" placeholder="Enter first name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="MNAME" class="form-label">Middle Name</label> 
                <input type="text" class="form-control" id="MNAME" name="MNAME" value="<?php echo isset($MNAME) ? $MNAME : ''; ?>" placeholder="Enter middle name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="LNAME" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="LNAME" name="LNAME" value="<?php echo isset($LNAME) ? $LNAME : ''; ?>" placeholder="Enter last name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="membership_status" class="form-label">Membership Status</label>
                <div class="form-group">
                    <select class="form-select" id="floatingSelect" name="membership_status">
                        <option value="" disabled selected> - Select Membership Status - </option>
                        <option value="Active" <?php if(isset($membership_status) && $membership_status === 'Active') echo 'selected'; ?>>Active</option>
                        <option value="Inactive" <?php if(isset($membership_status) && $membership_status === 'Inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo isset($contact_number) ? $contact_number : ''; ?>" placeholder="Enter contact number" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="customers.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>