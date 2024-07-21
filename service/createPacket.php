<?php
include "../includes/db_connect.php";

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$estimation = $_POST['estimation'];
$price = $_POST['price'];
$keterangan = $_POST['Keterangan'];

// Check if the packet name already exists
$sqlname = "SELECT name FROM packet WHERE name = '$name' AND is_deleted = false";
$cekname = mysqli_query($db, $sqlname);

if (mysqli_num_rows($cekname) > 0) {
    header('Location: ../admin/packets.php?status=failedadd');
    exit();
}

// Insert new packet data
$sql = "INSERT INTO packet (user_id, name, estimation, price, description) VALUES ($user_id, '$name', '$estimation', '$price', '$keterangan')";
$queryCreate = mysqli_query($db, $sql);

if ($queryCreate) {
    header('Location: ../admin/packets.php?status=successCreate');
    exit();
} else {
    header('Location: ../admin/packets.php?status=failedCreate');
    exit();
}
