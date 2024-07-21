<?php
include "../includes/db_connect.php";

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sqlDelete = "delete from transaction where id =$id";
  $resultDelete = mysqli_query($db, $sqlDelete);

  if ($resultDelete) {
    header('location:../cashier/transaction.php?status=deletesuccess');
    exit();
  } else {
    header('location:../cashier/transaction.php?status=deletefailed');
    exit();
  }
}
