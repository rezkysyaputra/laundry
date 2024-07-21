<?php
include '../includes/db_connect.php';

if (isset($_POST['submit'])) {
  $user_id = $_POST['user_id'];
  $customer_id = $_POST['customer_id'];
  $packet_id = $_POST['packet'];
  $weight = $_POST['weight'];
  $discount = $_POST['discount'];

  // Ambil harga packet
  $sqlPacket = 'SELECT price FROM packet WHERE id = ' . $packet_id;
  $queryPacket = mysqli_query($db, $sqlPacket);
  if ($queryPacket) {
    $rowPacket = mysqli_fetch_assoc($queryPacket);
    $price = $rowPacket['price'];

    // Hitung total harga
    $total = ($price * $weight) - $discount;

    // Simpan data transaksi
    $sql = "INSERT INTO transaction (user_id, customer_id, packet_id, weight, discount, amount) 
            VALUES ($user_id, $customer_id, $packet_id, $weight, $discount, $total)";
    $query = mysqli_query($db, $sql);
    if ($query) {
      header('location:../cashier/transaction.php?status=createsuccess');
      exit();
    } else {
      header('location:../cashier/transaction.php?status=createfailed');
      exit();
    }
  } else {
    header('location:../cashier/transaction.php?status=createfailed');
  }

  mysqli_close($db);
}
