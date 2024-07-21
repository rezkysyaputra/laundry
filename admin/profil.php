<?php
include '../includes/db_connect.php';

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


// Query to get profile data
$sql = "SELECT * FROM profil_company WHERE id = 1";
$result = $db->query($sql);
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Laundry</title>
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
          <div class="h3 fw-bold">Profil Laundry</div>
          <hr />
          <!-- Pesan untuk update berhasil -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Profil Laundry berhasil diperbarui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <!-- Pesan untuk update gagal -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'failed') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Gagal memperbarui Profil Laundry!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <div class="container bg-body-secondary">
            <form class="p-3" action="../service/changeProfileLaundry.php" method="post" enctype="multipart/form-data">
              <h5 class="py-4 fw-bold">Tentang</h5>
              <div class="form-group mb-3">
                <label for="name" class="form-label">Nama Laundry</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($profile['name_company']); ?>" placeholder="name">
              </div>
              <div class="row mb-3">
                <div class="form-group col-md-6">
                  <label for="formFile" class="form-label">Gambar Banner</label>
                  <input class="form-control" type="file" name="banner" id="formFile">
                </div>
                <div class="form-group col-md-6">
                  <label for="formFile" class="form-label">Gambar Tentang</label>
                  <input class="form-control" type="file" name="about_img" id="formFile">
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="about" class="form-label">Tentang laundry</label>
                <textarea class="form-control" name="about" rows="5"><?php echo htmlspecialchars($profile['about']); ?></textarea>
              </div>
              <div class="form-group mb-3">
                <label for="vision" class="form-label">Visi</label>
                <textarea class="form-control" name="vision" rows="5"><?php echo htmlspecialchars($profile['vision']); ?></textarea>
              </div>
              <div class="form-group mb-3">
                <label for="mission" class="form-label">Misi</label>
                <textarea class="form-control" name="mission" rows="5"><?php echo htmlspecialchars($profile['mission']); ?></textarea>
              </div>
              <div class="row mb-3">
                <div class="form-group col-md-6">
                  <label for="phone_number" class="form-label">Nomor Handphone</label>
                  <input type="number" class="form-control" name="phone_number" value="<?php echo htmlspecialchars($profile['phone_number']); ?>" placeholder="62852XXX">
                </div>
                <div class="form-group col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" placeholder="contoh.gmail.com">
                </div>
              </div>
              <hr class="my-4">
              <h5 class="pb-4 fw-bold">Alamat</h5>
              <div class="row mb-3">
                <div class="form-group col-md-5">
                  <label for="city" class="form-label">Nama Kota</label>
                  <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($profile['city']); ?>">
                </div>
                <div class="form-group col-md-5">
                  <label for="district" class="form-label">Nama Kecamatan</label>
                  <input type="text" class="form-control" name="district" value="<?php echo htmlspecialchars($profile['district']); ?>">
                </div>
                <div class="form-group col-md-2">
                  <label for="postal_code" class="form-label">Kode Pos</label>
                  <input type="number" class="form-control" name="postal_code" value="<?php echo htmlspecialchars($profile['postal_code']); ?>">
                </div>
              </div>
              <div class="row mb-3">
                <div class="form-group col-md-6">
                  <label for="street" class="form-label">Nama Jalan</label>
                  <input type="text" class="form-control" name="street" value="<?php echo htmlspecialchars($profile['street']); ?>">
                </div>
                <div class="form-group col-md-6">
                  <label for="url_map" class="form-label">Titik Lokasi</label>
                  <input type="text" class="form-control" name="url_map" value="<?php echo htmlspecialchars($profile['url_map']); ?>">
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-warning me-3">Simpan</button>
                <a href="profil.php" type="menu" class="btn btn-primary">Batal</a>
              </div>
            </form>
          </div>
        </div>
        <?php include_once("../includes/footer.php"); ?>
      </main>
    </div>
  </div>
  <script>
    function confirmDelete(id) {
      var confirmation = confirm("Apakah Anda yakin ingin menghapus paket ini?");
      if (confirmation) {
        window.location.href = "../service/deletePacket.php?id=" + id;
      }
    }

    function removeURLParameter(param) {
      var url = window.location.href;
      var regex = new RegExp("[\\?&]" + param + "=([^&#]*)");
      var results = regex.exec(url);
      if (results !== null) {
        var newUrl = url.replace(results[0], "");
        history.replaceState(null, null, newUrl);
      }
    }

    window.onload = function() {
      removeURLParameter('status');
    }
  </script>
  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>