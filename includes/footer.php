 <?php

  $sqlLaundry = "SELECT name_company FROM profil_company WHERE id = 1";
  $queryLaundry = $db->query($sqlLaundry);
  $laundry = $queryLaundry->fetch_assoc();
  ?>
 <footer class="bg-body-tertiary text-center text-lg-start">
   <!-- Copyright -->
   <div class="text-center p-3"">
    © 2024 Copyright:
    <a class=" text-body" href=""><?php echo htmlspecialchars($laundry['name_company']); ?></a>
   </div>
   <!-- Copyright -->
 </footer>

 <footer id="footer" class="footer">

 </footer>