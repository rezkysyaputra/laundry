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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengeluaran</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">

</head>

<body>
  <div class="container mt-4">
    <h3>Edit Pengeluaran</h3>
    <hr>
    <?php
    include '../includes/db_connect.php';

    if (!isset($_GET['id'])) {
      header('Location: ../pages/transaction.php'); // Redirect jika ID tidak tersedia
      exit();
    }

    $expenseId = $_GET['id'];
    $getExpense = "SELECT * FROM expense WHERE id = $expenseId";

    $queryExpense = mysqli_query($db, $getExpense);

    if (!$queryExpense) {
      echo "Error: " . mysqli_error($db);
      exit();
    }

    $expense = mysqli_fetch_assoc($queryExpense);

    if (!$expense) {
      echo "expense not found";
      exit();
    }

    ?>
    <form action="../service/updateExpenseService.php" method="post">
      <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
      <div class="mb-3">
        <label for="name" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo $expense['date']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $expense['name']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Jumlah</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $expense['quantity']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input type="number" class="form-control" id="price" name="price" value="<?php echo $expense['price']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Keterangan</label>
        <input type="text" class="form-control" id="note" name="note" value="<?php echo $expense['note']; ?>" required>
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