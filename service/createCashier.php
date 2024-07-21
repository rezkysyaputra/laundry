<?php
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (ensure to handle this)
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
    $district = mysqli_real_escape_string($db, $_POST['district']);
    $street = mysqli_real_escape_string($db, $_POST['street']);
    $role = 'Kasir';
    $address = "$street, $district";

    // Check if username already exists
    $check_username = "SELECT * FROM user WHERE username = '$username' AND is_deleted = false";
    $result_username = mysqli_query($db, $check_username);
    if (mysqli_num_rows($result_username) > 0) {
        header("Location: ../admin/cashier.php?status=namealreadyexist");
        exit();
    }

    // Check if phone number already exists
    $check_phone = "SELECT * FROM user WHERE phone_number = '$phone_number' AND is_deleted = false";
    $result_phone = mysqli_query($db, $check_phone);
    if (mysqli_num_rows($result_phone) > 0) {
        header("Location: ../admin/cashier.php?status=phonealreadyexist");
        exit();
    }

    // Insert data into database
    $sql = "INSERT INTO user (username, full_name, gender, phone_number, address, password ,role) 
            VALUES ('$username','$full_name', '$gender', '$phone_number', '$address','$password', '$role')";

    if (mysqli_query($db, $sql)) {
        // Success message or redirect
        header("Location: ../admin/cashier.php?status=successCreate");
        exit();
    } else {
        // Error handling
        header("Location: ../admin/cashier.php?status=failedCreate");
        exit();
    }
}
