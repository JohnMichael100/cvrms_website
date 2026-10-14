<?php
// bookings.php - Bookings history (Upcoming, Past, Cancelled)
require_once __DIR__ . '/includes/data.php';
require_login();

$user = get_current_user_data();
$data = load_data();
$status_filter = isset($_GET['tab']) ? ucfirst($_GET['tab']) : 'Upcoming';
if (!in_array($status_filter, ['Upcoming', 'Past', 'Cancelled'])) {
    $status_filter = 'Upcoming';
}

$alert_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel_booking') {
    $booking_id = $_POST['booking_id'] ?? '';
    foreach ($data['bookings'] as &$b) {
        if ($b['id'] === $booking_id && $b['user_id'] == $user['id']) {
            $b['type'] = 'Cancelled';
            $b['status'] = 'Cancelled';
            $alert_message = "Reservation " . htmlspecialchars($booking_id) . " has been successfully cancelled.";
            break;
        }
    }
    save_data($data);
}

$user_bookings = array_filter($data['bookings'], function($b) use ($user, $status_filter) {
    return ($b['user_id'] == $user['id'] && $b['type'] === $status_filter);
});
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content">
  <div class="section-header">
    <span class="section-kicker">Itinerary Archive</span>
    <h1 class="section-title">My Bookings</h1>
    <p class="section-description">
      Manage upcoming visits, review past stays, or process reservation cancellations.
    </p>
  </div>

  <?php if (!empty($alert_message)): ?>
    <div style="background-color:#feebe8; color:#a33729; border:1px solid #f7c5bd; padding:16px 20px; border-radius:var(--radius-sm); font-size:14px; font-weight:600; margin-bottom:28px;">
      <?= htmlspecialchars($alert_message) ?>
    </div>
  <?php endif; ?>

  <!-- Tabs: Upcoming, Past, Cancelled -->
  <div class="filter-toolbar">
    <a href="bookings.php?tab=upcoming" class="filter-tab-btn <?= ($status_filter === 'Upcoming') ? 'active' : '' ?>">
      Upcoming Reservations (<?= count(array_filter($data['bookings'], fn($b) => $b['user_id'] == $user['id'] && $b['type'] === 'Upcoming')) ?>)
    </a>
    <a href="bookings.php?tab=past" class="filter-tab-btn <?= ($status_filter === 'Past') ? 'active' : '' ?>">
      Past Stays (<?= count(array_filter($data['bookings'], fn($b) => $b['user_id'] == $user['id'] && $b['type'] === 'Past')) ?>)
    </a>
    <a href="bookings.php?tab=cancelled" class="filter-tab-btn <?= ($status_filter === 'Cancelled') ? 'active' : '' ?>">
      Cancelled (<?= count(array_filter($data['bookings'], fn($b) => $b['user_id'] == $user['id'] && $b['type'] === 'Cancelled')) ?>)
    </a>
  </div>

  <!-- Cards Grid -->
  <?php if (empty($user_bookings)): ?>
    <div style="background:var(--bg-surface); border:1px dashed var(--border-strong); border-radius:var(--radius-md); padding:56px 32px; text-align:center;">
      <h3 style="font-family:var(--font-serif); font-size:22px; color:var(--text-primary); margin-bottom:8px;">No <?= strtolower($status_filter) ?> records</h3>
      <p style="font-size:14px; color:var(--text-secondary); max-width:440px; margin:0 auto 24px;">
        You do not currently have any <?= strtolower($status_filter) ?> reservations in your account history.
      </p>
      <a href="catalog.php" class="btn btn-primary btn-sm">Browse Accommodations</a>
    </div>
  <?php else: ?>
    <div class="ledger-grid">
      <?php foreach ($user_bookings as $booking): ?>
        <div class="ledger-card">
          <div>
            <div class="ledger-top">
              <h3 class="ledger-title"><?= htmlspecialchars($booking['title']) ?></h3>
              <span class="badge <?= ($booking['status'] === 'Confirmed') ? 'badge-confirmed' : (($booking['status'] === 'Cancelled') ? 'badge-cancelled' : 'badge-pending') ?>">
                <?= htmlspecialchars($booking['status']) ?>
              </span>
            </div>

            <div class="ledger-dates">
              <?= htmlspecialchars($booking['date']) ?> &bull; <?= htmlspecialchars($booking['check_in']) ?> &ndash; <?= htmlspecialchars($booking['check_out']) ?>
            </div>

            <div class="ledger-specs">
              <div><strong>Facility / Package:</strong> <?= htmlspecialchars($booking['capacity']) ?></div>
              <div style="color:var(--text-muted); font-size:13px; margin-top:4px;"><strong>Payment Reference:</strong> <?= htmlspecialchars($booking['payment']) ?></div>
            </div>
          </div>

          <div class="ledger-bottom">
            <div>
              <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:var(--text-muted); display:block;">Amount</span>
              <span style="font-size:20px; font-weight:800; color:var(--text-primary);"><?= htmlspecialchars($booking['price']) ?></span>
            </div>

            <?php if ($booking['type'] === 'Upcoming'): ?>
              <form method="POST" action="bookings.php?tab=upcoming" onsubmit="return confirm('Confirm cancellation of this reservation?');">
                <input type="hidden" name="action" value="cancel_booking">
                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
                <button type="submit" class="btn btn-secondary btn-sm" style="color:var(--status-booked); border-color:#f7c5bd; background:#feebe8;">
                  Cancel Booking
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
