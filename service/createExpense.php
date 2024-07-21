<?php
include("../includes/db_connect.php");

// cek apakah tombol daftar sudah diklik atau blum?


$user_id = $_POST['user_id'];
$date = $_POST['date'];
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$note = $_POST['note'];
$total = $price * $quantity;

// buat query
$sql = "insert into expense (user_id, date, name, quantity, price, total, note) values ($user_id, '$date', '$name', '$quantity', '$price', '$total', '$note')";
$query = mysqli_query($db, $sql);

//apakah query simpan berhasil?
if ($query) {
    // kalau berhasil alihkan ke halaman index.php dengan status=sukses
    header('Location: ../admin/formCreateExpense.php?status=suksesditambahkan');
} else {
    // kalau gagal alihkan ke halaman indek.php dengan status=gagal
    header('Location:../admin/expenses.php?status=gagalditambahkan');
}
