<?php
require_once "includes/dbh.inc.php"; // Ensure this file path is correct
$output = "";
if(isset($_POST["countryID"])) {
    $sql = "SELECT * FROM province WHERE country_id='" . $_POST["countryID"] . "' ORDER BY province_name";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected> - Select Province - </option>';
    while($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
    }
}
echo $output;
?>
