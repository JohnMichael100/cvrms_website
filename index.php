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

    /* Fixed top bar calculation */
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

    /* Fixed hero calculation */
    .hero-editorial {
      width: calc(100% - (var(--page-gutter) * 2));
      min-height: 72vh;
      margin: 0 auto 30px;
      border-radius: 28px;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: flex-end;
    }

    /* Resort Key Stats Ribbon */
    .resort-stats-strip {
      width: calc(100% - (var(--page-gutter) * 2));
      margin: 0 auto 50px;
      background-color: var(--bg-surface);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius-lg);
      padding: 24px 32px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      box-shadow: var(--shadow-sm);
    }

    .stat-item {
      text-align: center;
      border-right: 1px solid var(--border-subtle);
      padding: 0 16px;
    }

    .stat-item:last-child {
      border-right: none;
    }

    .stat-number {
      font-family: var(--font-serif);
      font-size: 32px;
      font-weight: 700;
      color: var(--text-primary);
      line-height: 1;
      margin-bottom: 6px;
    }

    .stat-label {
      font-size: 13px;
      color: var(--text-secondary);
      font-weight: 500;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    /* Section Headers */
    .section-intro-center {
      text-align: center;
      max-width: 680px;
      margin: 0 auto 40px;
      padding: 0 16px;
    }

    .section-intro-center h2 {
      font-family: var(--font-serif);
      font-size: clamp(28px, 3.2vw, 38px);
      line-height: 1.25;
      margin-top: 6px;
      color: var(--text-primary);
    }

    .section-intro-center p {
      font-size: 15px;
      color: var(--text-secondary);
      margin-top: 10px;
      line-height: 1.6;
    }

    /* Villa Showcase Cards */
    .villas-showcase-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin: 0 var(--page-gutter) 60px;
    }

    .villa-card {
      background-color: var(--bg-surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-subtle);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      display: flex;
      flex-direction: column;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .villa-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-md);
    }

    .villa-card-image {
      width: 100%;
      height: 240px;
      object-fit: cover;
    }

    .villa-card-body {
      padding: 24px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .villa-meta {
      display: flex;
      gap: 12px;
      font-size: 12.5px;
      color: var(--text-muted);
      margin: 10px 0 14px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border-subtle);
    }

    .villa-price-row {
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-top: 14px;
    }

    /* Editorial Quote Banner */
    .editorial-quote-section {
      width: calc(100% - (var(--page-gutter) * 2));
      margin: 0 auto 60px;
      background-color: var(--bg-surface-alt);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius-lg);
      padding: 56px 40px;
      text-align: center;
    }

    .editorial-quote-text {
      font-family: var(--font-serif);
      font-size: clamp(22px, 2.5vw, 30px);
      font-style: italic;
      color: var(--text-primary);
      max-width: 800px;
      margin: 0 auto 16px;
      line-height: 1.45;
    }

    .editorial-quote-author {
      font-size: 13.5px;
      font-weight: 700;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: var(--gold-600);
    }

    @media (max-width: 992px) {
      .resort-stats-strip {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
      .stat-item:nth-child(2) {
        border-right: none;
      }
      .villas-showcase-grid {
        grid-template-columns: 1fr;
      }
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

      .resort-stats-strip {
        grid-template-columns: 1fr;
      }
      .stat-item {
        border-right: none;
        border-bottom: 1px solid var(--border-subtle);
        padding-bottom: 14px;
      }
      .stat-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
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
      <h1 class="hero-editorial-title">Where the shoreline meets quiet luxury</h1>
      <p class="hero-editorial-lead">
        Discover CasaVista: 3 intimate luxury villas, 3 certified pickleball courts, a full-size basketball court, and exclusive full-resort buyout privileges.
      </p>
      <div class="hero-editorial-actions">
        <a href="login.php" class="btn btn-gold" style="padding:14px 32px; font-size:15px;">Book Accommodations &rarr;</a>
      </div>
    </div>
  </section>

  <!-- Quick Resort Stats Strip -->
  <div class="resort-stats-strip reveal">
    <div class="stat-item">
      <div class="stat-number">3</div>
      <div class="stat-label">Luxury Villas</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">3</div>
      <div class="stat-label">Pickleball Courts</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">1</div>
      <div class="stat-label">Regulation Court</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">100%</div>
      <div class="stat-label">Secluded Privacy</div>
    </div>
  </div>

  <!-- Content Container -->
  <main class="main-content" style="padding-top:0;">
    
    <!-- Section Introduction -->
    <div class="section-intro-center reveal">
      <span class="section-kicker">Recreation &amp; Wellness</span>
      <h2>Designed for Rest, Built for Play</h2>
      <p>Whether you're serving on tournament courts or watching the tide recede from your private veranda, every corner of CasaVista invites effortless living.</p>
    </div>

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

      <div class="feature-panel reveal" style="transition-delay: 150ms;">
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

      <div class="feature-panel reveal" style="transition-delay: 250ms;">
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

    <!-- Accommodations Preview -->
    <div class="section-intro-center reveal" style="margin-top:60px;">
      <span class="section-kicker">Intimate Living</span>
      <h2>The Accommodations</h2>
      <p>Three meticulously curated villas offering uncompromised privacy, tailored natural textures, and uninterrupted coastal vistas.</p>
    </div>

    <section class="villas-showcase-grid">
      <!-- Villa 1 -->
      <article class="villa-card reveal">
        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Villa Mar Suite" class="villa-card-image">
        <div class="villa-card-body">
          <span class="section-kicker">Oceanfront Suite</span>
          <h3 style="font-family:var(--font-serif); font-size:22px; margin:4px 0 8px;">Villa Mar</h3>
          <p style="font-size:14px; color:var(--text-secondary); line-height:1.6;">Direct access to the white sand shore, featuring an expansive open-air bath and king suite.</p>
          <div class="villa-meta">
            <span>&bull; Up to 2 Guests</span>
            <span>&bull; 1 King Bed</span>
            <span>&bull; Sea View</span>
          </div>
          <div class="villa-price-row">
            <span style="font-size:14px; font-weight:700; color:var(--gold-600);">₱7,500 <small style="font-weight:400; color:var(--text-muted);">/ night</small></span>
            <a href="login.php" class="btn btn-secondary btn-sm">View Details</a>
          </div>
        </div>
      </article>

      <!-- Villa 2 -->
      <article class="villa-card reveal" style="transition-delay: 150ms;">
        <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=800&q=80" alt="Villa Sol Loft" class="villa-card-image">
        <div class="villa-card-body">
          <span class="section-kicker">Family Haven</span>
          <h3 style="font-family:var(--font-serif); font-size:22px; margin:4px 0 8px;">Villa Sol</h3>
          <p style="font-size:14px; color:var(--text-secondary); line-height:1.6;">Two-story loft layout with cathedral ceilings, private balcony, and poolside terrace.</p>
          <div class="villa-meta">
            <span>&bull; Up to 4 Guests</span>
            <span>&bull; 2 Queen Beds</span>
            <span>&bull; Pool Access</span>
          </div>
          <div class="villa-price-row">
            <span style="font-size:14px; font-weight:700; color:var(--gold-600);">₱11,000 <small style="font-weight:400; color:var(--text-muted);">/ night</small></span>
            <a href="login.php" class="btn btn-secondary btn-sm">View Details</a>
          </div>
        </div>
      </article>

      <!-- Villa 3 -->
      <article class="villa-card reveal" style="transition-delay: 250ms;">
        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Villa Luna Master" class="villa-card-image">
        <div class="villa-card-body">
          <span class="section-kicker">Presidential Master</span>
          <h3 style="font-family:var(--font-serif); font-size:22px; margin:4px 0 8px;">Villa Luna</h3>
          <p style="font-size:14px; color:var(--text-secondary); line-height:1.6;">Our premier master retreat with a private garden patio, outdoor shower, and plunge lounge.</p>
          <div class="villa-meta">
            <span>&bull; Up to 4 Guests</span>
            <span>&bull; 1 King + 1 Daybed</span>
            <span>&bull; Garden Deck</span>
          </div>
          <div class="villa-price-row">
            <span style="font-size:14px; font-weight:700; color:var(--gold-600);">₱13,500 <small style="font-weight:400; color:var(--text-muted);">/ night</small></span>
            <a href="login.php" class="btn btn-secondary btn-sm">View Details</a>
          </div>
        </div>
      </article>
    </section>

    <!-- Editorial Quote Section -->
    <section class="editorial-quote-section reveal">
      <span class="section-kicker">The CasaVista Experience</span>
      <blockquote class="editorial-quote-text">
        &ldquo;The quiet exclusivity here is unmatched. Playing championship pickleball in the morning and retreating to a secluded villa by the sea made our team retreat unforgettable.&rdquo;
      </blockquote>
      <div class="editorial-quote-author">&mdash; Verified Guest Review &bull; Cebu Private Retreat</div>
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
          <div style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
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