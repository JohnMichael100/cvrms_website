<?php
// signup.php - Member Registration
require_once __DIR__ . '/includes/data.php';

$error = '';
$name = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Your password must be at least 8 characters.';
    } elseif (!isset($_POST['agreement'])) {
        $error = 'Please review and accept the User Agreement to create your account.';
    } else {
        $data = load_data();
        $email_exists = false;
        foreach ($data['users'] as $existing_user) {
            if (strtolower($existing_user['email']) === strtolower($email)) {
                $email_exists = true;
                break;
            }
        }

        if ($email_exists) {
            $error = 'An account with that email address already exists. Please sign in instead.';
        } else {
            $new_id = count($data['users']) + 1;
            $new_user = [
                'id' => $new_id,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => '+63 912 345 6789',
                'birthdate' => '2000-01-01',
                'gender' => 'Male',
                'address' => 'Cebu City, Philippines',
                'member_id' => 'CV-' . rand(1000, 9999),
                'pfp' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'total_bookings' => 0,
                'nights_stayed' => 0,
                'agreement_accepted_at' => date(DATE_ATOM),
                'agreement_version' => '2026-10-27'
            ];
            $data['users'][] = $new_user;
            save_data($data);
            $_SESSION['user_id'] = $new_id;
            header("Location: home.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Membership &bull; CasaVista Resort</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .signup-page-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 24px;
      background-color: var(--bg-page);
    }
    .signup-card {
      width: 100%;
      max-width: 480px;
      background-color: var(--bg-surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-subtle);
      padding: 44px 40px;
      box-shadow: var(--shadow-md);
    }
  </style>
</head>
<body>

<div class="signup-page-container">
  <div class="signup-card">
    <div style="text-align:center; margin-bottom:28px;">
      <a href="index.php" class="brand-mark" style="justify-content:center; margin-bottom:16px;">
        <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort logo" class="brand-logo">
      </a>
      <h2 style="font-family:var(--font-serif); font-size:28px; color:var(--text-primary);">Create Your Membership</h2>
      <p style="font-size:14px; color:var(--text-secondary); margin-top:4px;">Gain access to preferred member rates and instant sports reservations.</p>
    </div>

    <?php if (!empty($error)): ?>
      <div style="background-color:#feebe8; color:#a33729; border:1px solid #f7c5bd; padding:12px 16px; border-radius:var(--radius-sm); font-size:13px; margin-bottom:20px;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="signup.php">
      <div class="form-group">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-input" required autocomplete="name" value="<?= htmlspecialchars($name) ?>" placeholder="e.g. John Doe">
      </div>

      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input" required autocomplete="email" value="<?= htmlspecialchars($email) ?>" placeholder="name@domain.com">
      </div>

      <div class="form-group">
        <label class="form-label">Create Password</label>
        <input type="password" name="password" class="form-input" required minlength="8" autocomplete="new-password" placeholder="Minimum 8 characters">
      </div>

      <label class="agreement-checkbox">
        <input type="checkbox" name="agreement" value="accepted" required <?= isset($_POST['agreement']) ? 'checked' : '' ?>>
        <span>I have read and agree to the <a href="agreement.php" target="_blank" rel="noopener">CasaVista User Agreement</a>. This confirmation is required once when creating an account.</span>
      </label>

      <button type="submit" class="btn btn-primary" style="width:100%; padding:13px; font-size:14.5px; margin-top:8px;">Complete Registration</button>
    </form>

    <div style="text-align:center; margin-top:24px; font-size:13.5px; color:var(--text-secondary);">
      Already have an account? <a href="login.php" style="color:var(--olive-600); font-weight:700;">Sign In</a>
    </div>
    <div style="text-align:center; margin-top:10px;">
      <a href="index.php" style="color:var(--text-muted); font-size:12.5px;">&larr; Back to Resort Overview</a>
    </div>
  </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
