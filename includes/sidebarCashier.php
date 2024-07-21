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
       <a href="customer.php" class="sidebar-link">
         <i class="lni lni-customer"></i>
         <span>Pelanggan</span>
       </a>
     </li>
     <li class="sidebar-item">
       <a href="transaction.php" class="sidebar-link">
         <i class="lni lni-pencil-alt"></i>
         <span>Transaksi</span>
       </a>
     </li>
     <hr style="width: 80%; border: 1px solid white; margin-left: auto; margin-right: auto;">
     <li class="sidebar-item">
       <a href="settingCashier.php" class="sidebar-link">
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