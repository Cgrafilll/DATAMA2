<?php
    session_start();
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
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
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <div class="offcanvas-body">
                <ul class="navbar-nav nav-tabs justify-content-center flex-grow-1">
                <span class="navbar-brand me-auto text-white">Clothing Management System</span>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="clothes.php" aria-current="page">Clothes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="promo.php">Promos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="customers.php">Customers</a>
                    </li>
                    <?php if($username !== "Employee"): ?>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="admin.php">Admin</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="employee.php">Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="suppliers.php">Suppliers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 active" href="stores.php">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="transaction.php">Transaction</a>
                    </li>
                    <button type="button" class="button border border-0 ms-auto" id="home"><span><?php echo "$username"; ?></span></button>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 d-flex flex-column justify-content-center align-items-center">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>Store ID</th>
                    <th>Store Address</th>
                    <th>Store Contact Number</th>
                    <th>Store Email</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody class="text-center">
              <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Fetch data from the database
                $sql = "SELECT * FROM tbl_store";
                $result = $conn->query($sql);
                // Check if there are any results
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo "<tr>
                        <td>" .$row["store_id"] . "</td>
                        <td>" . $row["store_address"] . "</td>
                        <td>" . $row["store_contact"] . "</td>
                        <td>" . $row["store_email"] . "</td>
                        <td class='d-flex justify-content-center align-items-center'>
                          <a class='btn btn-secondary mx-1' href='stores_update.php?update=".$row["store_id"]."' role='button'>Edit</a>
                          <a class='btn btn-danger mx-1' href='delete.php?delete_store=".$row["store_id"]."' role='button'>Delete</a>
                        </td>
                      </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
              ?>                  
            </tbody>
        </table>
        <div class="container d-flex justify-content-end align-items-center">
            <a class="btn btn-dark mx-1" href="stores_add.php" role="button">Add</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Find the home button element
        const home = document.querySelector('#home');
        // Add a click event listener to the home button
        home.addEventListener('click', function(event) {
            // Prevent the default behavior of the anchor tag
            event.preventDefault();
            // Prompt the user with a confirmation dialog
            const confirmLogout = confirm("Are you sure you want to logout?");
            // If the user confirms logout
            if (confirmLogout) {
                // Navigate to the index.html page
                window.location.href = "index.php";
            } else {
                // If the user cancels logout, do nothing
                return;
            }
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>