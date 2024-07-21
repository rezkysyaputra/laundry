<?php

include "../includes/db_connect.php";

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        header("Location: ../resetPassword.php?username=$username&error=nomatch");
        exit();
    }

    // Update password pengguna
    // $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = $db->prepare("UPDATE user SET password = ? WHERE username = ?");
    $sql->bind_param("ss", $new_password, $username);
    $sql->execute();

    header("Location: ../index.php?success=reset");

    $sql->close();
    $db->close();
}
