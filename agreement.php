<?php
require_once __DIR__ . '/includes/data.php';

$logged_in = get_current_user_data() !== null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Agreement | CasaVista Resort</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="agreement-page">
  <a href="<?= $logged_in ? 'profile.php' : 'signup.php' ?>" class="agreement-back">
    <?= $logged_in ? 'Return to your profile' : 'Return to registration' ?>
  </a>
  <article class="agreement-card">
    <span class="section-kicker">CasaVista Resort</span>
    <h1 class="section-title">User Agreement</h1>
    <p class="agreement-updated">Effective October 27, 2026</p>
    <p>By creating a CasaVista guest account, you agree to the following terms for using this website and its reservation services.</p>

    <h2>Account information</h2>
    <p>You are responsible for providing accurate contact details and keeping your sign-in credentials private. Notify the resort if you believe someone has accessed your account without permission.</p>

    <h2>Reservations and payment</h2>
    <p>Reservation details and rates are shown before you confirm. Availability and reservation requests are subject to resort confirmation. Selecting e-wallet records your preferred payment method; payment is completed with resort staff. This website does not currently collect or process online payments. Cash payments are made at the resort.</p>

    <h2>Changes and cancellations</h2>
    <p>Please contact CasaVista directly for changes, cancellation terms, refunds, and accessibility or stay-related requests. The resort's applicable policies and any confirmation provided to you govern your reservation.</p>

    <h2>Acceptable use</h2>
    <p>Use the guest portal lawfully and do not interfere with its operation, attempt unauthorized access, or submit information that is false or belongs to another person.</p>

    <h2>Privacy and updates</h2>
    <p>Account information is used to manage guest access and reservations. The resort may update these terms as its services change and will communicate material changes through the contact details associated with your account.</p>

    <div class="agreement-actions">
      <a href="<?= $logged_in ? 'profile.php' : 'signup.php' ?>" class="btn btn-primary">
        <?= $logged_in ? 'Return to your profile' : 'Return to registration' ?>
      </a>
    </div>
  </article>
</main>
<script src="assets/js/main.js"></script>
</body>
</html>
