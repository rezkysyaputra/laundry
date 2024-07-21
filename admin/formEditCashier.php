<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

if ($role !== 'Admin') {
    header('location:../index.php');
    exit();
}

include '../includes/db_connect.php';

// Cek apakah ada parameter id yang dikirimkan melalui GET
if (!isset($_GET['id'])) {
    header('Location: ../pages/cashier.php'); // Redirect jika ID tidak tersedia
    exit();
}

$id = $_GET['id'];

// Query untuk mengambil data kasir berdasarkan id
$getCashier = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($db, $getCashier);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$queryCashier = mysqli_stmt_get_result($stmt);

// Ambil hasil query
$cashier = mysqli_fetch_assoc($queryCashier);

// Jika tidak ada hasil dari query, keluarkan pesan error
if (!$cashier) {
    echo "Cashier not found";
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>
    <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- Masukkan stylesheet tambahan jika diperlukan -->
</head>

<body>
    <div class="container mt-4">
        <h3>Edit Kasir</h3>
        <hr>
        <form action="../service/updateCashier.php" method="post">
            <input type="hidden" name="id" value="<?php echo $cashier['id']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Nama Akun</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($cashier['username']); ?>" required readonly>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full_name" value="<?php echo htmlspecialchars($cashier['full_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($cashier['password']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Laki-laki" <?php if ($cashier['gender'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($cashier['gender'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Nomor Handphone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" value="<?php echo htmlspecialchars($cashier['phone_number']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address" required><?php echo htmlspecialchars($cashier['address']); ?></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                <a href="cashier.php" class="btn btn-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>

    <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>