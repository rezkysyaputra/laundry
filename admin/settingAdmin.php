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

$query = "SELECT * FROM user WHERE id = $user_id";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
} else {
  // Handle the error if no user is found
  header('Location: ../index.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Admin</title>
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
      <?php include_once("../includes/navbar.php"); ?>
      <main class="content px-3">
        <div class="container">
          <div class="h3 fw-bold">Pengaturan</div>
          <hr />
          <!-- Pesan untuk update berhasil -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'successUpdate') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Profil berhasil diperbarui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <!-- Pesan untuk update gagal -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'wrongPassword') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Gagal memperbarui Profil. Pastikan password lama benar jika Anda mengubah password!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <div class="container bg-body-secondary">
            <form class="p-3" action="../service/changeProfileAdmin.php" method="post">
              <input type="hidden" name="id" value="<?php echo $user_id; ?>">
              <div class="form-group mb-3">
                <label for="username" class="form-label">Nama Akun</label>
                <input required type="text" class="form-control" id="username" name="username" placeholder="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
              </div>
              <div class="form-group mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input required type="text" class="form-control" id="full_name" name="full_name" placeholder="nama lengkap..." value="<?php echo htmlspecialchars($user['full_name']); ?>">
              </div>
              <div class="row mb-3">
                <div class="form-group col-md-6">
                  <label for="phone_number" class="form-label">Nomor Handphone</label>
                  <input required type="number" class="form-control" name="phone_number" placeholder="62852XXX" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                </div>
                <div class="form-group col-md-6">
                  <label for="gender" class="form-label">Jenis Kelamin</label>
                  <select required class="form-select" aria-label="Default select example" name="gender">
                    <option value="">Jenis Kelamin</option>
                    <option value="Laki-laki" <?php echo $user['gender'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo $user['gender'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea required class="form-control" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
              </div>
              <h5 class="py-4 fw-bold">Keamanan Lupa Kata Sandi</h5>
              <div class="form-group mb-3">
                <div class="row mb-3">
                  <div class="form-group col-md-6">
                    <label for="security_question" class="form-label">Pertanyaan Keamanan</label>
                    <input required type="text" class="form-control" name="security_question" value="<?php echo htmlspecialchars($user['security_question']); ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="security_answer" class="form-label">Jawaban Keamanan</label>
                    <input required type="text" class="form-control" name="security_answer" value="<?php echo htmlspecialchars($user['security_answer']); ?>">
                  </div>
                  <h5 class="py-4 fw-bold">Ubah Password</h5>
                  <div class="form-group mb-3">
                    <label for="old_password" class="form-label">Password Lama</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="">
                  </div>
                  <div class="form-group mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="">
                  </div>
                  <div class="d-flex justify-content-end">
                    <button type="submit" name="submit" class="btn btn-warning me-3">Simpan</button>
                    <a href="settingAdmin.php" type="menu" class="btn btn-primary">Batal</a>
                  </div>
            </form>
          </div>
        </div>
      </main>
      <?php include_once("../includes/footer.php"); ?>
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