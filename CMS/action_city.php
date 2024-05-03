<?php
require_once "includes/dbh.inc.php"; // Ensure this file path is correct
$output = "";
if(isset($_POST["provinceID"])) {
    $sql = "SELECT * FROM city WHERE province_id='" . $_POST["provinceID"] . "' ORDER BY city_name";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected> - Select City - </option>';
    while($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row["city_id"] . '">' . $row["city_name"] . '</option>';
    }
}
echo $output;
?>
