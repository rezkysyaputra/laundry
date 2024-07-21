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
$sql = "SELECT * FROM expense";
$query = mysqli_query($db, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pengeluaran</title>
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
      <?php
      include_once("../includes/navbar.php");
      ?>
      <main class="content px-3 py-4">
        <div class="container">


          <!-- Message for delete Expense -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'suksesdihapus') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Pengeluaran berhasil di hapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'gagaldihapus') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Pengeluaran gagal di hapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Message Update -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'updateSuccess') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Pengeluaran berhasil di ubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'updateFailed') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Pengeluaran gagal di ubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="h3 fw-bold">Pengeluaran</div>
          <hr />
          <div class="table-responsive pt-2">
            <div class="d-flex justify-content-between mb-3">
              <!-- data-bs-toggle="modal" data-bs-target="#exampleModal" -->
              <a href="formCreateExpense.php"><button type="button" class="btn btn-primary">
                  <span>Tambah baru</span>
                </button></a>
              <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <button class="btn btn-outline-primary" type="submit">Cari</button>
              </form>
            </div>
            <table class="table table-striped table-light text-center">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Total</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include("../includes/db_connect.php");

                // Pagination setup
                $batas = 10;
                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                $previous = $halaman - 1;
                $next = $halaman + 1;

                $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
                $search_query = $search ?
                  "WHERE name LIKE '%$search%' OR quantity LIKE '%$search%' OR price LIKE '%$search%' OR total LIKE '%$search%' OR note LIKE '%$search%'" :
                  '';

                // Get total number of results
                $data = mysqli_query($db, "SELECT * FROM expense $search_query");
                $jumlah_data = mysqli_num_rows($data);
                $total_halaman = ceil($jumlah_data / $batas);

                // Get paginated results
                $queryexpense = mysqli_query($db, "SELECT * FROM expense $search_query LIMIT $halaman_awal, $batas");
                $nomor = $halaman_awal + 1;
                $no = 1;
                while ($expense = mysqli_fetch_array($queryexpense)) {
                  echo "<tr class='align-middle'>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>" . $expense['date'] . "</td>";
                  echo "<td>" . $expense['name'] . "</td>";
                  echo "<td>" . $expense['quantity'] . "</td>";
                  echo "<td>" . $expense['price'] . "</td>";
                  echo "<td>" . $expense['total'] . "</td>";
                  echo "<td class='col-3'>" . $expense['note'] . "</td>";
                  echo "<td class='col-2'>";
                  // echo "<a class='btn btn-warning' href='#' data-id='".$expenses['id']."' role='button'><span><i class='lni lni-pencil'></i></span></a> ";
                  echo "<a class='btn me-2 btn-warning' href='formEditExpense.php?id=" . $expense['id'] . "' role='button'><span><i class='lni lni-pencil'></i></span></a>";
                  echo "<a class='btn btn-danger delete-button' href='#' data-id='" . $expense['id'] . "' onclick='confirmDelete(" . $expense['id'] . ")'><span><i class='lni lni-trash-can'></i></span></a>";
                  echo "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
              <!-- Modal Confirm -->
              <!-- <div class="modal fade" id="confirmModalExpense" tabindex="-1" aria-labelledby="confirmModalExpenseLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">  
                      <h1 class="modal-title fs-5" id="confirmModalExpenseLabel">
                        Delete
                      </h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure to delete Detergent?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        No
                      </button>
                      <a data-id="" type="button" href="#" class="btn btn-primary confirm-delete">
                        Yes
                      </a>
                    </div>
                  </div>
                </div>
              </div> -->
            </table>
            <!-- <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                  <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav> -->
            <nav aria-label="Page navigation example mb-5">
              <ul class="pagination justify-content-end">
                <li class="page-item">
                  <a class="page-link" <?php if ($halaman > 1) {
                                          echo "href='?halaman=$previous&search=$search'";
                                        } ?>>Sebelum</a>
                </li>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                  <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x; ?>&search=<?php echo $search; ?>"><?php echo $x; ?></a></li>
                <?php
                }
                ?>
                <li class="page-item">
                  <a class="page-link" <?php if ($halaman < $total_halaman) {
                                          echo "href='?halaman=$next&search=$search'";
                                        } ?>>Selanjutnya</a>
                </li>
              </ul>
          </div>
        </div>
      </main>
      <?php
      include_once("../includes/footer.php");
      ?>
    </div>
  </div>
  <script>
    function confirmDelete(id) {
      var confirmation = confirm("Are you sure you want to delete this expense?");
      if (confirmation) {
        // Redirect ke halaman deleteExpense.php dengan mengirimkan id
        window.location.href = "../service/deleteExpense.php?id=" + id;
      }
    }

    // Function to remove URL parameters
    function removeURLParameter(param) {
      var url = window.location.href;
      var regex = new RegExp("[\\?&]" + param + "=([^&#]*)");
      var results = regex.exec(url);
      if (results !== null) {
        var newUrl = url.replace(results[0], "");
        history.replaceState(null, null, newUrl);
      }
    }

    // Remove the 'status' parameter after displaying the message
    window.onload = function() {
      removeURLParameter('status');
    }
  </script>
  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>