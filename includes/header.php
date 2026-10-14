<?php
// includes/header.php - Top Navigation Bar
require_once __DIR__ . '/data.php';
$user = get_current_user_data();
$current_page = basename($_SERVER['PHP_SELF']);
$first_name = $user ? explode(' ', $user['name'])[0] : 'ALEX';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CasaVista Resort &bull; Private Villas &amp; Sports Haven</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-mark">
      <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort logo" class="brand-logo">
      <div class="brand-text">
        <span class="brand-name">CASAVISTA</span>
        <span class="brand-sub">RESORT &bull; CEBU</span>
      </div>
    </a>

    <!-- Navigation Menu (Home, Catalog, Court, Bookings, Profile) -->
    <nav class="nav-menu">
      <a href="home.php" class="nav-link <?= ($current_page == 'home.php') ? 'active' : '' ?>">Home</a>
      <a href="catalog.php" class="nav-link <?= ($current_page == 'catalog.php') ? 'active' : '' ?>">Catalog</a>
      <a href="court.php" class="nav-link <?= ($current_page == 'court.php') ? 'active' : '' ?>">Courts</a>
      <a href="bookings.php" class="nav-link <?= ($current_page == 'bookings.php') ? 'active' : '' ?>">Bookings</a>
      <a href="profile.php" class="nav-link <?= ($current_page == 'profile.php') ? 'active' : '' ?>">Profile</a>
    </nav>

    <!-- User Header Profile & Signout -->
    <div class="header-actions">
      <a href="profile.php" class="user-identity-card" title="View Profile">
        <div class="user-meta-text">
          <span class="user-greeting">Kumusta,</span>
          <span class="user-display-name"><?= htmlspecialchars(strtoupper($first_name)) ?></span>
        </div>
        <img src="<?= htmlspecialchars($user['pfp'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80') ?>" alt="Profile" class="user-avatar-thumb">
      </a>
      <a href="logout.php" class="btn-signout" title="Sign Out" onclick="return confirm('Do you wish to log out?');">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
      </a>
    </div>
  </div>
</header>
