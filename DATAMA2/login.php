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
        <form class="mx-auto bg-white" action="login.php" method="post">
            <h2 class="text-center my-3">Login</h2>
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // PHP code for handling form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $email = isset($_POST["email"]) ? $_POST["email"] : "";
                    $password = isset($_POST["password"]) ? $_POST["password"] : "";
                    $errors = array();
                    // Validation
                    if (empty($email) || empty($password)) {
                        array_push($errors, "All fields are required.");
                    } else {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Email is invalid.");
                        }
                        if (strlen($password) < 8) {
                            array_push($errors, "Password should be 8 characters or longer.");
                        }
                    }
                    // Display errors
                    if (count($errors) > 0) {
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // If there are no errors, proceed with login validation based on the selected user type
                        $query = "SELECT * FROM tbl_admin WHERE EMAIL = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (mysqli_stmt_prepare($stmt, $query)) {
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if ($row = mysqli_fetch_assoc($result)) {
                                // Verify hashed password
                                $hashedPassword = $row['PASSWORD'];
                                if (password_verify($password, $hashedPassword)) {
                                    // Login successful
                                    echo "<div class='alert alert-success'>Login successful.</div>";
                                    // Redirect to appropriate dashboard based on user type
                                    header("Location: dashboard.php");
                                } else {
                                    // Login failed
                                    echo "<div class='alert alert-danger'>Please check your email or password.</div>";
                                }
                            } else {
                                // User not found
                                echo "<div class='alert alert-danger'>User not found.</div>";
                            }
                        } else {
                            // Error in preparing statement
                            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                }
            ?>
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
            <button class="btn btn-primary my-3 w-100" type="submit" id="button">LOGIN</button>
            <p class="text-center">Don't have an account? <a href="registration.php" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Register Here.</a></p>
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
    </script>    
</body>
</html>