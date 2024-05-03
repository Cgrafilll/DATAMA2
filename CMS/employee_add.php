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
        <form class="mx-auto bg-white" action="employee_add.php" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // PHP code for handling form submission
                if (isset($_POST["submit"])) {
                    $FNAME = $_POST["FNAME"];
                    $MNAME = $_POST["MNAME"];
                    $LNAME = $_POST["LNAME"];
                    $EMAIL = $_POST["EMAIL"];
                    $PASSWORD = $_POST["PASSWORD"];
                    $errors = array();
                    if (empty($FNAME) || empty($MNAME) || empty($LNAME) || empty($EMAIL)) {   // Requires all fields
                        array_push($errors, "All fields are required.");    
                    } else {
                        if (!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Email is invalid.");
                        }
                        if (strlen($PASSWORD) < 8) {
                            array_push($errors, "Password should be 8 characters or longer.");
                        }
                    }
                    if (count($errors) > 0) {
                        // Display errors if any
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // If no errors, proceed with database insertion
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO tbl_employees (FNAME, MNAME, LNAME, EMAIL, PASSWORD) VALUES ('$FNAME', '$MNAME', '$LNAME', '$EMAIL', '$hashedPassword');";
                        $stmt = mysqli_query($conn, $query);
                        if ($stmt) {
                            // Redirect to appropriate dashboard based on user type
                            header("Location: employee.php");
                            exit(); // Make sure to exit after redirection
                        } else {
                            // Handle database error
                            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                }
            ?>
            <div class="mb-3">
                <label for="FNAME" class="form-label">First Name</label>
                <input type="text" class="form-control" id="FNAME" name="FNAME" placeholder="Enter first name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="MNAME" class="form-label">Middle Name</label> 
                <input type="text" class="form-control" id="MNAME" name="MNAME" placeholder="Enter middle name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="LNAME" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="LNAME" name="LNAME" placeholder="Enter last name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="EMAIL" class="form-label">Email Address</label>
                <input type="text" class="form-control" id="EMAIL" name="EMAIL" placeholder="Enter email address" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="PASSWORD" class="form-label">Password</label>
                <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="Enter password" autocomplete="off">
                
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="employee.php" role="button">Cancel</a>
        </form>
    </div>
</body>
</html>