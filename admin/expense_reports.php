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

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page > 1) ? ($page * $limit) - $limit : 0;

$previous = $page - 1;
$next = $page + 1;

$search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
$month = isset($_GET['month']) ? (int)$_GET['month'] : '';
$year = isset($_GET['year']) ? (int)$_GET['year'] : '';

$search_query = "WHERE 1=1";
if ($search) {
  $search_query .= " AND name LIKE '%$search%'";
}
if ($month && $year) {
  $search_query .= " AND MONTH(created_at) = $month AND YEAR(created_at) = $year";
} elseif ($year) {
  $search_query .= " AND YEAR(created_at) = $year";
}

// Get total number of results
$data = mysqli_query($db, "SELECT * FROM expense $search_query");
$total_records = mysqli_num_rows($data);
$total_pages = ceil($total_records / $limit);

// Get paginated results
$queryReportsExpense = mysqli_query($db, "SELECT * FROM expense $search_query LIMIT $offset, $limit");
$no = $offset + 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan Pengeluaran</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include_once("../includes/sidebarAdmin.php"); ?>
    <!-- Main Content -->
    <div class="main">
      <?php include_once("../includes/navbar.php"); ?>
      <main class="content px-3 py-4">
        <div class="container">
          <div class="h3 fw-bold">Laporan Pengeluaran</div>
          <hr />
          <div class="table-responsive pt-2">
            <div class="d-flex justify-content-between mb-3">
              <button type="button" class="btn btn-success" onclick="window.location.href='../service/expenseExcelReports.php?search=<?php echo $search; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>'">
                <span>Ekspor</span>
              </button>

              <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <select class="form-control me-2" name="month">
                  <option value="">Pilih Bulan</option>
                  <?php for ($m = 1; $m <= 12; $m++) : ?>
                    <option value="<?php echo $m; ?>" <?php if ($month == $m) echo 'selected'; ?>>
                      <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                    </option>
                  <?php endfor; ?>
                </select>
                <select class="form-control me-2" name="year">
                  <option value="">Pilih Tahun</option>
                  <?php for ($y = 2000; $y <= date('Y'); $y++) : ?>
                    <option value="<?php echo $y; ?>" <?php if ($year == $y) echo 'selected'; ?>>
                      <?php echo $y; ?>
                    </option>
                  <?php endfor; ?>
                </select>
                <button class="btn btn-outline-primary" type="submit">Cari</button>
              </form>
            </div>
            <table class="table table-striped table-light text-center">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Tanggal Pembelian</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Jumlah Barang</th>
                  <th scope="col">Harga Barang</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($expenseReport = mysqli_fetch_array($queryReportsExpense)) {
                  echo "<tr class='align-middle'>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>" . $expenseReport['created_at'] . "</td>";
                  echo "<td>" . $expenseReport['name'] . "</td>";
                  echo "<td>" . $expenseReport['quantity'] . "</td>";

                  // Format harga barang and total
                  $harga_barang_formatted = "Rp " . number_format($expenseReport['price'], 0, ',', '.');
                  $total_formatted = "Rp " . number_format($expenseReport['total'], 0, ',', '.');

                  echo "<td>" . $harga_barang_formatted . "</td>";
                  echo "<td>" . $total_formatted . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                  <a class="page-link" <?php if ($page > 1) echo "href='?page=$previous&search=$search&month=$month&year=$year'"; ?>>Sebelum</a>
                </li>
                <?php
                for ($x = 1; $x <= $total_pages; $x++) {
                  echo "<li class='page-item'><a class='page-link' href='?page=$x&search=$search&month=$month&year=$year'>$x</a></li>";
                }
                ?>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                  <a class="page-link" <?php if ($page < $total_pages) echo "href='?page=$next&search=$search&month=$month&year=$year'"; ?>>Selanjutnya</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </main>
      <?php include_once("../includes/footer.php"); ?>
    </div>
  </div>
  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>