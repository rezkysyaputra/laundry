<?php
include "../includes/db_connect.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $security_answer = $_POST['security_answer'];

    // Cek apakah jawaban keamanan benar dan ambil role pengguna
    $sql = $db->prepare("SELECT id, role FROM user WHERE username = ? AND security_answer = ?");
    $sql->bind_param("ss", $username, $security_answer);
    $sql->execute();
    $sql->store_result();

    if ($sql->num_rows > 0) {
        $sql->bind_result($user_id, $role);
        $sql->fetch();

        // Redirect ke halaman reset password dengan menyertakan username, role, dan pertanyaan keamanan
        header("Location: ../resetPassword.php?username=$username&role=$role");
    } else {
        // Jika jawaban keamanan salah, kembalikan ke halaman jawaban pertanyaan keamanan dengan pesan error
        header("Location: ../answerSecurityQuestion.php?username=$username&question=" . urlencode($_POST['security_question']) . "&error=incorrect");
    }

    $sql->close();
    $db->close();
}

