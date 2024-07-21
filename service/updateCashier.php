<?php
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $id = $_POST['id']; // Ensure id is an integer
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update the cashier record
    $sql = "UPDATE user SET full_name = '$full_name', password = '$password', gender = '$gender', phone_number = $phone_number, address = '$address' WHERE id = $id";
    $stmt = mysqli_query($db, $sql);

    if ($stmt > 0) {
        // Redirect back to cashier.php with success status
        header("Location: ../admin/cashier.php?status=successUpdate");
        exit;
    } else {
        header("Location: ../admin/cashier.php?status=failedUpdate");
        exit;
    }
} else {
    // Redirect to cashier.php if the form was not submitted properly
    header("Location: ../admin/cashier.php");
    exit;
}
