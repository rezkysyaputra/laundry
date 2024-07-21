<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
  header('Location: ../index.php');
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

if ($role !== 'Kasir') {
  header('location:../index.php');
  exit();
}

include '../includes/db_connect.php';

if (!isset($_GET['id'])) {
  header('Location: ../pages/customer.php'); // Redirect jika ID tidak tersedia
  exit();
}

$customerId = $_GET['id'];

$getCustomer = "SELECT * FROM customer WHERE id = $customerId";
$queryCustomer = mysqli_query($db, $getCustomer);

if (!$queryCustomer) {
  echo "Error: " . mysqli_error($db);
  exit();
}

$customer = mysqli_fetch_assoc($queryCustomer);

if (!$customer) {
  echo "Customer not found";
  exit();
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pelanggan</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <!-- Masukkan stylesheet tambahan jika diperlukan -->
</head>

<body>
  <div class="container mt-4">
    <h3>Edit Pelanggan</h3>
    <hr>
    <form action="../service/editCustomer.php" method="post">
      <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">

      <div class="mb-3">
        <label for="nameInput" class="form-label">Nama Pelanggan</label>
        <input type="text" class="form-control" id="nameInput" name="name" value="<?php echo $customer['name']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="gender">Jenis Kelamin:</label>
        <select class="form-select mt-2" name="gender" id="gender">
          <option value="Laki-Laki">Laki-Laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="phoneInput" class="form-label">Nomor Handphone</label>
        <input type="number" class="form-control" id="phoneInput" name="phone_number" value="<?php echo $customer['phone_number']; ?>" required>
      </div>

      <div class="col-6 pb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control" name="address" id="address" placeholder="Alamat Pelanggan..." rows="3" required><?php echo $customer['address']; ?></textarea>
      </div>

      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        <a href="../pages/customer.php" class="btn btn-secondary ms-2">Batal</a>
      </div>
    </form>
  </div>

  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>

</body>

</html>