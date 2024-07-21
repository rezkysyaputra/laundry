<?php
include "../includes/db_connect.php";

$user_id = $_POST['user_id'];
$customerName = $_POST['name'];
$gender = $_POST['gender'];
$phone_number = $_POST['phone'];
$district = $_POST['district'];
$street = $_POST['street'];
$address = "$street, $district";

// Prepare and bind
$getPhoneStmt = $db->prepare("SELECT COUNT(*) FROM customer WHERE phone_number = ? AND is_deleted = false");
$getPhoneStmt->bind_param("s", $phone_number);
$getPhoneStmt->execute();
$getPhoneStmt->bind_result($phoneCount);
$getPhoneStmt->fetch();
$getPhoneStmt->close();

$getNameStmt = $db->prepare("SELECT COUNT(*) FROM customer WHERE name = ? AND is_deleted = false");
$getNameStmt->bind_param("s", $customerName);
$getNameStmt->execute();
$getNameStmt->bind_result($nameCount);
$getNameStmt->fetch();
$getNameStmt->close();

if ($phoneCount > 0) {
    header('Location: ../cashier/customer.php?status=phonealreadyexist');
    exit();
}
if ($nameCount > 0) {
    header('Location: ../cashier/customer.php?status=namealreadyexist');
    exit();
}

// Prepare and bind for insertion
$sqlCreateCustomer = $db->prepare("INSERT INTO customer (user_id, name, phone_number, gender, address) VALUES (?, ?, ?, ?, ?)");
$sqlCreateCustomer->bind_param("issss", $user_id, $customerName, $phone_number, $gender, $address);
$queryCreateCustomer = $sqlCreateCustomer->execute();

if ($queryCreateCustomer) {
    header('Location: ../cashier/customer.php?status=successCreate');
    exit();
} else {
    header('Location: ../cashier/customer.php?status=failedCreate');
    exit();
}

// $sqlCreateCustomer->close();
// $db->close();
