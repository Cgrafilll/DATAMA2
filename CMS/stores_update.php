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
        <form class="mx-auto bg-white" action="stores_update.php?update=<?php echo $_GET["update"]; ?>" method="post">
            <?php
                // Include the database connection file
                require_once "includes/dbh.inc.php";
                // Check if update ID is set
                if(isset($_GET["update"])) {
                    $id = $_GET["update"];
                    // PHP code for handling form submission
                    if (isset($_POST["submit"])) {
                        // Retrieve form data if available
                        $country_id = isset($_POST["country"]) ? $_POST["country"] : null;
                        $province_id = isset($_POST["province"]) ? $_POST["province"] : null;
                        $city_id = isset($_POST["city"]) ? $_POST["city"] : null;
                        $store_contact = isset($_POST["store_contact"]) ? $_POST["store_contact"] : null;
                        $store_email = isset($_POST["store_email"]) ? $_POST["store_email"] : null;
                        $errors = array();
                        // Check for empty fields
                        if (empty($country_id) || empty($province_id) || empty($city_id) || empty($store_contact) || empty($store_email)) {   
                            array_push($errors, "All fields are required.");    
                        } else {
                            // Validate contact number length
                            if (strlen($store_contact) !== 11) {
                                array_push($errors, "Please enter a valid contact number (11 characters).");
                            }
                        }
                        if (count($errors) > 0) {
                            // Display errors if any
                            foreach($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        } else {
                            // Retrieve country name
                            $sql_country = "SELECT country_name FROM country WHERE country_id='$country_id'";
                            $result_country = mysqli_query($conn, $sql_country);
                            $row_country = mysqli_fetch_assoc($result_country);
                            $country_name = $row_country ? $row_country['country_name'] : "";
                            // Retrieve province name
                            $sql_province = "SELECT province_name FROM province WHERE province_id='$province_id'";
                            $result_province = mysqli_query($conn, $sql_province);
                            $row_province = mysqli_fetch_assoc($result_province);
                            $province_name = $row_province ? $row_province['province_name'] : "";
                            // Retrieve city name
                            $sql_city = "SELECT city_name FROM city WHERE city_id='$city_id'";
                            $result_city = mysqli_query($conn, $sql_city);
                            $row_city = mysqli_fetch_assoc($result_city);
                            $city_name = $row_city ? $row_city['city_name'] : "";
                            // Concatenate address
                            $store_address = "$city_name, $province_name, $country_name";
                            // Update data in tbl_store table
                            $query = "UPDATE tbl_store SET store_address = '$store_address', store_contact = '$store_contact', store_email = '$store_email' WHERE store_id = $id";
                            $stmt = mysqli_query($conn, $query);
                            if ($stmt) {
                                // Redirect to appropriate dashboard based on user type
                                header("Location: stores.php");
                                exit(); // Make sure to exit after redirection
                            } else {
                                // Handle database error
                                echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                            }
                        }
                    } else {
                        // Retrieve record data when form is initially loaded
                        $sql = "SELECT * FROM tbl_store WHERE store_id = $id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $store_address = $row["store_address"];
                        $store_contact = $row["store_contact"];
                        $store_email = $row["store_email"];
                    }
                } else {
                    echo "<div class='alert alert-danger'>No record ID specified for update.</div>";
                }
            ?>
        <div class="mb-3">
            <label class="form-label">Store Address</label>
                <div class="row g-3">
                    <div class="col-sm">
                    <div class="form-group">
                        <select class="form-select" id="country" name="country">
                            <option value="" disabled selected> - Select Country - </option>
                            <?php
                                $sql = "SELECT * FROM country ORDER BY country_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <option value="<?= $row["country_id"]; ?>"><?= $row["country_name"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <select class="form-select" id="province" name="province">
                                <option value="" disabled selected> - Select Province - </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <select class="form-select" id="city" name="city">
                                <option value="" disabled selected> - Select City - </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="store_contact" class="form-label">Store Contact Number</label> 
                <input type="text" class="form-control" id="store_contact" name="store_contact" value="<?php echo "$store_contact"; ?>" placeholder="Enter store contact number" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="store_email" class="form-label">Store Email</label>
                <input type="text" class="form-control" id="store_email" name="store_email" value="<?php echo "$store_email"; ?>" placeholder="Enter store email" autocomplete="off">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="stores.php" role="button">Cancel</a>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#country").change(function(){
                var country_id=$(this).val();
                $.ajax({
                    url:"action_province.php",
                    method:"POST",
                    data:{countryID:country_id},
                    success:function(data){
                        $("#province").html(data);
                        $("#city").html('<option value="" disabled selected> - Select City - </option>'); // Clear city options when country changes
                    }
                });
            });

            $("#province").change(function(){
                var province_id=$(this).val();
                $.ajax({
                    url:"action_city.php",
                    method:"POST",
                    data:{provinceID:province_id},
                    success:function(data){
                        $("#city").html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>
