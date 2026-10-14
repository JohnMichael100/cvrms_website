<?php
// home.php - Member Home Dashboard
require_once __DIR__ . '/includes/data.php';
require_login();

$user = get_current_user_data();
$data = load_data();

// Look for user's latest upcoming booking
$upcoming_booking = null;
foreach ($data['bookings'] as $b) {
    if ($b['user_id'] == $user['id'] && $b['type'] === 'Upcoming') {
        $upcoming_booking = $b;
        break;
    }
}
$announcements = $data['announcements'];
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content">
  <!-- Top Section Header -->
  <div class="section-header">
    <span class="section-kicker">Member Portal</span>
    <h1 class="section-title">Resort Dashboard</h1>
    <p class="section-description">
      Review your current itinerary, schedule sports court hours, and view verified updates from resort management.
    </p>
  </div>

  <!-- UPCOMING BOOKING HERO BANNER -->
  <?php if ($upcoming_booking): ?>
    <section class="hero-reservation-banner">
      <div class="banner-content">
        <div>
          <div class="banner-kicker-row">
            <span style="font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--gold-500);">Current Confirmed Itinerary</span>
            <span class="badge badge-white"><?= htmlspecialchars($upcoming_booking['status']) ?></span>
          </div>
          <h2 class="banner-title"><?= htmlspecialchars($upcoming_booking['title']) ?></h2>
        </div>

        <div class="banner-grid-details">
          <div class="banner-meta-col">
            <div class="label">Check-in</div>
            <div class="value"><?= htmlspecialchars($upcoming_booking['check_in']) ?></div>
          </div>
          <div class="banner-meta-col">
            <div class="label">Check-out</div>
            <div class="value"><?= htmlspecialchars($upcoming_booking['check_out']) ?></div>
          </div>
          <div class="banner-meta-col">
            <div class="label">Reservation Date</div>
            <div class="value"><?= htmlspecialchars($upcoming_booking['date']) ?></div>
          </div>
        </div>
      </div>

      <div class="banner-media">
        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80" alt="Villa Overview">
      </div>
    </section>
  <?php else: ?>
    <section class="hero-reservation-banner" style="background:#241d13;">
      <div class="banner-content">
        <div>
          <span style="font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--gold-500);">No Active Reservations</span>
          <h2 class="banner-title" style="margin-top:12px;">Plan Your Next Escape to CasaVista</h2>
          <p style="font-size:15px; color:#dcd3c4; max-width:540px; margin-bottom:24px;">
            Reserve an oceanview suite or book an evening rally on our certified pickleball hardcourts.
          </p>
        </div>
        <div>
          <a href="catalog.php" class="btn btn-gold" style="font-size:14px; padding:12px 24px;">Browse Accommodations &rarr;</a>
        </div>
      </div>
      <div class="banner-media">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80" alt="Resort Villa Garden">
      </div>
    </section>
  <?php endif; ?>

  <!-- QUICK BOOK GRID WITH REAL RESORT PHOTOGRAPHY -->
  <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:20px;">
    <div>
      <span class="section-kicker">Direct Access</span>
      <h3 style="font-family:var(--font-serif); font-size:26px; color:var(--text-primary);">Quick Reservations</h3>
    </div>
    <a href="catalog.php" style="font-size:13.5px; font-weight:700; color:var(--olive-600);">View Complete Catalog &rarr;</a>
  </div>

  <div class="quick-reserve-grid">
    <!-- 1. Rooms -->
    <a href="catalog.php?filter=ROOMS" class="quick-card">
      <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Villas & Rooms">
      <div class="quick-card-content">
        <span class="quick-count-tag">Accommodations (3)</span>
        <h4 class="quick-card-title">Villas &amp; Suites</h4>
        <span class="quick-card-cta">Explore Rooms &rarr;</span>
      </div>
    </a>

    <!-- 2. Pickleball -->
    <a href="court.php?type=pickleball" class="quick-card">
      <img src="https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?auto=format&fit=crop&w=800&q=80" alt="Pickleball Courts">
      <div class="quick-card-content">
        <span class="quick-count-tag">Hardcourts (3)</span>
        <h4 class="quick-card-title">Pickleball</h4>
        <span class="quick-card-cta">Reserve Slot &rarr;</span>
      </div>
    </a>

    <!-- 3. Basketball -->
    <a href="court.php?type=basketball" class="quick-card">
      <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80" alt="Basketball Arena">
      <div class="quick-card-content">
        <span class="quick-count-tag">Regulation Arena (1)</span>
        <h4 class="quick-card-title">Basketball</h4>
        <span class="quick-card-cta">Reserve Slot &rarr;</span>
      </div>
    </a>

    <!-- 4. Buyout -->
    <a href="catalog.php?filter=BUYOUT" class="quick-card">
      <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Resort Buyout">
      <div class="quick-card-content">
        <span class="quick-count-tag">Complete Privacy</span>
        <h4 class="quick-card-title">Resort Buyout</h4>
        <span class="quick-card-cta">View Pricing &rarr;</span>
      </div>
    </a>
  </div>

  <!-- ANNOUNCEMENTS FROM ADMIN & SUPER ADMIN -->
  <div style="margin-bottom:20px;">
    <span class="section-kicker">Official Bulletin</span>
    <h3 style="font-family:var(--font-serif); font-size:26px; color:var(--text-primary);">Resort Advisories &amp; Events</h3>
  </div>

  <div class="announcements-grid">
    <?php foreach ($announcements as $item): ?>
      <article class="announcement-card" onclick="openAnnouncementModal(<?= htmlspecialchars(json_encode($item)) ?>)">
        <div class="announcement-thumb">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
        </div>
        <div class="announcement-body">
          <div class="announcement-meta-row">
            <span class="announcement-category"><?= htmlspecialchars($item['tag']) ?></span>
            <span class="announcement-date"><?= htmlspecialchars($item['date']) ?></span>
          </div>
          <h4 class="announcement-heading"><?= htmlspecialchars($item['title']) ?></h4>
          <p class="announcement-excerpt"><?= htmlspecialchars($item['short_desc']) ?></p>
          <div class="announcement-read-more">
            <span>Read full statement</span>
            <span>&rarr;</span>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</main>

<!-- Detailed Modal for Expanding Announcements -->
<div class="modal-backdrop" id="announcementModal">
  <div class="modal-dialog">
    <div class="modal-header">
      <div>
        <span class="announcement-category" id="modalTag">OFFICIAL NOTICE</span>
        <span id="modalDate" style="display:block; font-size:12px; color:var(--text-muted); margin-top:2px;"></span>
      </div>
      <button class="modal-close-btn" onclick="closeAnnouncementModal()">&times;</button>
    </div>
    <div class="modal-body">
      <img id="modalImg" src="" alt="Notice banner" style="width:100%; height:260px; object-fit:cover; border-radius:var(--radius-sm); margin-bottom:20px;">
      <h3 id="modalTitle" style="font-family:var(--font-serif); font-size:24px; color:var(--text-primary); margin-bottom:14px; line-height:1.3;"></h3>
      <div id="modalDesc" style="font-size:15px; color:var(--text-secondary); line-height:1.8; white-space:pre-line;"></div>
      <div style="margin-top:28px; text-align:right;">
        <button class="btn btn-secondary btn-sm" onclick="closeAnnouncementModal()">Close Statement</button>
      </div>
    </div>
  </div>
</div>

<script>
function openAnnouncementModal(item) {
  document.getElementById('modalTag').innerText = item.tag;
  document.getElementById('modalDate').innerText = item.date + ' • By ' + item.author;
  document.getElementById('modalTitle').innerText = item.title;
  document.getElementById('modalDesc').innerText = item.full_desc;
  document.getElementById('modalImg').src = item.image;
  document.getElementById('announcementModal').classList.add('active');
}

function closeAnnouncementModal() {
  document.getElementById('announcementModal').classList.remove('active');
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
