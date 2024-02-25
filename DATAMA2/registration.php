<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="css/styles.css">
    <title>CMS</title>
</head>
<body>
    <div class="container">
        <form class="mx-auto bg-white" action="registration.php" method="post">
            <h2 class="text-center my-3">Sign Up</h2>
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // PHP code for handling form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $fname = isset($_POST["fname"]) ? $_POST["fname"] : "";
                    $mname = isset($_POST["mname"]) ? $_POST["mname"] : "";
                    $lname = isset($_POST["lname"]) ? $_POST["lname"] : "";
                    $email = isset($_POST["email"]) ? $_POST["email"] : "";
                    $password = isset($_POST["password"]) ? $_POST["password"] : "";
                    $confirm = isset($_POST["confirm"]) ? $_POST["confirm"] : "";
                    $errors = array();

                    if (empty($fname) || empty($mname) || empty($lname) || empty($email) || empty($password) || empty($confirm)) {   // requires all fields
                        array_push($errors, "All fields are required.");    
                    } else {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   // email validation
                            array_push($errors, "Email is invalid.");   
                        } 
                        if (strlen($password) < 8) {    // password should be 8 or more characters
                            array_push($errors, "Password should be 8 or more characters.");
                        } else if ($password !== $confirm) {    // password validation
                            array_push($errors, "Passwords don't match.");
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
                        $query = "INSERT INTO tbl_admin (FNAME, MNAME, LNAME, EMAIL, PASSWORD) VALUES (?, ?, ?, ?, ?);";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $query)) {
                            // Handle database error
                            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                        } else {
                            // Bind parameters and execute query
                            mysqli_stmt_bind_param($stmt, "sssss", $fname, $mname, $lname, $email, $hashedPassword);
                            mysqli_stmt_execute($stmt);
                            // Display success message
                            echo "<div class='alert alert-success'>Registration successful!</div>";
                            // Redirect to appropriate dashboard based on user type
                            header("Location: dashboard.php");
                        }
                    }
                }
            ?>
            <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control border border-0 border-bottom border-black rounded-0" id="fname" name="fname">
            </div>
            <div class="mb-3">
                    <label for="mname" class="form-label">Middle Name</label>
                    <input type="text" class="form-control border border-0 border-bottom border-black rounded-0" id="mname" name="mname">
            </div>
            <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control border border-0 border-bottom border-black rounded-0" id="lname" name="lname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control border border-0 border-bottom border-black rounded-0" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control border border-0 border-bottom border-black rounded-0" id="password" name="password">
                    <button class="btn border border-0 border-bottom border-black rounded-0" type="button" id="togglePassword"><i class="fa-solid fa-eye-slash"></i></button>
                </div>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control border border-0 border-bottom border-black rounded-0" id="confirm" name="confirm">
                    <button class="btn border border-0 border-bottom border-black rounded-0" type="button" id="toggleConfirmPassword"><i class="fa-solid fa-eye-slash"></i></button>
                </div>
            </div>
            <button class="btn btn-primary my-3 w-100" type="submit" name="submit" id="button">REGISTER</button>
            <div class="mb-3">
                <p class="text-center">Already have an account? <a href="login.php" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Login Now!</a></p>
            </div>
        </form>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon classes
            if (type === 'password') {
                togglePassword.querySelector('i').classList.remove('fa-eye');
                togglePassword.querySelector('i').classList.add('fa-eye-slash');
            } else {
                togglePassword.querySelector('i').classList.remove('fa-eye-slash');
                togglePassword.querySelector('i').classList.add('fa-eye');
            }
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirm');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            
            // Toggle the eye icon classes
            if (type === 'password') {
                toggleConfirmPassword.querySelector('i').classList.remove('fa-eye');
                toggleConfirmPassword.querySelector('i').classList.add('fa-eye-slash');
            } else {
                toggleConfirmPassword.querySelector('i').classList.remove('fa-eye-slash');
                toggleConfirmPassword.querySelector('i').classList.add('fa-eye');
            }
        });
    </script>    
</body>
</html>
