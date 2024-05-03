<?php
    // Include the database connection file
    require_once "includes/dbh.inc.php";
    // Admin Table
    if(isset($_GET["delete_admin"])) {
        $id = $_GET["delete_admin"];
        $sql = "DELETE FROM tbl_admin WHERE admin_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: admin.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Employee Table
    if(isset($_GET["delete_employee"])) {
        $id = $_GET["delete_employee"];
        $sql = "DELETE FROM tbl_employees WHERE employee_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: employee.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Clothes Table
    if(isset($_GET["delete_clothes"])) {
        $id = $_GET["delete_clothes"];
        $sql = "DELETE FROM tbl_clothes WHERE clothes_code = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: clothes.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Customer Table
    if(isset($_GET["delete_customer"])) {
        $id = $_GET["delete_customer"];
        $sql = "DELETE FROM tbl_customers WHERE customer_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: customers.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Promotions Table
    if(isset($_GET["delete_promo"])) {
        $id = $_GET["delete_promo"];
        $sql = "DELETE FROM tbl_promotions WHERE promo_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: promo.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Store Table
    if(isset($_GET["delete_store"])) {
        $id = $_GET["delete_store"];
        $sql = "DELETE FROM tbl_store WHERE store_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: stores.php");
        } else {
            die(mysqli_error($conn));
        }
    }
    // Supplier Table
    if(isset($_GET["delete_supplier"])) {
        $id = $_GET["delete_supplier"];
        $sql = "DELETE FROM tbl_supplier WHERE supplier_id = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: suppliers.php");
        } else {
            die(mysqli_error($conn));
        }
    }
?>