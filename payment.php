<?php
require_once __DIR__ . '/includes/data.php';
require_login();

$user = get_current_user_data();
$data = load_data();
$error = '';
$completed_booking = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'start_room') {
    unset($_SESSION['pending_reservation']);
    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
    $item = null;
    foreach ($data['catalog'] as $catalog_item) {
        if ($catalog_item['id'] === $item_id) {
            $item = $catalog_item;
            break;
        }
    }

    if (!$item || $item['type'] === 'PICKLEBALL' || $item['type'] === 'BASKETBALL' || $item['status'] !== 'Available') {
        $error = 'That accommodation is not available to reserve. Please choose another option.';
    } else {
        $check_in = new DateTimeImmutable('+4 days');
        $_SESSION['pending_reservation'] = [
            'token' => bin2hex(random_bytes(32)),
            'kind' => 'room',
            'item_id' => $item['id'],
            'date' => $check_in->format('Y-m-d')
        ];
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'start_court') {
    unset($_SESSION['pending_reservation']);
    $sport = $_POST['sport'] ?? '';
    $court = trim($_POST['court_name'] ?? '');
    $slot = trim($_POST['time_slot'] ?? '');
    $date_value = trim($_POST['booking_date'] ?? '');
    $allowed_courts = [
        'pickleball' => [
            'Court 1 (Pro Hardcourt)',
            'Court 2 (Open Air Breeze)',
            'Court 3 (Training & Ball Feeder)'
        ],
        'basketball' => ['Main FIBA Basketball Arena']
    ];
    $allowed_slots = ['3-4 PM', '4-5 PM', '5-6 PM', '6-7 PM', '7-8 PM', '8-9 PM'];
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $date_value);
    $date_errors = DateTimeImmutable::getLastErrors();
    $valid_date = $date !== false
        && ($date_errors === false || ($date_errors['warning_count'] === 0 && $date_errors['error_count'] === 0))
        && $date->format('Y-m-d') === $date_value
        && $date_value >= date('Y-m-d');

    if (!isset($allowed_courts[$sport]) || !in_array($court, $allowed_courts[$sport], true)
        || !in_array($slot, $allowed_slots, true) || !$valid_date) {
        $error = 'The court reservation details are invalid. Please select a valid date, court, and time slot.';
    } else {
        $_SESSION['pending_reservation'] = [
            'token' => bin2hex(random_bytes(32)),
            'kind' => 'court',
            'sport' => $sport,
            'court' => $court,
            'slot' => $slot,
            'date' => $date_value
        ];
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'complete_reservation') {
    $pending = $_SESSION['pending_reservation'] ?? null;
    $token = $_POST['reservation_token'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    if (!is_array($pending) || !isset($pending['token']) || !hash_equals($pending['token'], $token)) {
        $error = 'Your reservation session has expired. Please start your booking again.';
    } elseif (!in_array($payment_method, ['E-wallet', 'Cash at resort'], true)) {
        $error = 'Please choose either e-wallet or cash at the resort.';
    } else {
        $title = '';
        $capacity = '';
        $price = '';
        $check_in = '2:00 PM';
        $check_out = '12:00 PM';
        $booking_date = '';

        if (($pending['kind'] ?? '') === 'room') {
            $item = null;
            foreach ($data['catalog'] as $catalog_item) {
                if ($catalog_item['id'] === $pending['item_id']) {
                    $item = $catalog_item;
                    break;
                }
            }

            if (!$item || $item['type'] === 'PICKLEBALL' || $item['type'] === 'BASKETBALL' || $item['status'] !== 'Available') {
                $error = 'That accommodation is no longer available. Please choose another option.';
            } else {
                $title = $item['title'];
                $capacity = $item['subtitle'];
                $price = '₱' . number_format($item['rate']) . ' / night';
                $booking_date = (new DateTimeImmutable($pending['date']))->format('M d, Y');
            }
        } elseif (($pending['kind'] ?? '') === 'court') {
            $sport_type = strtoupper($pending['sport']);
            $rate = null;
            foreach ($data['catalog'] as $catalog_item) {
                if ($catalog_item['type'] === $sport_type) {
                    $rate = $catalog_item['rate'];
                    break;
                }
            }

            if ($rate === null || $pending['date'] < date('Y-m-d')) {
                $error = 'The selected court or date is no longer available. Please start again.';
            } else {
                $title = ucfirst($pending['sport']) . ' ' . $pending['court'] . ' (' . $pending['slot'] . ')';
                $capacity = $pending['sport'] === 'pickleball' ? '4 Players Max' : '10 Players Max';
                $price = '₱' . number_format($rate) . ' / hr';
                $slot_parts = explode('-', $pending['slot']);
                $check_in = trim($slot_parts[0]) . ':00 PM';
                $check_out = trim(str_replace(' PM', '', $slot_parts[1])) . ':00 PM';
                $booking_date = (new DateTimeImmutable($pending['date']))->format('D, M j Y');
            }
        } else {
            $error = 'The reservation details could not be verified. Please start your booking again.';
        }

        if ($error === '') {
            $booking = [
                'id' => 'BK-' . strtoupper(bin2hex(random_bytes(4))),
                'user_id' => $user['id'],
                'title' => $title,
                'type' => 'Upcoming',
                'check_in' => $check_in,
                'check_out' => $check_out,
                'date' => $booking_date,
                'capacity' => $capacity,
                'payment' => $payment_method === 'E-wallet'
                    ? 'E-wallet selected (settle with resort staff)'
                    : 'Cash at resort',
                'price' => $price,
                'status' => 'Confirmed'
            ];
            $data['bookings'][] = $booking;
            foreach ($data['users'] as &$stored_user) {
                if ($stored_user['id'] == $user['id']) {
                    $stored_user['total_bookings'] = ($stored_user['total_bookings'] ?? 0) + 1;
                    break;
                }
            }
            unset($stored_user);
            save_data($data);
            unset($_SESSION['pending_reservation']);
            $completed_booking = $booking;
        }
    }
}

$pending = $_SESSION['pending_reservation'] ?? null;
$summary = null;
if (is_array($pending) && isset($pending['token'])) {
    if (($pending['kind'] ?? '') === 'room') {
        foreach ($data['catalog'] as $catalog_item) {
            if ($catalog_item['id'] === $pending['item_id']) {
                $summary = [
                    'title' => $catalog_item['title'],
                    'detail' => 'One-night stay · ' . $catalog_item['subtitle'],
                    'date' => (new DateTimeImmutable($pending['date']))->format('M d, Y'),
                    'price' => '₱' . number_format($catalog_item['rate']) . ' / night'
                ];
                break;
            }
        }
    } elseif (($pending['kind'] ?? '') === 'court') {
        $court_rate = 0;
        foreach ($data['catalog'] as $catalog_item) {
            if ($catalog_item['type'] === strtoupper($pending['sport'])) {
                $court_rate = $catalog_item['rate'];
                break;
            }
        }
        if ($court_rate > 0) {
            $summary = [
                'title' => ucfirst($pending['sport']) . ' reservation',
                'detail' => $pending['court'] . ' · ' . $pending['slot'],
                'date' => (new DateTimeImmutable($pending['date']))->format('D, M j Y'),
                'price' => '₱' . number_format($court_rate) . ' / hour'
            ];
        }
    }
}
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content payment-page">
  <div class="section-header">
    <span class="section-kicker">Reservation checkout</span>
    <h1 class="section-title"><?= $completed_booking ? 'Reservation received' : 'Review and choose payment' ?></h1>
    <p class="section-description">
      <?= $completed_booking
        ? 'Your reservation is recorded. Our team will help complete payment at the resort.'
        : 'Confirm your reservation details and select how you would like to pay.' ?>
    </p>
  </div>

  <?php if ($error !== ''): ?>
    <div class="form-alert" role="alert"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($completed_booking): ?>
    <section class="checkout-card checkout-complete">
      <span class="checkout-eyebrow">Reservation reference</span>
      <h2><?= htmlspecialchars($completed_booking['id']) ?></h2>
      <p><?= htmlspecialchars($completed_booking['title']) ?> is now listed in your bookings.</p>
      <a href="bookings.php" class="btn btn-primary">View my bookings</a>
    </section>
  <?php elseif ($summary && $pending): ?>
    <div class="checkout-layout">
      <section class="checkout-card">
        <span class="checkout-eyebrow">Reservation details</span>
        <h2><?= htmlspecialchars($summary['title']) ?></h2>
        <p class="checkout-detail"><?= htmlspecialchars($summary['detail']) ?></p>
        <dl class="checkout-meta">
          <div><dt>Reservation date</dt><dd><?= htmlspecialchars($summary['date']) ?></dd></div>
          <div><dt>Guest</dt><dd><?= htmlspecialchars($user['name']) ?></dd></div>
          <div><dt>Rate</dt><dd><?= htmlspecialchars($summary['price']) ?></dd></div>
        </dl>
        <div class="payment-note">
          E-wallet payments are completed with resort staff. This page records your preferred method and does not process or collect funds.
        </div>
      </section>

      <section class="checkout-card">
        <span class="checkout-eyebrow">Payment method</span>
        <h2>How would you like to pay?</h2>
        <form method="POST" action="payment.php" class="payment-form">
          <input type="hidden" name="action" value="complete_reservation">
          <input type="hidden" name="reservation_token" value="<?= htmlspecialchars($pending['token']) ?>">
          <label class="payment-option">
            <input type="radio" name="payment_method" value="E-wallet" required>
            <span><strong>E-wallet</strong><small>Complete payment with resort staff using an available e-wallet.</small></span>
          </label>
          <label class="payment-option">
            <input type="radio" name="payment_method" value="Cash at resort" required>
            <span><strong>Cash at the resort</strong><small>Pay in person at the front desk.</small></span>
          </label>
          <button type="submit" class="btn btn-primary checkout-submit">Confirm reservation</button>
          <a href="catalog.php" class="checkout-cancel">Return to the catalog</a>
        </form>
      </section>
    </div>
  <?php else: ?>
    <section class="checkout-card">
      <h2>No reservation is awaiting payment</h2>
      <p class="checkout-detail">Choose an available accommodation or court to begin a reservation.</p>
      <div class="checkout-actions">
        <a href="catalog.php" class="btn btn-primary">Browse the catalog</a>
        <a href="court.php" class="btn btn-secondary">Book a court</a>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
