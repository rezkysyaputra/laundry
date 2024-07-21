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
  header('Location: ../index.php');
  exit();
}

include '../includes/db_connect.php';

if (!isset($_GET['id'])) {
  header('Location: ../pages/packets.php'); // Redirect jika ID tidak tersedia
  exit();
}

$packetId = $_GET['id'];

$getPacket = "SELECT * FROM packet WHERE id = $packetId";
$queryPacket = mysqli_query($db, $getPacket);

if (!$queryPacket) {
  echo "Error: " . mysqli_error($db);
  exit();
}

$packet = mysqli_fetch_assoc($queryPacket);

if (!$packet) {
  echo "Packet not found";
  exit();
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Paket</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <!-- Masukkan stylesheet tambahan jika diperlukan -->
</head>

<body>
  <div class="container mt-4">
    <h3>Edit Paket</h3>
    <hr>
    <form action="../service/editPacket.php" method="post">
      <input type="hidden" name="id" value="<?php echo $packet['id']; ?>">

      <div class="mb-3">
        <label for="nameInput" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nameInput" name="name" value="<?php echo $packet['name']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="estimationInput" class="form-label">Estimasi</label>
        <input type="text" class="form-control" id="estimationInput" name="estimation" value="<?php echo $packet['estimation']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="priceInput" class="form-label">Harga</label>
        <input type="number" class="form-control" id="priceInput" name="price" value="<?php echo $packet['price']; ?>" required>
      </div>

      <div class="col-6 pb-3 mb-3">
        <label for="exampleDataList" class="form-label">Keterangan</label>
        <textarea class="form-control" name="Keterangan" id="exampleDataList" placeholder="deskripsi paket..." rows="3"><?php echo $packet['description']; ?></textarea>
      </div>

      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        <a href="packets.php" class="btn btn-secondary ms-2">Batal</a>
      </div>
    </form>
  </div>

  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>

</body>

</html>