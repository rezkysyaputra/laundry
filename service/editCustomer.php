<?php
include '../includes/db_connect.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update data customer
    $sql = "UPDATE customer SET 
            name = '$name',  
            gender = '$gender',
            phone_number = '$phone_number',
            address = '$address',
            updated_at = NOW()
            WHERE id = $id";

    $query = mysqli_query($db, $sql);

    if ($query) {
        header('Location: ../cashier/customer.php?status=editsuccess');
        exit();
    } else {
        header('Location: ../cashier/customer.php?status=editfailed');
        exit();
    }
} else {
    header('Location: ../cashier/customer.php'); // Redirect jika tidak ada data yang dikirimkan
    exit();
}
