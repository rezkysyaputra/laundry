<?php
include '../includes/db_connect.php';

// Ambil data dari tabel profil_company
$queryProfile = "SELECT * FROM profil_company LIMIT 1";
$resultProfile = mysqli_query($db, $queryProfile);
$profile = mysqli_fetch_assoc($resultProfile);

// Ambil data statistik
$queryCountTransactions = "SELECT COUNT(*) AS transaction_count FROM transaction";
$resultCountTransactions = mysqli_query($db, $queryCountTransactions);
$transactionCount = mysqli_fetch_assoc($resultCountTransactions)['transaction_count'];

$queryCountCustomers = "SELECT COUNT(*) AS customer_count FROM customer WHERE is_deleted = false";
$resultCountCustomers = mysqli_query($db, $queryCountCustomers);
$customerCount = mysqli_fetch_assoc($resultCountCustomers)['customer_count'];

$queryPackets = "SELECT name, price, estimation, description from packet WHERE is_deleted = false";
$sqlPackets = mysqli_query($db, $queryPackets);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title><?php echo htmlspecialchars($profile['name_company']); ?></title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />

  <!-- =======================================================
  * Template Name: BizLand
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Updated: Jun 14 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-cente">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename"><?php echo htmlspecialchars($profile['name_company']); ?></h1>
          <span>.</span>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#about">Tentang kami</a></li>
            <li><a href="#packet">Paket</a></li>
            <!-- <li><a href="#portfolio">Portfolio</a></li> -->
            <li><a href="#alamat">Alamat</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">
    <!-- Hero Section -->
    <section id="home" class="hero section" style="background-image: url('<?php echo htmlspecialchars($profile['banner_img']); ?>');">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1 class="mb-5">Selamat datang di <span><?php echo htmlspecialchars($profile['name_company']); ?></span></h1>
            <div class="d-flex">
              <a href="#about" class="btn-get-started">Mulai Telusuri!</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- About Section -->
    <section id="about" class="about section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About</h2>
        <p>
          <span>Temukan lebih banyak</span>
          <span class="description-title">Tentang Kami!</span>
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <div class="row gy-3">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="<?php echo htmlspecialchars($profile['about_img']); ?>" alt="" class="img-fluid" />
          </div>

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="about-content ps-0 ps-lg-3">
              <h5><?php echo htmlspecialchars($profile['about']); ?></h5>
              <ul>
                <li>
                  <i class="bi bi-diagram-3"></i>
                  <div>
                    <h4>Visi Kami</h4>
                    <p><?php echo htmlspecialchars($profile['vision']); ?></p>
                  </div>
                </li>
                <li>
                  <i class="bi bi-fullscreen-exit"></i>
                  <div>
                    <h4>Misi Kami</h4>
                    <ul>
                      <?php
                      $missions = explode('.', $profile['mission']);
                      foreach ($missions as $mission) {
                        echo "<li>" . htmlspecialchars($mission) . "</li>";
                      }
                      ?>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-journal-richtext"></i>
            <div class="stats-item">
              <span><?php echo htmlspecialchars($transactionCount); ?></span>
              <h5>Jumlah Transaksi</h5>
            </div>
          </div>
          <!-- End Stats Item -->

          <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-people"></i>
            <div class="stats-item">
              <span><?php echo htmlspecialchars($customerCount); ?></span>
              <h5>Jumlah Pelanggan</h5>
            </div>
          </div>
          <!-- End Stats Item -->
        </div>
      </div>
    </section>
    <!-- /Stats Section -->

    <!-- Pricing Section -->
    <section id="packet" class="pricing section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Harga</h2>
        <p>
          <span>Cek Harga</span>
          <span class="description-title">Paket Kami</span>
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <div class="row gy-3">
          <?php
          function formatRupiah($number)
          {
            return 'Rp ' . number_format($number, 0, ',', '.');
          }

          while ($packet = mysqli_fetch_array($sqlPackets)) {
            echo "<div class='col-xl-4 col-lg-6' data-aos='fade-up' data-aos-delay='100'>
            <div class='pricing-item featured'>
              <h3>" . htmlspecialchars($packet['name']) . "</h3>
              <h4>" . formatRupiah($packet['price']) . "</h4>
              <ul>
                <p>
                 " . htmlspecialchars($packet['description']) . "
                </p>
              </ul>
              <div class='btn-wrap'>
                <p>Estimasi</p>
                <h5 class='fw-bold'>" . htmlspecialchars($packet['estimation']) . "</h5>
              </div>
            </div>
          </div>";
          }
          ?>
          <!-- End Pricing Item -->
        </div>
      </div>

    </section>
    <!-- /Pricing Section -->

    <!-- Contact Section -->
    <section id="alamat" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <p>
          <span class="description-title">Alamat Kami</span>
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Alamat</h3>
                  <p><?php echo htmlspecialchars($profile['street'] . ', ' . $profile['district'] . ', ' . $profile['city'] . ', Kode POS ' . $profile['postal_code']); ?></p>
                </div>
              </div>
              <!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Kontak kami</h3>
                  <p>+<?php echo htmlspecialchars($profile['phone_number']); ?></p>
                </div>
              </div>
              <!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p><?php echo htmlspecialchars($profile['email']); ?></p>
                </div>
              </div>
              <!-- End Info Item -->
              <iframe src="<?php echo htmlspecialchars($profile['url_map']); ?>" width="100%" height="270" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
          <!-- End Contact Form -->
        </div>
      </div>
    </section>
    <!-- /Contact Section -->
  </main>

  <footer id="footer" class="footer">
    <div class="container copyright text-center mt-4">
      <p>
        © <span>Copyright</span>
        <strong class="px-1 sitename"><?php echo htmlspecialchars($profile['name_company']); ?></strong>
        <span>All Rights Reserved</span>
      </p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>