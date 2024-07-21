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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pengeluaran</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">

</head>

<body>
  <div class="container mt-4">
    <h3>Tambah Pengeluaran</h3>
    <hr>

    <!-- Message Create -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'suksesditambahkan') : ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Pengeluaran berhasil di tambah!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'gagalditambahkan') : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Pengeluaran gagal di tambah!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="../service/createExpense.php" method="post">
      <input type="number" class="form-control" value="<?php echo $user_id ?>" name="user_id" hidden>
      <input type="hidden" name="id" value="text">
      <div class="mb-3">
        <label for="name" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="date" name="date" value="date" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="text" required>
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Jumlah</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="number" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input type="number" class="form-control" id="price" name="price" value="date" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Keterangan</label>
        <textarea class="form-control" id="note" name="note" value="text" rows="4" cols="40" required></textarea>
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        <a type="button" href="expenses.php" class="btn btn-secondary ms-2" name="submit">Batal</a>
      </div>
    </form>
  </div>

  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>

</body>

</html>