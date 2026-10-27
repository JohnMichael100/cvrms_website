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
                  <form method="POST" action="payment.php" style="display:inline;">
                    <input type="hidden" name="action" value="start_room">
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
