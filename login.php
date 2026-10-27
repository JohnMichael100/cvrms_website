<?php
// login.php - CasaVista styling with Southwestern layout & logo placement
require_once __DIR__ . '/includes/data.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $data = load_data();
    $found = false;
    foreach ($data['users'] as $u) {
        if (strtolower($u['email']) === strtolower($email) && $u['password'] === $password) {
            $_SESSION['user_id'] = $u['id'];
            $found = true;
            header("Location: home.php");
            exit;
        }
    }
    if (!$found) {
        $error = 'Email or password is incorrect.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In &bull; CasaVista Resort Guest Portal</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    :root {
      --bg-page: #f8f6f0;
      --bg-surface: #ffffff;
      --bg-surface-alt: #f4efe6;
      --text-primary: #2d261e;
      --text-secondary: #706354;
      --text-muted: #9c8e7e;
      --border-subtle: #e6dfd5;
      --border-strong: #d4c9b9;
      --olive-600: #4a3e2c;
      --olive-700: #382e20;
      --radius-sm: 6px;
      --radius-lg: 14px;
      --shadow-md: 0 10px 30px rgba(0,0,0,0.06);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: var(--bg-page);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      color: var(--text-primary);
    }

    .auth-split-layout {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      position: relative;
    }

    @media (max-width: 992px) {
      .auth-split-layout { 
        grid-template-columns: 1fr; 
      }
      .auth-visual-pane { 
        display: none; 
      }
    }

    /* Left Visual Presentation */
    .auth-visual-pane {
      position: relative;
      background-color: #f5f2eb;
      padding: 60px 48px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
    }

    .auth-background {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 1;
      z-index: 1;
    }

    /* Southwestern-style Centered Brand Area */
    .left-center-brand {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      max-width: 520px;
      margin: auto 0;
    }

    .brand-center-seal {
      width: 155px;
      height: 155px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid rgba(255, 255, 255, 0.95);
      box-shadow: 0 10px 28px rgba(0, 0, 0, 0.15);
      margin-bottom: 24px;
      background: #ffffff;
    }

    .left-center-brand h2 {
      font-size: 38px;
      font-weight: 700;
      color: #2b231a;
      line-height: 1.25;
      margin-bottom: 14px;
      text-shadow: 0 1px 2px rgba(255,255,255,0.6);
    }

    .left-center-brand p {
      font-size: 15.5px;
      color: #55483a;
      line-height: 1.65;
    }

    .auth-visual-footer {
      position: relative;
      z-index: 2;
      font-size: 13px;
      color: #8a7c6b;
      margin-top: auto;
    }

    /* Right Form Pane */
    .auth-form-pane {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 32px;
      background-color: var(--bg-page);
    }

    .auth-card {
      width: 100%;
      max-width: 440px;
      background-color: var(--bg-surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-subtle);
      padding: 40px 38px;
      box-shadow: var(--shadow-md);
    }

    .section-kicker {
      display: inline-block;
      font-size: 11.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: var(--text-muted);
      margin-bottom: 4px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-primary);
    }

    .form-input {
      width: 100%;
      padding: 11px 14px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--border-strong);
      background-color: #faf9f6;
      font-size: 14px;
      color: var(--text-primary);
      outline: none;
      transition: border-color 0.2s;
    }

    .form-input:focus {
      border-color: var(--olive-600);
      background-color: #ffffff;
    }

    .btn-primary {
      background-color: var(--olive-600);
      color: #ffffff;
      border: none;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-weight: 600;
      transition: background 0.2s;
    }

    .btn-primary:hover {
      background-color: var(--olive-700);
    }

    .social-auth-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-top: 18px;
    }

    .social-auth-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 10px 16px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--border-strong);
      background-color: var(--bg-surface);
      color: var(--text-primary);
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .social-auth-btn:hover {
      background-color: var(--bg-surface-alt);
    }
  </style>
</head>
<body>

<div class="auth-split-layout">
  <!-- Left Visual Presentation (SWU Centered Layout) -->
  <div class="auth-visual-pane">
    <img src="resort_pictures/login_background.jpg" alt="" class="auth-background">

    <!-- Centered Seal and Heading -->
    <div class="left-center-brand">
      <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort Seal" class="brand-center-seal">
      <h2>CASAVISTA</h2>
      <p>Access your reservations, coordinate tournament court slots, or modify your bespoke villa package.</p>
    </div>

    <div class="auth-visual-footer">
      &copy; <?= date('Y') ?> CasaVista Resort &bull; Punta Engaño, Cebu
    </div>
  </div>

  <!-- Right Form Pane -->
  <div class="auth-form-pane">
    <!-- Auth Card -->
    <div class="auth-card">
      <div style="margin-bottom:24px;">
        <span class="section-kicker">Guest Portal</span>
        <h2 style="font-size:26px; color:var(--text-primary);">Member Sign In</h2>
        <p style="font-size:13.5px; color:var(--text-secondary); margin-top:4px;">Enter your credentials to manage your stay.</p>
      </div>

      <?php if (!empty($error)): ?>
        <div style="background-color:#feebe8; color:#a33729; border:1px solid #f7c5bd; padding:12px 16px; border-radius:var(--radius-sm); font-size:13px; margin-bottom:20px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-input" required autocomplete="email" placeholder="name@domain.com">
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" required autocomplete="current-password" placeholder="Enter your password">
        </div>

        <button type="submit" class="btn-primary" style="width:100%; padding:13px; font-size:14.5px; margin-top:6px;">Sign In to Account</button>
      </form>

      <div style="text-align:center; margin-top:26px; font-size:13.5px; color:var(--text-secondary);">
        Don't have an account? <a href="signup.php" style="color:var(--olive-600); font-weight:700;">Sign Up</a>
      </div>
      <div style="text-align:center; margin-top:12px;">
        <a href="index.php" style="color:var(--text-muted); font-size:12.5px;">&larr; Back to Resort Overview</a>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>