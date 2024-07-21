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

if ($role !== 'Admin') {
  header('location:../index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Paket</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include_once("../includes/sidebarAdmin.php"); ?>

    <!-- Main Content -->
    <div class="main bg-light">
      <?php
      include_once("../includes/navbar.php");
      ?>
      <main class="content px-3 py-4">
        <div class="container">
          <!-- Message for create Customer  -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successCreate') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Paket telah berhasil ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedCreate') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Paket gagal ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['status']) && $_GET['status'] == 'successEdit') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Paket telah berhasil di Edit!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedEdit') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Paket gagal diEdit!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- massage data already added -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedadd') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Gagal menambahkan Paket yang sudah ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> <?php endif; ?>

          <!-- Message for delete customer -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successDelete') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              berhasil menghapus Paket!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedDelete') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              gagal menghapus Paket!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <div class="h3 fw-bold">Paket</div>
          <hr />
          <div class="table-responsive pt-2">
            <div class="d-flex justify-content-between mb-3">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <span>Buat baru</span>
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form action="../service/createPacket.php" method="POST">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                          Form Paket
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <div class="mb-3">
                          <div class="row">
                            <input type="number" class="form-control" value="<?php echo $user_id ?>" name="user_id" hidden>
                            <div class="col-6 pb-3">
                              <label for="exampleFormControlInput1" class="form-label">Nama</label>
                              <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Nama Paket..." required />
                            </div>

                            <div class="col-6 pb-3">
                              <label for="exampleDataList" class="form-label">Estimasi</label>
                              <input class="form-control" name="estimation" id="exampleDataList" type="text" placeholder="Contoh: - Hari..." required />
                            </div>

                            <div class="col-6 pb-3">
                              <label for="exampleDataList" class="form-label">Harga/KG</label>
                              <input class="form-control" name="price" id="exampleDataList" placeholder="harga Paket..." rows="3" required></input>
                            </div>

                            <div class="col-6 pb-3 mb-3">
                              <label for="keterangan" class="form-label">Keterangan</label>
                              <textarea class="form-control" name="Keterangan" placeholder="deskripsi Paket..." rows="3"></textarea>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                          Simpan
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <button class="btn btn-outline-primary" type="submit">Cari</button>
              </form>
            </div>
            <table class="table table-striped table-light text-center">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Nama Paket</th>
                  <th scope="col">Estimasi</th>
                  <th scope="col">Harga/KG</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php


                // Pagination setup
                $batas = 10;
                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                $previous = $halaman - 1;
                $next = $halaman + 1;

                $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
                $search_query = $search ?
                  "WHERE is_deleted = false AND (name LIKE '%$search%' OR estimation LIKE '%$search%' OR price LIKE '%$search%' OR description LIKE '%$search%')" :
                  'WHERE is_deleted = false';

                // Get total number of results
                $data = mysqli_query($db, "SELECT * FROM packet $search_query");
                $jumlah_data = mysqli_num_rows($data);
                $total_halaman = ceil($jumlah_data / $batas);

                // Get paginated results
                $queryPacket = mysqli_query($db, "SELECT * FROM packet $search_query LIMIT $halaman_awal, $batas");
                $nomor = $halaman_awal + 1;
                $no = 1;
                while ($packet = mysqli_fetch_array($queryPacket)) {
                  echo "<tr class='align-middle'>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>" . $packet['name'] . "</td>";
                  echo "<td>" . $packet['estimation'] . "</td>";
                  echo "<td>" . $packet['price'] . "</td>";
                  echo "<td class='col-4 text-start'>" . $packet['description'] . "</td>";
                  echo "<td class='col-2'>";
                  echo "<a class='btn me-2 btn-warning' href='FormEditPacket.php?id=" . $packet['id'] . "' role='button'><span><i class='lni lni-pencil'></i></span></a>";
                  echo "<a class='btn btn-danger delete-button' href='#' data-id='" . $packet['id'] . "' onclick='confirmDelete(" . $packet['id'] . ")'><span><i class='lni lni-trash-can'></i></span></a>";
                  echo "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
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
            </nav>
          </div>
        </div>
        <?php
        include_once("../includes/footer.php");
        ?>
      </main>
    </div>
  </div>
  <script>
    function confirmDelete(id) {
      var confirmation = confirm("Apakah Anda yakin ingin menghapus paket ini?");
      if (confirmation) {
        // Redirect ke halaman deleteExpense.php dengan mengirimkan id
        window.location.href = "../service/deletePacket.php?id=" + id;
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