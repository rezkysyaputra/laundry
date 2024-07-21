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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = '';
$search_param = [];
if (!empty($search)) {
  $search_query = "AND (username LIKE ? OR role LIKE ?)";
  $search_param[] = "%$search%";
  $search_param[] = "%$search%";
}

// Get total number of results z
$data_query = "SELECT * FROM user WHERE role = 'kasir' $search_query";
$data_stmt = mysqli_prepare($db, $data_query);
if (!empty($search_query)) {
  mysqli_stmt_bind_param($data_stmt, str_repeat('s', count($search_param)), ...$search_param);
}
mysqli_stmt_execute($data_stmt);
$data_result = mysqli_stmt_get_result($data_stmt);
$total_records = mysqli_num_rows($data_result);
$total_pages = ceil($total_records / $limit);
mysqli_stmt_close($data_stmt);

// Get paginated results
$query = "SELECT * FROM user WHERE role = 'kasir' AND is_deleted = false $search_query LIMIT ?, ?";
$stmt = mysqli_prepare($db, $query);
if (!empty($search_query)) {
  $search_param[] = $offset;
  $search_param[] = $limit;
  mysqli_stmt_bind_param($stmt, str_repeat('s', count($search_param) - 2) . 'ii', ...$search_param);
} else {
  mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$no = $offset + 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kasir</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
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

          <!-- message create -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successCreate') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Kasir berhasil ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedCreate') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kasir gagal ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Message already exists -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'phonealreadyexist') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kasir gagal ditambahkan, kontak sudah terdaftar!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'namealreadyexist') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kasir gagal ditambahkan, nama sudah terdaftar!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- message update -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successUpdate') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Kasir berhasil diubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedUpdate') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kasir gagal diubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- message delete -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successDelete') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Kasir berhasil dihapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failedDelete') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kasir gagal dihapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="h3 fw-bold">Kasir</div>
          <hr />
          <div class="table-responsive pt-2">
            <div class="d-flex justify-content-between mb-3">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
                <span>Tambah</span>
              </button>

              <!-- Modal form -->
              <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="modalFormLabel">
                        Form Kasir
                      </h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="../service/createCashier.php" method="POST">
                        <div class="mb-3">
                          <label for="username" class="form-label">Nama Akun</label>
                          <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                          <label for="full_name" class="form-label">Nama Lengkap</label>
                          <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                          <label for="gender" class="form-label">Jenis Kelamin</label>
                          <select class="form-select" id="gender" name="gender" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="phone_number" class="form-label">Nomor Handphone</label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="6285XXX" required>
                        </div>
                        <div class="mb-3">
                          <label for="district" class="form-label">Kecamatan</label>
                          <input type="text" class="form-control" id="district" name="district" required>
                        </div>
                        <div class="mb-3">
                          <label for="street" class="form-label">Jalan</label>
                          <input type="text" class="form-control" id="street" name="street" required>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Search Form -->
              <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <button class="btn btn-outline-primary" type="submit">Cari</button>
              </form>
            </div>

            <!-- Cashier Table -->
            <table class="table table-striped table-light text-center">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Nama Akun</th>
                  <th scope="col">Nama Lengkap</th>
                  <th scope="col">Password</th>
                  <th scope="col">Jenis Kelamin</th>
                  <th scope="col">Nomor Handphone</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr class='align-middle'>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                  echo "<td>" . $row['gender'] . "</td>";
                  echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                  echo "<td class='col-3 text-start'>" . htmlspecialchars($row['address']) . "</td>";
                  echo "<td>
                        <a class='btn btn-warning' href='formEditCashier.php?id=" . $row['id'] . "'><span><i class='lni lni-pencil'></i></span></a>
                        <a class='btn btn-danger' href='../service/deleteCashier.php?id=" . $row['id'] . "' role='button' onclick='return confirm(\"Apakah anda yakin untuk menghapus akun ini?\")'><span><i class='lni lni-trash-can'></i></span></a>
                      </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

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