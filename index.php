<?php
// index.php - Public showcase website for first-time visitors
require_once __DIR__ . '/includes/data.php';

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CasaVista Resort &bull; Private Villas &amp; Sports Haven in Cebu</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    :root {
      --page-gutter: clamp(14px, 1.6vw, 24px);
    }

    .public-top-bar {
      width: calc(100% - (var(--page-gutter) * 2));
      margin: 0 auto;
      padding: 16px 8px;
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      gap: 16px;
      position: relative;
      z-index: 20;
      min-height: 112px;
    }

    .public-top-bar > .brand-mark {
      grid-column: 2;
      justify-self: center;
    }

    .public-auth-actions {
      grid-column: 3;
      justify-self: end;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .public-auth-actions .btn {
      white-space: nowrap;
    }

    .hero-editorial {
      width: calc(100% - (var(--page-gutter) * 2));
      min-height: 70vh;
      margin: 0 auto 30px;
      border-radius: 28px;
      box-shadow: var(--shadow-lg);
    }

    @media (max-width: 640px) {
      .public-top-bar {
        padding: 12px 2px;
        min-height: 88px;
        gap: 8px;
      }

      .public-top-bar .brand-mark {
        gap: 8px;
      }

      .public-top-bar .brand-logo {
        width: 54px;
        height: 54px;
      }

      .public-top-bar .brand-name {
        font-size: 13px;
        letter-spacing: 1px;
      }

      .public-top-bar .brand-sub {
        font-size: 8px;
        letter-spacing: 1.5px;
      }

      .public-top-bar .btn-sm {
        padding: 7px 9px;
        font-size: 11px;
      }

      .public-auth-actions {
        gap: 6px;
      }

      .hero-editorial {
        min-height: 62vh;
        border-radius: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Public Top Bar -->
  <header class="public-top-bar">
    <a href="index.php" class="brand-mark">
      <img src="resort_pictures/casavista_logo.jpg" alt="CasaVista Resort logo" class="brand-logo">
      <div class="brand-text">
        <span class="brand-name">CASAVISTA</span>
        <span class="brand-sub">RESORT CEBU</span>
      </div>
    </a>
    <nav class="public-auth-actions" aria-label="Account">
      <a href="login.php" class="btn btn-secondary btn-sm">Sign In</a>
      <a href="signup.php" class="btn btn-primary btn-sm">Sign Up</a>
    </nav>
  </header>

  <!-- Editorial Hero Section -->
  <section class="hero-editorial reveal">
    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1800&q=80" alt="CasaVista Resort Aerial View" class="hero-editorial-bg">
    <div class="hero-editorial-content reveal">
      <span class="hero-editorial-kicker">Private Coastal Sanctuary in Cebu</span>
      <h1 class="hero-editorial-title">Where Coastal Tranquility Meets Championship Athletics</h1>
      <p class="hero-editorial-lead">
        Discover CasaVista: 3 intimate luxury villas, 3 tournament-certified pickleball hardcourts, a full-size FIBA basketball arena, and exclusive full-resort buyout privileges.
      </p>
      <div class="hero-editorial-actions">
        <a href="login.php" class="btn btn-gold" style="padding:14px 32px; font-size:15px;">Book Accommodations &rarr;</a>
      </div>
    </div>
  </section>

  <!-- Content Container -->
  <main class="main-content" style="padding-top:0;">
    <!-- Feature Highlights Trio -->
    <section class="features-trio">
      <div class="feature-panel reveal">
        <div class="feature-panel-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
        </div>
        <h3 class="feature-panel-title">Luxury Villas</h3>
        <p class="feature-panel-desc">
          Individual oceanfront suites and cathedral-ceiling family lofts equipped with private terraces, rainfall showers, and infinity pool access.
        </p>
      </div>

      <div class="feature-panel reveal" style="transition-delay: 200ms;">
        <div class="feature-panel-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
          </svg>
        </div>
        <h3 class="feature-panel-title">Pickleball Courts</h3>
        <p class="feature-panel-desc">
          Tournament-standard acrylic hardcourts with pro LED lighting, shaded benches, ball machines, and certified instructor clinics.
        </p>
      </div>

      <div class="feature-panel reveal" style="transition-delay: 300ms;">
        <div class="feature-panel-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
            <line x1="8" y1="21" x2="16" y2="21"></line>
            <line x1="12" y1="17" x2="12" y2="21"></line>
          </svg>
        </div>
        <h3 class="feature-panel-title">Basketball Court</h3>
        <p class="feature-panel-desc">
          Regulation basketball facility featuring shock-attenuating wood flooring, pro breakaway rims, glass backboards, and electronic scoring.
        </p>
      </div>
    </section>

    <!-- Full Property Buyout Showcase -->
    <section class="reveal" style="background-color:var(--bg-surface); border-radius:var(--radius-lg); border:1px solid var(--border-subtle); overflow:hidden; box-shadow:var(--shadow-md); margin:0 var(--page-gutter) 60px; transition-delay: 150ms;">
      <div style="display:grid; grid-template-columns:1fr 1fr; align-items:center;">
        <div style="padding:56px;">
          <span class="section-kicker">Ultimate Exclusivity</span>
          <h2 style="font-family:var(--font-serif); font-size:36px; line-height:1.2; margin-bottom:16px;">The Entire Resort Reserved for Your Gathering</h2>
          <p style="font-size:15px; color:var(--text-secondary); line-height:1.8; margin-bottom:28px;">
            Hosting an executive company retreat, private wedding celebration, or milestone family gathering? Our full buyout packages grant complete privacy across all 3 villas, 4 sports courts, the oceanfront infinity pool, and the clubhouse bar.
          </p>
          <div style="display:flex; gap:16px; align-items:center;">
            <a href="login.php" class="btn btn-primary">Check Availability &rarr;</a>
            <span style="font-size:14px; font-weight:700; color:var(--gold-600);">From ₱35,000 / day</span>
          </div>
        </div>
        <div style="height:100%; min-height:400px;">
          <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80" alt="Resort Buyout Aerial" style="width:100%; height:100%; object-fit:cover;">
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });

      document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });
  </script>
</body>
</html>
