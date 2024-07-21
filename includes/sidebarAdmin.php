 <?php

  $sqlLaundry = "SELECT name_company FROM profil_company WHERE id = 1";
  $queryLaundry = $db->query($sqlLaundry);
  $laundry = $queryLaundry->fetch_assoc();
  ?>

 <aside id="sidebar">
   <div class="d-flex">
     <button class="toggle-btn" type="button">
       <i class="lni lni-grid-alt"></i>
     </button>
     <div class="sidebar-logo">
       <a href="dashboard.php"><?php echo htmlspecialchars($laundry['name_company']); ?></a>
     </div>
   </div>
   <ul class="sidebar-nav">
     <li class="sidebar-item">
       <a href="dashboard.php" class="sidebar-link">
         <i class="lni lni-dashboard"></i>
         <span>Dashboard</span>
       </a>
     </li>
     <hr style="width: 80%; border: 1px solid white; margin-left: auto; margin-right: auto;">
     <li class="sidebar-item">
       <a href="profil.php" class="sidebar-link">
         <i class="lni lni-apartment"></i>
         <span>Profil Laundry</span>
       </a>
     </li>
     <li class="sidebar-item">
       <a href="cashier.php" class="sidebar-link">
         <i class="lni lni-users"></i>
         <span>Kasir</span>
       </a>
     </li>
     <hr style="width: 80%; border: 1px solid white; margin-left: auto; margin-right: auto;">
     <li class="sidebar-item">
       <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#authOne" aria-expanded="false" aria-controls="authOne">
         <i class="lni lni-database"></i>
         <span>Data Master</span>
       </a>
       <ul id="authOne" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
         <li class="sidebar-item">
           <a href="packets.php" class="sidebar-link">Paket</a>
         </li>
         <li class="sidebar-item">
           <a href="expenses.php" class="sidebar-link">Pengeluaran</a>
         </li>
       </ul>
     </li>
     <li class="sidebar-item">
       <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="false" aria-controls="reports">
         <i class="lni lni-archive"></i>
         <span>Laporan</span>
       </a>
       <ul id="reports" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
         <li class="sidebar-item">
           <a href="transaction_reports.php" class="sidebar-link">Laporan Transaksi</a>
         </li>
         <li class="sidebar-item">
           <a href="expense_reports.php" class="sidebar-link">Laporan Pengeluaran</a>
         </li>
       </ul>
     </li>
     <hr style="width: 80%; border: 1px solid white; margin-left: auto; margin-right: auto;">
     <li class="sidebar-item">
       <a href="settingAdmin.php" class="sidebar-link">
         <i class="lni lni-cog"></i>
         <span>Pengaturan</span>
       </a>
     </li>
   </ul>

   <div class="sidebar-footer">
     <a href="../service/logoutUser.php" class="sidebar-link">
       <i class="lni lni-exit"></i>
       <span>Keluar</span>
     </a>
   </div>
 </aside>