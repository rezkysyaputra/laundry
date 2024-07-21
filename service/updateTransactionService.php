<?php
include '../includes/db_connect.php';

if (isset($_POST['submit'])) {
  $status = $_POST['status'];
  $transaction_id = $_POST['id'];


  // Update data transaksi
  $sql = "UPDATE transaction SET
            status = '$status'
            WHERE id = $transaction_id";

  $query = mysqli_query($db, $sql);
  if ($query) {
    header('location:../cashier/transaction.php?status=editsuccess');
  } else {
    header('location:../cashier/transaction.php?status=editfailed');
  }
} else {
  echo "Error fetching packet price: " . mysqli_error($db);
}
mysqli_close($db);
