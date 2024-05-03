<?php
require_once "includes/dbh.inc.php";

function filterData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$filename = "exported_data_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$query = "SELECT * FROM tbl_transaction"; // Assuming the data is stored in tbl_transaction
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Assuming column names in the database match the keys used in the PHP code
        $rowData = array($row["transaction_id"], $row["customer_name"], $row["store_address"], $row["clothes_type"], $row["brand_name"], $row["price"]);
        array_walk($rowData, 'filterData');
        echo implode("\t", $rowData) . "\n";
    }
} else {
    echo "No records found\n";
}

mysqli_close($conn);
exit;
?>
