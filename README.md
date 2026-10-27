# CasaVista Resort &bull; Professional Web Application
Built with PHP, HTML5, CSS3, and JavaScript.

## Highlights of the Design Upgrade
- **Editorial Coastal Luxury Aesthetic**: Clean travertine sand tones (`#f7f4ed`), deep bronze borders (`#463b20`), and a modern geometric sans-serif palette for a refined, non-ornamental look.
- **Zero AI Clutter**: Removed informal emoji overuse and generic AI cartoon icons, replacing them with high-definition resort photography and SVG iconography.
- **Full Desktop Layout**: Responsive navigation header with brand monogram, user greeting, profile thumbnail, and comprehensive footer.
- **All 5 Pages & Public Portal**:
  1. `index.php`: Public guest overview showcasing villas, pickleball courts, and full buyout privileges.
  2. `home.php`: Confirmed upcoming booking hero banner, photo-backed Quick Reservations, and verified bulletins that expand into details.
  3. `catalog.php`: Category filter tabs (`All`, `Rooms (3)`, `Pickleball (3)`, `Basketball (1)`, `Buyout`) with real rates and availability badges.
  4. `court.php`: Interactive court booking engine featuring Pickleball vs Basketball switch, monthly calendar, and sticky order preview.
  5. `bookings.php`: Clean 2-column ledger with status pills (`Confirmed`, `Completed`, `Cancelled`) and cancellation workflow.
  6. `profile.php`: Personal guest credentials, total bookings, nights stayed, edit credentials modal, change avatar modal, and dark mode toggle.

## How to Run Locally
1. Install PHP 7.4 or newer.
2. Open a terminal in the project directory and start the server:
   ```bash
   php -S localhost:8000
   ```
3. Open your browser and go to:
   ```text
   http://localhost:8000
   ```

## Reservations, payment, and agreement
- Accommodation and court reservations go through `payment.php`, where guests select e-wallet or cash at the resort.
- E-wallet selection is a payment preference only. No payment gateway is connected and this site does not collect funds.
- New accounts must accept the User Agreement once at signup. The accepted agreement version and timestamp are stored with the account, and members can review it from their profile or the site footer.

## Before publishing
This project currently uses `includes/storage.json` as a lightweight local data store. It is suitable for a small demo, but not a production booking system: concurrent writes, backups, access controls, and personal-data protection need a production database and deployment configuration. Configure HTTPS, secure PHP sessions, and a real payment provider before accepting online payments. Remove or replace seeded demo account data before launch.
