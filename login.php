<?php
// login.php - Professional split-screen sign in
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
        $error = "Invalid credentials. Use test account: jolu.cabilao@gmail.com / password123";
    }
}

if (isset($_GET['social'])) {
    $data = load_data();
    $_SESSION['user_id'] = $data['users'][0]['id'];
    header("Location: home.php");
    exit;
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
    .auth-split-layout {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
    }
    @media (max-width: 992px) {
      .auth-split-layout { grid-template-columns: 1fr; }
      .auth-visual-pane { display: none; }
    }
    .auth-visual-pane {
      position: relative;
      background-color: #f5f2eb;
      color: #ffffff;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
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
    .auth-visual-pane > div,
    .auth-visual-brand {
      position: relative;
      z-index: 2;
    }
    .auth-visual-brand {
      display: flex;
      align-items: center;
      gap: 14px;
      width: fit-content;
      color: #ffffff;
    }
    .auth-visual-logo {
      display: block;
      width: 78px;
      height: 78px;
      flex: 0 0 78px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.85);
    }
    .auth-form-pane {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 32px;
      gap: 18px;
      background-color: var(--bg-page);
    }
    .auth-card {
      width: 100%;
      max-width: 440px;
      background-color: var(--bg-surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-subtle);
      padding: 44px 40px;
      box-shadow: var(--shadow-md);
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
  <!-- Left Visual Presentation -->
  <div class="auth-visual-pane">
    <img src="resort_pictures/login_background.jpg" alt="" class="auth-background">
    <a href="index.php" class="auth-visual-brand" aria-label="CasaVista Resort home">
      <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort logo" class="auth-visual-logo">
      <span class="brand-text">
        <span class="brand-name" style="color:#ffffff;">CASAVISTA</span>
        <span class="brand-sub">RESORT &bull; CEBU</span>
      </span>
    </a>
    <div>
      <h2 style="font-family:var(--font-serif); font-size:42px; font-weight:700; line-height:1.2; margin-bottom:16px;">Welcome Back to Coastal Serenity</h2>
      <p style="font-size:16px; color:#e0d7c6; line-height:1.75; max-width:480px;">
        Access your reservations, coordinate tournament court slots, or modify your bespoke villa package.
      </p>
    </div>

    <div style="font-size:13px; color:#a69982;">
      &copy; <?= date('Y') ?> CasaVista Resort &bull; Punta Engaño, Cebu
    </div>
  </div>

  <!-- Right Form Pane -->
  <div class="auth-form-pane">
    <div class="auth-card">
      <div style="margin-bottom:28px;">
        <span class="section-kicker">Guest Portal</span>
        <h2 style="font-family:var(--font-serif); font-size:28px; color:var(--text-primary);">Member Sign In</h2>
        <p style="font-size:14px; color:var(--text-secondary); margin-top:4px;">Enter your credentials to manage your stay.</p>
      </div>

      <?php if (!empty($error)): ?>
        <div style="background-color:#feebe8; color:#a33729; border:1px solid #f7c5bd; padding:12px 16px; border-radius:var(--radius-sm); font-size:13px; margin-bottom:20px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-input" value="jolu.cabilao@gmail.com" required placeholder="name@domain.com">
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" value="password123" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:13px; font-size:14.5px; margin-top:6px;">Sign In to Account</button>
      </form>

      <div style="text-align:center; margin:24px 0 14px; position:relative;">
        <span style="background:var(--bg-surface); padding:0 12px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); position:relative; z-index:2;">Or continue with</span>
        <div style="position:absolute; top:50%; left:0; right:0; height:1px; background:var(--border-subtle); z-index:1;"></div>
      </div>

      <div class="social-auth-grid">
        <a href="login.php?social=google" class="social-auth-btn">
          <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5.1 3.7-8.8z"/><path fill="#FBBC05" d="M5.6 14.8c-.3-.8-.4-1.8-.4-2.8s.2-2 .4-2.8L1.9 6.3C.7 8.7 0 10.3 0 12s.7 3.3 1.9 5.7l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2.4-6.4-5.2L1.9 16c1.8 3.7 5.6 7 10.1 7z"/></svg>
          <span>Google</span>
        </a>
        <a href="login.php?social=facebook" class="social-auth-btn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          <span>Facebook</span>
        </a>
      </div>

      <div style="text-align:center; margin-top:28px; font-size:13.5px; color:var(--text-secondary);">
        Don't have an account? <a href="signup.php" style="color:var(--olive-600); font-weight:700;">Sign Up</a>
      </div>
      <div style="text-align:center; margin-top:12px;">
        <a href="index.php" style="color:var(--text-muted); font-size:12.5px;">&larr; Back to Resort Overview</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
