<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
  header('Location: ../index.php');
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

if ($role !== "Admin") {
  header('location:../index.php');
  exit();
}
include("../includes/db_connect.php");

// Initialize variables to 0
$totalPacket = $totalCustomer = $totalTransaction = $totalIncome = $totalExpense = $totalCashier = 0;

// Queries
$sqlPacket = "SELECT COUNT(id) as total_packet FROM packet WHERE is_deleted = false";
$sqlCustomer = "SELECT COUNT(id) as total_customer FROM customer WHERE is_deleted = false";
$sqlTransaction = "SELECT COUNT(id) as total_transaction FROM transaction";
$sqlTotalIncome = "SELECT SUM(amount) AS total_income
                  FROM transaction
                  WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$sqlTotalExpense = "SELECT SUM(price * quantity) AS total_expense
                  FROM expense
                  WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$sqlTotalCashier = "SELECT COUNT(id) as total_cashier FROM user WHERE role = 'Kasir' AND is_deleted = 0";

// Execute queries and fetch results
$queries = [$sqlPacket, $sqlCustomer, $sqlTransaction, $sqlTotalIncome, $sqlTotalExpense, $sqlTotalCashier];
$results = [];

foreach ($queries as $query) {
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  $results[] = $row;
}

list($totalPacket, $totalCustomer, $totalTransaction, $totalIncome, $totalExpense, $totalCashier) = array_map(function ($row) {
  return isset($row) ? array_values($row)[0] : 0;
}, $results);

// Format income and expense as Rupiah
$totalIncomeFormatted = "Rp " . number_format($totalIncome, 0, ',', '.');
$totalExpenseFormatted = "Rp " . number_format($totalExpense, 0, ',', '.');
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
    <?php include_once("../includes/sidebarAdmin.php"); ?>

    <!-- Main Content -->
    <div class="main bg-light">
      <!-- Navbar Content -->
      <?php include_once("../includes/navbar.php"); ?>
      <main class="content container px-3 py-4">
        <div class="mb-4">
          <div class="h3 fw-bold ">Dashboard</div>
          <hr />
        </div>
        <div class="row">
          <div class="col-sm-3">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h2 class="card-text fw-bold"><?php echo $totalCashier ?></h2>
                  <img src="../assets/img/cashier.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Total Kasir</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h2 class="card-text fw-bold"><?php echo $totalCustomer ?></h2>
                  <img src="../assets/img/customer.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Total Pelanggan</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <h2 class="card-text fw-bold"><?php echo $totalPacket ?></h2>
                  <img src="../assets/img/packet.png" alt="" height="50pxs" />
                </div>
                <p class="card-title fw-bold">Total Paket</p>
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
                <p class="card-title fw-bold">Total Transaksi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <div class="d-flex">
                    <img src="../assets/img/loss_dollar.png" alt="" height="40" />
                    <h2 class="card-text fw-bold ms-2"><?php echo $totalExpenseFormatted ?></h2>
                  </div>
                  <img src="../assets/img/expense.png" alt="" height="70pxs" />
                </div>
                <p class="card-title fw-bold">Total Pengeluaran</p>
                <p class="small align-items-center text-secondary align-items-end">
                  Bulan ini
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card shadow-sm">
              <div class="card-body m-2">
                <div class="d-flex justify-content-between">
                  <div class="d-flex">
                    <img src="../assets/img/profit_arrow.png" alt="" height="40" />
                    <h2 class="card-text fw-bold ms-2"><?php echo $totalIncomeFormatted ?></h2>
                  </div>
                  <img src="../assets/img/total_transactions.png" alt="" height="70px" />
                </div>
                <p class="card-title fw-bold">Total Pendapatan</p>
                <p class="small align-items-center text-secondary align-items-end">
                  Bulan ini
                </p>
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