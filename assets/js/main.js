// assets/js/main.js - CasaVista Resort Client Interactions
document.addEventListener('DOMContentLoaded', () => {
  const motionTargets = new Set(
    document.querySelectorAll([
      '.reveal',
      '.public-top-bar',
      '.site-header',
      '.main-content > *',
      '.main-content section',
      '.main-content .catalog-grid > *',
      '.main-content .ledger-grid > *',
      '.main-content .quick-reserve-grid > *',
      '.main-content .profile-layout-grid > *',
      '.main-content .catalog-card',
      '.main-content .ledger-card',
      '.main-content .panel-card',
      '.main-content .quick-card',
      '.main-content .announcement-card',
      '.main-content .feature-panel',
      '.main-content .villa-card',
      '.auth-card',
      '.auth-visual-brand',
      '.left-center-brand',
      '.auth-visual-footer',
      '.signup-page-container > *',
      '.signup-card',
      '.site-footer .footer-top > *',
      '.site-footer .footer-bottom-inner'
    ].join(','))
  );

  if (motionTargets.size) {
    document.documentElement.classList.add('motion-ready');

    if ('IntersectionObserver' in window) {
      const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });

      motionTargets.forEach((element) => {
        element.classList.add('scroll-reveal');
        revealObserver.observe(element);
      });
    } else {
      motionTargets.forEach((element) => element.classList.add('visible'));
    }
  }

  // Theme check
  const savedTheme = localStorage.getItem('casavista_theme');
  const toggle = document.getElementById('darkModeToggle');
  
  if (savedTheme === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
    if (toggle) toggle.checked = true;
  } else {
    document.documentElement.removeAttribute('data-theme');
    if (toggle) toggle.checked = false;
  }
});

function toggleTheme(checkbox) {
  if (checkbox.checked) {
    document.documentElement.setAttribute('data-theme', 'dark');
    localStorage.setItem('casavista_theme', 'dark');
  } else {
    document.documentElement.removeAttribute('data-theme');
    localStorage.setItem('casavista_theme', 'light');
  }
}
