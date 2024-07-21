<?php
// Start the session
session_start();

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Logout Successful',
                text: 'You have been logged out.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = '../index.php';
            });
        }
    </script>
</body>
</html>
