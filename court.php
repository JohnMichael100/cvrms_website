<?php
// court.php - Sports Court Reservation Engine
require_once __DIR__ . '/includes/data.php';
require_login();

$sport = isset($_GET['type']) ? strtolower($_GET['type']) : 'pickleball';
if (!in_array($sport, ['pickleball', 'basketball'])) {
    $sport = 'pickleball';
}

$selected_date = date('Y-m-d');
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content">
  <div class="section-header">
    <span class="section-kicker">Recreational Facilities</span>
    <h1 class="section-title">Sports Court Booking</h1>
    <p class="section-description">
      Book your 1-hour session on our 3 certified pickleball hardcourts or the FIBA basketball arena.
    </p>
  </div>

  <div class="court-studio-grid">
    <!-- Left Configuration Panel -->
    <div class="panel-card">
      <!-- 2 Options: Pickleball or Basketball Switch Bar -->
      <div class="sport-switch-bar">
        <a href="court.php?type=pickleball" class="sport-switch-btn <?= ($sport === 'pickleball') ? 'active' : '' ?>">
          Pickleball (3 Courts)
        </a>
        <a href="court.php?type=basketball" class="sport-switch-btn <?= ($sport === 'basketball') ? 'active' : '' ?>">
          Basketball (1 Court)
        </a>
      </div>

      <!-- Calendar Component -->
      <span class="selector-label">1. Select Reservation Date</span>
      <div class="calendar-widget">
        <div class="cal-header-row">
          <button type="button" class="cal-nav-btn" onclick="prevMonth()">&larr;</button>
          <div class="cal-month-title" id="calendarMonthYear"><?= htmlspecialchars(date('F Y')) ?></div>
          <button type="button" class="cal-nav-btn" onclick="nextMonth()">&rarr;</button>
        </div>

        <div class="calendar-days-grid">
          <div class="day-header">Sun</div>
          <div class="day-header">Mon</div>
          <div class="day-header">Tue</div>
          <div class="day-header">Wed</div>
          <div class="day-header">Thu</div>
          <div class="day-header">Fri</div>
          <div class="day-header">Sat</div>
          <div id="calendarDates" style="display: contents;"></div>
        </div>
      </div>

      <!-- Form Submission -->
      <form method="POST" action="payment.php" id="courtReservationForm">
        <input type="hidden" name="action" value="start_court">
        <input type="hidden" name="sport" value="<?= htmlspecialchars($sport) ?>">
        <input type="hidden" name="booking_date" id="selectedDateInput" value="<?= htmlspecialchars($selected_date) ?>">
        <input type="hidden" name="court_name" id="selectedCourtInput" value="<?= ($sport === 'pickleball') ? 'Court 1 (Pro Hardcourt)' : 'Main FIBA Basketball Arena' ?>">
        <input type="hidden" name="time_slot" id="selectedSlotInput" value="3-4 PM">

        <!-- Court Options -->
        <span class="selector-label">2. Select Court</span>
        <div class="court-options-grid" id="courtSelectorContainer">
          <?php if ($sport === 'pickleball'): ?>
            <div class="option-pill-btn active" onclick="selectCourt(this, 'Court 1 (Pro Hardcourt)')">Court 1 (Pro Hardcourt)</div>
            <div class="option-pill-btn" onclick="selectCourt(this, 'Court 2 (Open Air Breeze)')">Court 2 (Open Air)</div>
            <div class="option-pill-btn" onclick="selectCourt(this, 'Court 3 (Training &amp; Ball Feeder)')">Court 3 (Training)</div>
          <?php else: ?>
            <div class="option-pill-btn active" style="grid-column:span 3;" onclick="selectCourt(this, 'Main FIBA Basketball Arena')">
              Main Basketball Arena &bull; Shock-Absorbing Wood &bull; Pro Glass Backboards
            </div>
          <?php endif; ?>
        </div>

        <!-- 1-Hour Time Slots -->
        <span class="selector-label">3. Select 1-Hour Time Slot</span>
        <div class="time-slots-grid">
          <div class="option-pill-btn active" onclick="selectSlot(this, '3-4 PM')">3:00 PM - 4:00 PM</div>
          <div class="option-pill-btn" onclick="selectSlot(this, '4-5 PM')">4:00 PM - 5:00 PM</div>
          <div class="option-pill-btn" onclick="selectSlot(this, '5-6 PM')">5:00 PM - 6:00 PM</div>
          <div class="option-pill-btn" onclick="selectSlot(this, '6-7 PM')">6:00 PM - 7:00 PM</div>
          <div class="option-pill-btn" onclick="selectSlot(this, '7-8 PM')">7:00 PM - 8:00 PM</div>
          <div class="option-pill-btn" onclick="selectSlot(this, '8-9 PM')">8:00 PM - 9:00 PM</div>
        </div>
      </form>
    </div>

    <!-- Right Summary Sticky Panel -->
    <aside class="panel-card summary-sticky-card">
      <h3 class="summary-card-title">Reservation Summary</h3>

      <img src="<?= ($sport === 'pickleball') ? 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?auto=format&fit=crop&w=800&q=80' : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80' ?>" alt="Court Visual" class="summary-preview-img">

      <div class="summary-meta-table">
        <div class="summary-row">
          <span class="label">Sport</span>
          <span class="val"><?= ucfirst($sport) ?></span>
        </div>
        <div class="summary-row">
          <span class="label">Facility</span>
          <span class="val" id="summaryCourtDisplay"><?= ($sport === 'pickleball') ? 'Court 1 (Pro Hardcourt)' : 'Main FIBA Basketball Arena' ?></span>
        </div>
        <div class="summary-row">
          <span class="label">Date</span>
          <span class="val" id="summaryDateDisplay"><?= htmlspecialchars(date('D, M j Y')) ?></span>
        </div>
        <div class="summary-row">
          <span class="label">Slot</span>
          <span class="val" id="summarySlotDisplay">3:00 PM - 4:00 PM (1 Hour)</span>
        </div>
        <div class="summary-row">
          <span class="label">Night Lighting</span>
          <span class="val" style="color:var(--status-confirmed);">Included</span>
        </div>
      </div>

      <div class="summary-total-row">
        <div>
          <span style="font-size:12px; font-weight:700; text-transform:uppercase; color:var(--text-muted); display:block;">Rental Rate</span>
          <span style="font-size:13px; color:var(--text-secondary);">Tax &amp; Service Included</span>
        </div>
        <div class="summary-total-figure" id="summaryPriceDisplay"><?= ($sport === 'pickleball') ? '₱350' : '₱800' ?></div>
      </div>

      <button type="button" class="btn btn-primary" style="width:100%; padding:14px; font-size:15px;" onclick="document.getElementById('courtReservationForm').submit()">
        Confirm Court Reservation
      </button>

      <p style="font-size:12px; color:var(--text-muted); text-align:center; margin-top:14px; line-height:1.5;">
        Paddles, balls, and hydration towels are provided at courtside reception.
      </p>
    </aside>
  </div>
</main>

<script>
const today = new Date();
let curYear = today.getFullYear();
let curMonth = today.getMonth();
let selectedDay = today.getDate();

const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

function renderCalendar() {
  const container = document.getElementById('calendarDates');
  container.innerHTML = '';
  document.getElementById('calendarMonthYear').innerText = `${monthNames[curMonth]} ${curYear}`;

  const firstDayIndex = new Date(curYear, curMonth, 1).getDay();
  const totalDays = new Date(curYear, curMonth + 1, 0).getDate();
  const prevTotalDays = new Date(curYear, curMonth, 0).getDate();

  for (let i = firstDayIndex - 1; i >= 0; i--) {
    const div = document.createElement('div');
    div.className = 'day-cell muted';
    div.innerText = prevTotalDays - i;
    container.appendChild(div);
  }

  for (let day = 1; day <= totalDays; day++) {
    const div = document.createElement('div');
    div.className = 'day-cell';
    const date = new Date(curYear, curMonth, day);
    const isPast = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    if (isPast) div.classList.add('muted');
    if (day === selectedDay && !isPast) div.classList.add('active');
    div.innerText = day;
    if (!isPast) div.onclick = () => selectDay(day);
    container.appendChild(div);
  }
}

function selectDay(day) {
  selectedDay = day;
  renderCalendar();
  const d = new Date(curYear, curMonth, day);
  document.getElementById('selectedDateInput').value = `${curYear}-${String(curMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
  document.getElementById('summaryDateDisplay').innerText = `${dayNames[d.getDay()]}, ${monthNames[curMonth].substring(0,3)} ${day} ${curYear}`;
}

function prevMonth() {
  if (curYear === today.getFullYear() && curMonth <= today.getMonth()) return;
  curMonth--;
  if (curMonth < 0) { curMonth = 11; curYear--; }
  selectedDay = 1;
  renderCalendar();
  selectDay(Math.max(1, curYear === today.getFullYear() && curMonth === today.getMonth() ? today.getDate() : 1));
}

function nextMonth() {
  curMonth++;
  if (curMonth > 11) { curMonth = 0; curYear++; }
  selectedDay = 1;
  renderCalendar();
  selectDay(1);
}

function selectCourt(el, courtName) {
  document.querySelectorAll('#courtSelectorContainer .option-pill-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('selectedCourtInput').value = courtName;
  document.getElementById('summaryCourtDisplay').innerText = courtName;
}

function selectSlot(el, slot) {
  el.parentElement.querySelectorAll('.option-pill-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('selectedSlotInput').value = slot;
  document.getElementById('summarySlotDisplay').innerText = `${slot} (1 Hour)`;
}

window.addEventListener('DOMContentLoaded', () => {
  renderCalendar();
  selectDay(selectedDay);
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
