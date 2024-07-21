<?php
include("../includes/db_connect.php");

if (isset($_GET['id'])) {
    // Get the id from the URL parameter
    $id = intval($_GET['id']); // Ensure $id is an integer

    // Begin transaction to ensure all queries either succeed or fail together
    mysqli_begin_transaction($db);

    try {
        // Delete the cashier record
        $deleteSql = "UPDATE user SET is_deleted = true WHERE id=?";
        $stmt = mysqli_prepare($db, $deleteSql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Check if deletion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Commit the transaction if everything was successful
            mysqli_commit($db);
            // Redirect back to cashier.php with success status
            header('Location: ../admin/cashier.php?status=successDelete');
        } else {
            // Rollback the transaction if deletion failed
            mysqli_rollback($db);
            // Redirect back to cashier.php with failure status
            header('Location: ../admin/cashier.php?status=failedDelete');
        }

        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        // Rollback the transaction on exception
        mysqli_rollback($db);
        // Redirect back to cashier.php with failure status
        header('Location: ../admin/cashier.php?status=failedDelete');
    }

    mysqli_close($db);
} else {
    // If id parameter is not received, deny access
    die("Access denied.");
}
