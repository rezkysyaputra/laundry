<?php

include("../includes/db_connect.php");

if (isset($_GET['id'])) {
    // ambil id dari parameter GET
    $id = $_GET['id'];

    // buat query hapus
    $sql = "DELETE FROM expense WHERE id=$id";
    $query = mysqli_query($db, $sql);

    // apakah query hapus berhasil?
    if ($query) {
        // Penghapusan berhasil, arahkan kembali ke halaman expenses.php dengan status sukses
        header('Location: ../admin/expenses.php?status=suksesdihapus');
    } else {
        // Penghapusan gagal, arahkan kembali ke halaman expenses.php dengan status gagal
        header('Location: ../admin/expenses.php?status=gagaldihapus');
    }
} else {
    // Jika parameter id tidak diterima, kembalikan pesan akses dilarang
    die("Access denied.");
}
