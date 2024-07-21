<?php
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

include '../includes/db_connect.php';
// Ambil data packet
$getAllPackets = "SELECT id, name, price FROM packet WHERE is_deleted = false";
$queryPackets = mysqli_query($db, $getAllPackets);

// Ambil data customer
$getAllCustomers = "SELECT id, name, phone_number FROM customer WHERE is_deleted = false";
$queryCustomers = mysqli_query($db, $getAllCustomers);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transaksi</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
</head>

<style>
  .status-badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    outline-color: black;
  }

  .status-belum-diproses {
    background-color: #a4abb6;
  }

  .status-sedang-diproses {
    background-color: #2dccff;
  }

  .status-siap-diambil {
    background-color: #56f000;
  }

  .status-sudah-diambil {
    background-color: #ffb302;
  }
</style>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    include_once("../includes/sidebarCashier.php");
    ?>

    <!-- Main Content -->
    <div class="main">
      <!-- Navbar content -->
      <?php
      include_once("../includes/navbar.php");
      ?>
      <main class="content">
        <div class="container">
          <!-- Message for create Customer  -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'createsuccess') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Transaksi berhasil dibuat!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'createfailed') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Transaksi gagal dibuat!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Message for edit Customer  -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'editsuccess') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Status berhasil diubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'editfailed') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Status gagal diubah!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <!-- Message for delete Customer  -->
          <?php if (isset($_GET['status']) && $_GET['status'] == 'deletesuccess') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Transaksi berhasil dihapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['status']) && $_GET['status'] == 'deletefailed') : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Transaksi gagal dihapus!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="h3 fw-bold">Transaksi</div>
          <hr />

          <!-- card transaction -->
          <?php
          // Queries to get transaction counts by status
          $queryPending = "SELECT COUNT(*) AS total_pending FROM transaction WHERE status = 'Belum diproses'";
          $queryProcessing = "SELECT COUNT(*) AS total_processing FROM transaction WHERE status = 'Sedang diproses'";
          $queryReady = "SELECT COUNT(*) AS total_ready FROM transaction WHERE status = 'Siap diambil'";
          $queryCompleted = "SELECT COUNT(*) AS total_completed FROM transaction WHERE status = 'Sudah diambil'";

          // Execute queries and fetch results
          $resultPending = mysqli_query($db, $queryPending);
          $totalPending = mysqli_fetch_assoc($resultPending)['total_pending'];

          $resultProcessing = mysqli_query($db, $queryProcessing);
          $totalProcessing = mysqli_fetch_assoc($resultProcessing)['total_processing'];

          $resultReady = mysqli_query($db, $queryReady);
          $totalReady = mysqli_fetch_assoc($resultReady)['total_ready'];

          $resultCompleted = mysqli_query($db, $queryCompleted);
          $totalCompleted = mysqli_fetch_assoc($resultCompleted)['total_completed'];
          ?>

          <!-- card transaction -->
          <div class="row mb-5">
            <div class="col-sm-3">
              <div class="card shadow-sm">
                <div class="card-body m-2">
                  <div class="d-flex justify-content-between">
                    <h2 class="card-text fw-bold"><?php echo $totalPending; ?></h2>
                    <p class="small align-items-center align-items-end">
                      Status
                    </p>
                  </div>
                  <p class="card-title fw-bold">Belum diproses</p>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card shadow-sm">
                <div class="card-body m-2">
                  <div class="d-flex justify-content-between">
                    <h2 class="card-text fw-bold"><?php echo $totalProcessing; ?></h2>
                    <p class="small align-items-center align-items-end">
                      Status
                    </p>
                  </div>
                  <p class="card-title fw-bold">Sedang diproses</p>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card shadow-sm">
                <div class="card-body m-2">
                  <div class="d-flex justify-content-between">
                    <h2 class="card-text fw-bold"><?php echo $totalReady; ?></h2>
                    <p class="small align-items-center align-items-end">
                      Status
                    </p>
                  </div>
                  <p class="card-title fw-bold">Siap diambil</p>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card shadow-sm">
                <div class="card-body m-2">
                  <div class="d-flex justify-content-between">
                    <h2 class="card-text fw-bold"><?php echo $totalCompleted; ?></h2>
                    <p class="small align-items-center align-items-end">
                      Status
                    </p>
                  </div>
                  <p class="card-title fw-bold">Sudah diambil</p>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive pt-4 bg-body-secondary container-fluid">
            <div class="d-flex justify-content-between mb-3">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
                <span>Tambah</span>
              </button>

              <!-- Modal Create -->
              <form action="../service/createTransactionService.php" method="post">
                <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalFormLabel">Form Transaksi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <div class="row">
                            <!-- Customer Field -->
                            <input type="number" class="form-control" value="<?php echo $user_id ?>" name="user_id" hidden>
                            <div class="col-6 pb-3">
                              <label for="customerList" class="form-label">Nama Pelanggan</label>
                              <input class="form-control" list="customerOptions" id="customerList" placeholder="Ketik Untuk Cari..." name="customerName" required />
                              <datalist id="customerOptions">
                                <?php while ($customer = mysqli_fetch_array($queryCustomers)) { ?>
                                  <option value="<?php echo $customer['name'] . ' - ' . $customer['phone_number']; ?>" data-id="<?php echo $customer['id']; ?>"></option>
                                <?php } ?>
                              </datalist>
                              <input type="hidden" id="customerId" name="customer_id">
                            </div>
                            <!-- Packet Field -->
                            <div class="col-6 pb-3">
                              <label for="packetSelect" class="form-label">Jenis Paket</label>
                              <select class="form-select" id="packetSelect" aria-label="Default select example" name="packet" required>
                                <option selected value="">Pilih</option>
                                <?php while ($packet = mysqli_fetch_array($queryPackets)) {
                                  // Format harga ke dalam format Rupiah
                                  $formatted_price = 'Rp ' . number_format($packet['price'], 0, ',', '.');
                                ?>
                                  <option value="<?php echo $packet['id']; ?>" data-harga="<?php echo $packet['price']; ?>">
                                    <?php echo $packet['name'] . ' - ' . $formatted_price; ?>
                                  </option>
                                <?php } ?>
                              </select>
                            </div>

                            <!-- Weight Field -->
                            <div class="col-6 pb-3">
                              <label for="weightInput" class="form-label">Kg</label>
                              <input type="number" class="form-control" id="weightInput" name="weight" required />
                            </div>

                            <!-- Discount Field -->
                            <div class="col-6 pb-3">
                              <label for="discountInput" class="form-label">Diskon</label>
                              <input type="number" class="form-control" id="discountInput" value="0" name="discount" />
                            </div>

                            <!-- Total Field -->
                            <div class="col-6 pb-3">
                              <label for="totalInput" class="form-label">Total</label>
                              <input type="text" class="form-control" id="totalInput" value="Rp 0" readonly />
                            </div>

                            <!-- Uang Bayar Field -->
                            <div class="col-6 pb-3">
                              <label for="uangBayar" class="form-label">Uang Bayar</label>
                              <input type="number" class="form-control" id="uangBayar" name="uangBayar" required />
                            </div>

                            <!-- Uang Kembalian Field -->
                            <div class="col-6 pb-3">
                              <label for="uangKembalian" class="form-label">Uang Kembalian</label>
                              <input type="text" class="form-control" id="uangKembalian" value="Rp 0" readonly />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <button class="btn btn-outline-primary" type="submit">
                  Cari
                </button>
              </form>
            </div>

            <!-- Modal Edit Status -->
            <div class="modal fade" id="modalEditStatus" tabindex="-1" aria-labelledby="modalEditStatusLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form action="../service/updateTransactionService.php" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditStatusLabel">Ubah Status Transaksi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <!-- Input hidden untuk menyimpan ID transaksi -->
                      <input type="hidden" id="editTransactionId" name="id" value="">
                      <div class="form-group">
                        <label for="editStatusSelect">Status Baru:</label>
                        <select class="form-select" id="editStatusSelect" name="status">
                          <option value="Belum diproses">Belum diproses</option>
                          <option value="Sedang diproses">Sedang Diproses</option>
                          <option value="Siap diambil">Siap diambil</option>
                          <option value="Sudah diambil">Sudah diambil</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Tabel transaction -->
            <div class="table-responsive">
              <table class="table table-sm table-bordered text-center">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Handphone</th>
                    <th scope="col">Jenis Paket</th>
                    <th scope="col">Kg</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $perPage = 10;
                  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                  $start = ($page - 1) * $perPage;
                  $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';

                  $searchQuery = $search ? "AND (c.name LIKE '%$search%' OR c.phone_number LIKE '%$search%' OR p.name LIKE '%$search%' OR t.status LIKE '%$search%')" : '';

                  $getAllTransaction = "SELECT
                              t.id,
                              t.created_at,
                              t.amount,
                              p.name AS packet_name,
                              t.status,
                              c.name AS customer_name,
                              c.phone_number AS customer_phone,
                              t.weight
                            FROM
                              transaction t
                            JOIN
                              packet p ON t.packet_id = p.id
                            JOIN
                              customer c ON t.customer_id = c.id
                            WHERE
                              1=1
                              $searchQuery
                            ORDER BY
                              t.created_at DESC
                            LIMIT $start, $perPage";

                  $queryTransaction = mysqli_query($db, $getAllTransaction);

                  $no = $start + 1;
                  while ($transaction = mysqli_fetch_array($queryTransaction)) {
                    $statusClass = '';
                    switch ($transaction['status']) {
                      case 'Belum diproses':
                        $statusClass = 'status-belum-diproses';
                        break;
                      case 'Sedang diproses':
                        $statusClass = 'status-sedang-diproses';
                        break;
                      case 'Siap diambil':
                        $statusClass = 'status-siap-diambil';
                        break;
                      case 'Sudah diambil':
                        $statusClass = 'status-sudah-diambil';
                        break;
                    }

                    echo "<tr class='align-middle'>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $transaction['created_at'] . "</td>";
                    echo "<td>" . $transaction['customer_name'] . "</td>";
                    echo "<td><a class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover' data-number='" . $transaction['customer_phone'] . "' data-name='" . $transaction['customer_name'] . "' href='#' onclick='send_handle(this)'>" . $transaction['customer_phone'] . "</a></td>";
                    echo "<td>" . $transaction['packet_name'] . "</td>";
                    echo "<td>" . $transaction['weight'] . "</td>";
                    echo "<td><span class='status-badge " . $statusClass . "'>" . $transaction['status'] . "</span></td>";
                    echo "<td class='price'>" . $transaction['amount'] . "</td>";
                    echo "<td class='col-2'>";
                    echo "<button class='btn me-2 btn-warning' data-bs-toggle='modal' data-bs-target='#modalEditStatus' data-id='" . $transaction['id'] . "' data-status='" . $transaction['status'] . "'><i class='lni lni-pencil-alt'></i></button>";
                    echo "<a class='btn me-2 btn-danger' href='#' onclick='confirmDelete(" . $transaction['id'] . ", \"" . $transaction['customer_name'] . "\")'><i class='lni lni-remove-file'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <?php
            $totalTransactionsQuery = "SELECT COUNT(*) AS total_transactions FROM transaction t 
                                          JOIN customer c  ON t.customer_id = c.id
                                          JOIN packet p ON t.packet_id = p.id
                                          WHERE 1=1 $searchQuery";

            $totalTransactionsResult = mysqli_query($db, $totalTransactionsQuery);
            $totalTransactions = mysqli_fetch_assoc($totalTransactionsResult)['total_transactions'];
            $totalPages = ceil($totalTransactions / $perPage);
            ?>

            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <?php if ($page > 1) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                <?php else : ?>
                  <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                  <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                <?php else : ?>
                  <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </nav>

          </div>
        </div>
      </main>
      <?php
      include_once("../includes/footer.php");
      ?>
    </div>
  </div>
  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const packetSelect = document.getElementById('packetSelect');
      const weightInput = document.getElementById('weightInput');
      const totalInput = document.getElementById('totalInput');
      const uangBayarInput = document.getElementById('uangBayar');
      const uangKembalianInput = document.getElementById('uangKembalian');
      const discountInput = document.getElementById('discountInput');

      function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR',
          minimumFractionDigits: 0
        }).format(number)
      }

      function calculateTotal() {
        const selectedPacket = packetSelect.options[packetSelect.selectedIndex];
        const packetPrice = selectedPacket ? parseFloat(selectedPacket.getAttribute('data-harga')) : 0;
        const weight = parseFloat(weightInput.value) || 0;
        let total = packetPrice * weight;

        // Perhitungan discount
        if (packetPrice >= 20000 && weight >= 5) {
          const discount = packetPrice;
          discountInput.value = discount;
          total -= discount;
        } else {
          discountInput.value = 0;
        }

        totalInput.value = formatRupiah(total);
        calculateKembalian(total);
      }

      function calculateKembalian(total) {
        const uangBayar = parseFloat(uangBayarInput.value.replace(/[Rp.,\s]/g, '')) || 0; // Menghilangkan simbol IDR
        const kembalian = uangBayar - total;
        uangKembalianInput.value = formatRupiah(kembalian);
      }

      packetSelect.addEventListener('change', calculateTotal);
      weightInput.addEventListener('input', calculateTotal);
      uangBayarInput.addEventListener('input', () => {
        const numericTotal = parseFloat(totalInput.value.replace(/[Rp.,\s]/g, '')) || 0; // Menghilangkan simbol IDR
        calculateKembalian(numericTotal);
      });

      const formatTotalElements = document.querySelectorAll('.price');
      formatTotalElements.forEach(element => {
        const price = parseFloat(element.textContent);
        element.textContent = formatRupiah(price);
      });
    });

    function send_handle(link) {
      const name = link.getAttribute('data-name');
      const num = link.getAttribute('data-number');
      if (confirm("Apakah anda yakin ingin mengirim pesan ke " + name + "?")) {
        const win = window.open(`https://wa.me/${num}`, '_blank');
      }

    }

    function confirmDelete(id, name) {
      if (confirm("Apakah anda yakin ingin menghapus transaksi " + name + "?")) {
        window.location.href = '../service/deleteTransactionService.php?id=' + id;
      }
    }

    // Mengisi modal Edit Status dengan data transaksi yang sesuai
    var modalEditStatus = document.getElementById('modalEditStatus');
    modalEditStatus.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget; // Tombol yang membuka modal
      var transactionId = button.getAttribute('data-id'); // Mendapatkan ID dari tombol
      var currentStatus = button.getAttribute('data-status'); // Mendapatkan status dari tombol

      // Mengatur nilai input hidden dengan ID transaksi yang sesuai
      var transactionIdInput = modalEditStatus.querySelector('#editTransactionId');
      transactionIdInput.value = transactionId;
    });

    document.getElementById('customerList').addEventListener('input', function() {
      var input = this.value;
      var options = document.querySelectorAll('#customerOptions option');
      for (var i = 0; i < options.length; i++) {
        if (options[i].value === input) {
          document.getElementById('customerId').value = options[i].dataset.id;
          break;
        }
      }
    });

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



</body>

</html>