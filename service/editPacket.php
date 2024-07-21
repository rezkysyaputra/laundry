<?php
include '../includes/db_connect.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $estimation = $_POST['estimation'];
    $price = $_POST['price'];
    $keterangan = $_POST['Keterangan'];

    // Update data paket
    $sql = "UPDATE packet SET 
            name = '$name', 
            estimation = '$estimation', 
            price = $price, description = '$keterangan'
            WHERE id = $id";

    $query = mysqli_query($db, $sql);

    if ($query) {
        header('Location: ../admin/packets.php?status=successEdit');
        exit();
    } else {
        echo "Error updating packet: " . mysqli_error($db);
    }

    mysqli_close($db);
} else {
    header('Location: ../admin/packets.php?status=failedEdit'); // Redirect jika tidak ada data yang dikirimkan
    exit();
}
