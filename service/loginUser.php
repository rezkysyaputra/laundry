<?php
// Start the session
session_start();

// Include the database connection file
include '../includes/db_connect.php';

// Capture data from the form
$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$role = mysqli_real_escape_string($db, $_POST['role']);

// Select user data with matching username and password
$data = mysqli_query($db, "SELECT * FROM user WHERE is_deleted = false AND username='$username' AND password='$password' AND role='$role'");

// Count the number of matching records
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    // Fetch user data
    $user = mysqli_fetch_assoc($data);

    // Store user data in session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] == 'Admin') {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Sukses',
                    text: 'Selamat datang kembali, $username!',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../admin/dashboard.php';
                });
            }
          </script>";
    } else if ($user['role'] == 'Kasir') {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Sukses',
                    text: 'Selamat datang kembali, $username!',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../cashier/transaction.php';
                });
            }
          </script>";
    }
} else {
    header('Location: ../index.php?error=invalid'); // Redirect if no matching data is found
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
</body>

</html>