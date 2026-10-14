<?php
// catalog.php - Accommodations, Courts & Buyout Catalog
require_once __DIR__ . '/includes/data.php';
require_login();

$user = get_current_user_data();
$data = load_data();
$filter = isset($_GET['filter']) ? strtoupper($_GET['filter']) : 'ALL';

// Filter elements
$items = array_filter($data['catalog'], function($item) use ($filter) {
    if ($filter === 'ALL') return true;
    return $item['type'] === $filter;
});

$booking_alert = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reserve') {
    $item_id = intval($_POST['item_id']);
    foreach ($data['catalog'] as $cat_item) {
        if ($cat_item['id'] === $item_id) {
            $new_booking = [
                'id' => 'BK-' . rand(2000, 9999),
                'user_id' => $user['id'],
                'title' => $cat_item['title'],
                'type' => 'Upcoming',
                'check_in' => '2:00 PM',
                'check_out' => '12:00 PM',
                'date' => date('M d, Y', strtotime('+4 days')),
                'capacity' => $cat_item['subtitle'],
                'payment' => 'Online Bank Transfer / GCash',
                'price' => '₱' . number_format($cat_item['rate']) . ' / night',
                'status' => 'Confirmed'
            ];
            $data['bookings'][] = $new_booking;
            save_data($data);
            $booking_alert = "Your reservation for " . $cat_item['title'] . " has been successfully confirmed!";
            break;
        }
    }
}
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content">
  <div class="section-header">
    <span class="section-kicker">Resort Accommodations &amp; Athletics</span>
    <h1 class="section-title">Facility Catalog</h1>
    <p class="section-description">
      Select from our 3 oceanfront villas, 3 certified pickleball hardcourts, FIBA basketball court, or full private buyout packages.
    </p>
  </div>

  <?php if (!empty($booking_alert)): ?>
    <div style="background-color:#eaf5ee; color:#1f693b; border:1px solid #c7e5d2; padding:16px 20px; border-radius:var(--radius-sm); font-size:14px; font-weight:600; margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
      <span><?= htmlspecialchars($booking_alert) ?></span>
      <a href="bookings.php" style="color:#1f693b; text-decoration:underline;">Review in Bookings &rarr;</a>
    </div>
  <?php endif; ?>

  <!-- Filter Toolbar (ALL, ROOMS, PICKLEBALL, BASKETBALL, BUYOUT) -->
  <div class="filter-toolbar">
    <a href="catalog.php?filter=ALL" class="filter-tab-btn <?= ($filter === 'ALL') ? 'active' : '' ?>">All Amenities</a>
    <a href="catalog.php?filter=ROOMS" class="filter-tab-btn <?= ($filter === 'ROOMS') ? 'active' : '' ?>">Villas &amp; Suites (3)</a>
    <a href="catalog.php?filter=PICKLEBALL" class="filter-tab-btn <?= ($filter === 'PICKLEBALL') ? 'active' : '' ?>">Pickleball Courts (3)</a>
    <a href="catalog.php?filter=BASKETBALL" class="filter-tab-btn <?= ($filter === 'BASKETBALL') ? 'active' : '' ?>">Basketball Arena (1)</a>
    <a href="catalog.php?filter=BUYOUT" class="filter-tab-btn <?= ($filter === 'BUYOUT') ? 'active' : '' ?>">Exclusive Buyout</a>
  </div>

  <!-- 3-Column Catalog Grid -->
  <div class="catalog-grid">
    <?php foreach ($items as $item): ?>
      <div class="catalog-card">
        <div class="catalog-image-wrap">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
          <span class="catalog-badge-pill"><?= htmlspecialchars($item['type']) ?></span>
        </div>

        <div class="catalog-card-body">
          <h3 class="catalog-title"><?= htmlspecialchars($item['title']) ?></h3>
          <div class="catalog-specs"><?= htmlspecialchars($item['subtitle']) ?></div>
          <p class="catalog-desc"><?= htmlspecialchars($item['description']) ?></p>

          <div class="catalog-footer">
            <div>
              <div class="price-figure">₱<?= number_format($item['rate']) ?></div>
              <div class="price-unit"><?= ($item['type'] === 'PICKLEBALL' || $item['type'] === 'BASKETBALL') ? 'per hour' : 'per night' ?></div>
            </div>

            <div>
              <?php if ($item['status'] === 'Available'): ?>
                <?php if ($item['type'] === 'PICKLEBALL' || $item['type'] === 'BASKETBALL'): ?>
                  <a href="court.php?type=<?= strtolower($item['type']) ?>" class="btn btn-primary btn-sm">Reserve Slot</a>
                <?php else: ?>
                  <form method="POST" action="catalog.php?filter=<?= $filter ?>" style="display:inline;">
                    <input type="hidden" name="action" value="reserve">
                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                    <button type="submit" class="btn btn-primary btn-sm">Reserve Villa</button>
                  </form>
                <?php endif; ?>
              <?php elseif ($item['status'] === 'Under Maintenance'): ?>
                <span class="badge badge-pending">Under Maintenance</span>
              <?php else: ?>
                <span class="badge badge-cancelled">Occupied / Booked</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
