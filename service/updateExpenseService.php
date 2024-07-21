<?php
include '../includes/db_connect.php';

if (isset($_POST['submit'])) {

  $expense_id = $_POST['id'];
  $date = $_POST['date'];
  $name = $_POST['name'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $note = $_POST['note'];

  $total = $price * $quantity;


  $sql = "UPDATE expense SET
            date = '$date', 
            name = '$name', 
            quantity = $quantity, 
            price = $price, 
            total = $total,
            note = '$note'  
            WHERE id = $expense_id";

  $query = mysqli_query($db, $sql);
  if ($query) {
    header('location:../admin/expenses.php?status=updateSuccess');
  } else {
    header('location:../admin/expenses.php?status=updateFailed');
  }
} else {
  echo "Error fetching packet price: " . mysqli_error($db);
}

mysqli_close($db);
