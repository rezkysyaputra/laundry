<?php
include("../includes/db_connect.php");
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


// Initialize variables to 0
$totalCustomer = $totalTransaction = $totalIncome = 0;

// Queries
$sqlCustomer = "SELECT COUNT(id) as total_customer FROM customer WHERE is_deleted = false AND user_id = $user_id";
$sqlTransaction = "SELECT COUNT(id) as total_transaction FROM transaction WHERE user_id = $user_id";
$sqlTotalIncome = "SELECT SUM(amount) AS total_income FROM transaction WHERE user_id = $user_id";

// Execute queries and fetch results
$queries = [$sqlCustomer, $sqlTransaction, $sqlTotalIncome];
$results = [];

foreach ($queries as $query) {
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  $results[] = $row;
}

list($totalCustomer, $totalTransaction, $totalIncome) = array_map(function ($row) {
  return isset($row) ? array_values($row)[0] : 0;
}, $results);

// Format income as Rupiah
$totalIncomeFormatted = "Rp " . number_format($totalIncome, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include_once("../includes/sidebarCashier.php"); ?>

    <!-- Main Content -->
    <div class="main bg-light">
      <!-- Navbar Content -->
      <?php include_once("../includes/navbar.php"); ?>
      <main class="content container px-3 py-4">
        <div class=" mb-4">
          <div class="h3 fw-bold ">Dashboard</div>
          <hr />
        </div>
        <div class="row">
          <div class="col-sm-3">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h2 class="card-text fw-bold"><?php echo $totalCustomer ?></h2>
                  <img src="../assets/img/customer.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Pelanggan Kamu</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h2 class="card-text fw-bold"><?php echo $totalTransaction ?></h2>
                  <img src="../assets/img/transaction.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Transaksi Kamu</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h3 class="card-text fw-bold"><?php echo $totalIncomeFormatted ?></h3>
                  <img src="../assets/img/total_transactions.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Pendapatan Kamu</p>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- Footer Content -->
      <?php include_once("../includes/footer.php"); ?>
    </div>
  </div>
  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>