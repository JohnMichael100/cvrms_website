<?php
// includes/footer.php - Professional Footer
?>
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-brand-col">
      <div class="brand-mark" style="margin-bottom:16px;">
        <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort logo" class="brand-logo">
        <div class="brand-text">
          <span class="brand-name" style="color:#ffffff;">CASAVISTA</span>
          <span class="brand-sub">RESORT &bull; CEBU</span>
        </div>
      </div>
      <p style="font-size:14px; color:#c0b5a3; line-height:1.75; max-width:380px;">
        A private coastal sanctuary featuring 3 boutique oceanfront villas, 3 tournament-grade pickleball hardcourts, a regulation FIBA basketball arena, and full-resort buyouts.
      </p>
    </div>

    <div>
      <div class="footer-col-title">Guest Portal</div>
      <ul class="footer-nav-list">
        <li><a href="home.php">Home Overview</a></li>
        <li><a href="catalog.php">Accommodations &amp; Courts</a></li>
        <li><a href="court.php">Reserve Court Slot</a></li>
        <li><a href="bookings.php">Booking Ledger</a></li>
        <li><a href="profile.php">Member Credentials</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Amenities</div>
      <ul class="footer-nav-list">
        <li><a href="catalog.php?filter=ROOMS">Boutique Villas (3)</a></li>
        <li><a href="catalog.php?filter=PICKLEBALL">Pickleball Hardcourts (3)</a></li>
        <li><a href="catalog.php?filter=BASKETBALL">FIBA Basketball Arena (1)</a></li>
        <li><a href="catalog.php?filter=BUYOUT">Exclusive Resort Buyout</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Concierge &amp; Location</div>
      <p style="font-size:13.5px; color:#c0b5a3; line-height:1.8;">
        Punta Engaño Coastal Way<br>
        Lapu-Lapu City, Cebu 6015, Philippines<br>
        Direct Desk: +63 (032) 495-8829<br>
        Email: reservations@casavistaresort.ph
      </p>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-bottom-inner">
      <span>&copy; <?= date('Y') ?> CasaVista Resort. All rights reserved.</span>
      <div style="display:flex; gap:24px;">
        <a href="#terms" style="color:#8f8574; text-decoration:none;">Privacy Policy</a>
        <a href="#terms" style="color:#8f8574; text-decoration:none;">Resort Guidelines</a>
        <a href="#terms" style="color:#8f8574; text-decoration:none;">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<script src="assets/js/main.js"></script>
</body>
</html>
