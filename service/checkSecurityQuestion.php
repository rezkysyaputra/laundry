<?php

include "../includes/db_connect.php";

if (isset($_POST['submit'])){
    $username = $_POST['username'];

    // Koneksi ke databas
    // Cek koneks
    // Cek apakah pengguna ada di database
    $sql = $db->prepare("SELECT security_question FROM user WHERE username = ? and role ='admin'");
    if ($sql) {
        $sql->bind_param("s", $username);
        $sql->execute();
        $sql->store_result();

        if ($sql->num_rows > 0) {
            $sql->bind_result($security_question);
            $sql->fetch();

            // Redirect ke halaman jawaban pertanyaan keamanan
            header("Location: ../answerSecurityQuestion.php?username=" . urlencode($username) . "&question=" . urlencode($security_question));
        } else {
            header("Location: ../forgotPassword.php?error=notfound");
        }

        $sql->close();
    } else {
        // Error dalam persiapan pernyataan
        echo "Error: " . $db->error;
    }

    $db->close();
} else {
    echo "Invalid request method";
}

