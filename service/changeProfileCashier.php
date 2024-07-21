<?php
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve and sanitize input data
  $id = $_POST['id'];
  $full_name = $_POST['full_name'];
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $gender = $_POST['gender'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];

  // Base SQL query
  $sql = "UPDATE user SET full_name = ?, gender = ?, phone_number = ?, address = ? WHERE id = ?";
  $params = [$full_name, $gender, $phone_number, $address, $id];
  $types = "ssssi";

  // Check if password fields are filled
  if (!empty($old_password) && !empty($new_password)) {
    // Fetch current password from database
    $query = "SELECT password FROM user WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $current_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Check if old password matches the current password
    if ($old_password == $current_password) {
      // Update SQL query to include the new password
      $sql = "UPDATE user SET full_name = ?, password = ?, gender = ?, phone_number = ?, address = ? WHERE id = ?";
      $params = [$full_name, $new_password, $gender, $phone_number, $address, $id];
      $types = "sssssi";
    } else {
      // Redirect back to settingCashier.php with failure status if old password does not match
      header("Location: ../cashier/settingCashier.php?status=wrongPassword");
      exit;
    }
  }

  // Prepare the SQL statement
  $stmt = mysqli_prepare($db, $sql);
  if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
      // Redirect back to settingCashier.php with success status
      header("Location: ../cashier/settingCashier.php?status=successUpdate");
      exit;
    } else {
      // Redirect back to settingCashier.php with failure status
      header("Location: ../cashier/settingCashier.php?status=failedUpdate");
      exit;
    }
  } else {
    // Redirect back to settingCashier.php with failure status
    header("Location: ../cashier/settingCashier.php?status=failedUpdate");
    exit;
  }
} else {
  // Redirect to settingCashier.php if the form was not submitted properly
  header("Location: ../cashier/settingCashier.php");
  exit;
}
