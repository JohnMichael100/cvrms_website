<?php
// profile.php - User credentials, change pfp, dark mode, logout
require_once __DIR__ . '/includes/data.php';
require_login();

$user = get_current_user_data();
$data = load_data();
$notice = '';
$notice_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
        $name = trim($_POST['name'] ?? $user['name']);
        $phone = trim($_POST['phone'] ?? $user['phone']);
        $birthdate = trim($_POST['birthdate'] ?? $user['birthdate']);
        $gender = trim($_POST['gender'] ?? $user['gender']);
        $address = trim($_POST['address'] ?? $user['address']);

        foreach ($data['users'] as &$u) {
            if ($u['id'] == $user['id']) {
                $u['name'] = $name;
                $u['phone'] = $phone;
                $u['birthdate'] = $birthdate;
                $u['gender'] = $gender;
                $u['address'] = $address;
                break;
            }
        }
        save_data($data);
        $user = get_current_user_data();
        $notice = "Personal credentials updated successfully.";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_avatar') {
        $max_avatar_size = 5 * 1024 * 1024;
        $allowed_image_types = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp'
        ];
        $avatar_file = $_FILES['avatar'] ?? null;

        if (!is_array($avatar_file) || !isset($avatar_file['error'], $avatar_file['tmp_name'], $avatar_file['size'])) {
            $notice = "Choose an image file to upload.";
            $notice_type = 'error';
        } elseif ($avatar_file['error'] !== UPLOAD_ERR_OK) {
            $notice = in_array($avatar_file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)
                ? "The selected image is too large. Choose an image no larger than 5 MB."
                : "The image could not be uploaded. Please choose another file and try again.";
            $notice_type = 'error';
        } elseif ($avatar_file['size'] > $max_avatar_size) {
            $notice = "The selected image is too large. Choose an image no larger than 5 MB.";
            $notice_type = 'error';
        } else {
            $image_info = getimagesize($avatar_file['tmp_name']);
            $mime_type = is_array($image_info) ? ($image_info['mime'] ?? '') : '';

            if (!isset($allowed_image_types[$mime_type])) {
                $notice = "Choose a valid JPG, PNG, GIF, or WebP image.";
                $notice_type = 'error';
            } else {
                $upload_directory = __DIR__ . '/uploads/profile-pictures';
                if (!is_dir($upload_directory) && !mkdir($upload_directory, 0755, true) && !is_dir($upload_directory)) {
                    $notice = "The profile picture could not be saved. Please try again later.";
                    $notice_type = 'error';
                } else {
                    $filename = bin2hex(random_bytes(16)) . '.' . $allowed_image_types[$mime_type];
                    $upload_path = $upload_directory . '/' . $filename;

                    if (!move_uploaded_file($avatar_file['tmp_name'], $upload_path)) {
                        $notice = "The profile picture could not be saved. Please try again.";
                        $notice_type = 'error';
                    } else {
                        foreach ($data['users'] as &$u) {
                            if ($u['id'] == $user['id']) {
                                $u['pfp'] = 'uploads/profile-pictures/' . $filename;
                                break;
                            }
                        }
                        unset($u);
                        save_data($data);
                        $user = get_current_user_data();
                        $notice = "Profile picture updated successfully.";
                    }
                }
            }
        }
    }
}
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="main-content">
  <div class="section-header">
    <span class="section-kicker">Member Account</span>
    <h1 class="section-title">Profile &amp; Credentials</h1>
    <p class="section-description">
      Manage your registered guest details, change profile picture, and configure display preferences.
    </p>
  </div>

  <?php if (!empty($notice)): ?>
    <div style="<?= $notice_type === 'error' ? 'background-color:#fff0ed; color:#9b2c1c; border:1px solid #f2c2b9;' : 'background-color:#eaf5ee; color:#1f693b; border:1px solid #c7e5d2;' ?> padding:16px 20px; border-radius:var(--radius-sm); font-size:14px; font-weight:600; margin-bottom:28px;">
      <?= htmlspecialchars($notice) ?>
    </div>
  <?php endif; ?>

  <div class="profile-layout-grid">
    <!-- Left Column: Avatar & Quick Stats -->
    <div>
      <div class="panel-card profile-card-center">
        <div class="profile-avatar-frame">
          <img src="<?= htmlspecialchars($user['pfp']) ?>" alt="Avatar" class="profile-avatar-img">
          <button type="button" class="avatar-edit-icon" onclick="openAvatarModal()" aria-label="Change profile picture" title="Change Profile Picture">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9"></path>
              <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
          </button>
        </div>

        <h2 class="profile-name" style="font-family:var(--font-serif); font-size:22px; color:var(--text-primary); margin-bottom:4px;">
          <?= htmlspecialchars($user['name']) ?>
        </h2>
        <div class="profile-email" style="font-size:13.5px; color:var(--text-secondary); margin-bottom:12px;"><?= htmlspecialchars($user['email']) ?></div>
        
        <span class="badge" style="background:var(--bg-surface-alt); color:var(--olive-600);">
          MEMBER ID: <?= htmlspecialchars($user['member_id']) ?>
        </span>

        <div class="profile-stats-grid">
          <div class="stat-box">
            <div class="stat-number"><?= htmlspecialchars($user['total_bookings']) ?></div>
            <div class="stat-label">Total Bookings</div>
          </div>
          <div class="stat-box">
            <div class="stat-number"><?= htmlspecialchars($user['nights_stayed']) ?></div>
            <div class="stat-label">Nights Stayed</div>
          </div>
        </div>

        <div style="margin-top:28px;">
          <a href="logout.php" class="btn btn-secondary btn-sm" style="width:100%; color:var(--status-booked); border-color:#f7c5bd;" onclick="return confirm('Do you wish to log out?');">
            Log Out of Account
          </a>
        </div>
      </div>
    </div>

    <!-- Right Column: Personal Information Table & Preferences -->
    <div>
      <div class="panel-card">
        <div class="profile-section-heading" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--border-subtle);">
          <h3 style="font-family:var(--font-serif); font-size:22px; color:var(--text-primary);">Personal Information</h3>
          <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal()">Edit Information</button>
        </div>

        <div class="agreement-status">
          <div>
            <strong>User Agreement</strong>
            <span>
              <?= !empty($user['agreement_accepted_at'])
                ? 'Accepted on ' . htmlspecialchars(date('M j, Y', strtotime($user['agreement_accepted_at'])))
                : 'No signup acceptance is recorded for this existing account.' ?>
            </span>
          </div>
          <a href="agreement.php" class="btn btn-secondary btn-sm">Review agreement</a>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Full Name</div>
            <div class="profile-detail-value"><?= htmlspecialchars($user['name']) ?></div>
          </div>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Registered Email</div>
            <div class="profile-detail-value"><?= htmlspecialchars($user['email']) ?></div>
          </div>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Mobile Contact</div>
            <div class="profile-detail-value"><?= htmlspecialchars($user['phone']) ?></div>
          </div>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Birthdate</div>
            <div class="profile-detail-value"><?= htmlspecialchars(date('F j, Y', strtotime($user['birthdate']))) ?></div>
          </div>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Gender</div>
            <div class="profile-detail-value"><?= htmlspecialchars($user['gender']) ?></div>
          </div>
        </div>

        <div class="profile-detail-row">
          <div>
            <div class="profile-detail-label">Registered Home Address</div>
            <div class="profile-detail-value"><?= htmlspecialchars($user['address']) ?></div>
          </div>
        </div>

        <div class="profile-theme-row" style="margin-top:36px; padding-top:24px; border-top:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div style="font-size:15px; font-weight:700; color:var(--text-primary);">Dark Mode Theme</div>
            <div style="font-size:13px; color:var(--text-muted);">Adjust screen contrast for low-light environments</div>
          </div>
          <label class="switch">
            <input type="checkbox" id="darkModeToggle" onchange="toggleTheme(this)">
            <span class="slider"></span>
          </label>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal: Edit Profile -->
<div class="modal-backdrop" id="editProfileModal">
  <div class="modal-dialog">
    <div class="modal-header">
      <h3 style="font-family:var(--font-serif); font-size:20px; color:var(--text-primary);">Edit Personal Details</h3>
      <button class="modal-close-btn" onclick="closeEditModal()">&times;</button>
    </div>
    <div class="modal-body">
      <form method="POST" action="profile.php">
        <input type="hidden" name="action" value="update_profile">

        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label">Mobile Contact</label>
          <input type="text" name="phone" class="form-input" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label">Birthdate</label>
          <input type="date" name="birthdate" class="form-input" value="<?= htmlspecialchars($user['birthdate']) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label">Gender</label>
          <select name="gender" class="form-select">
            <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Home Address</label>
          <input type="text" name="address" class="form-input" value="<?= htmlspecialchars($user['address']) ?>" required>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:28px;">
          <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Change Avatar -->
<div class="modal-backdrop" id="avatarModal">
  <div class="modal-dialog">
    <div class="modal-header">
      <h3 style="font-family:var(--font-serif); font-size:20px; color:var(--text-primary);">Update Profile Picture</h3>
      <button class="modal-close-btn" onclick="closeAvatarModal()">&times;</button>
    </div>
    <div class="modal-body">
      <form method="POST" action="profile.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update_avatar">

        <div class="form-group">
          <label class="form-label" for="avatarFile">Choose a profile picture</label>
          <input type="file" name="avatar" id="avatarFile" class="form-input" accept="image/jpeg,image/png,image/gif,image/webp" required>
          <div style="font-size:12px; color:var(--text-muted); margin-top:8px;">JPG, PNG, GIF, or WebP. Maximum file size: 5 MB.</div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:28px;">
          <button type="button" class="btn btn-secondary btn-sm" onclick="closeAvatarModal()">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Upload Picture</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEditModal() { document.getElementById('editProfileModal').classList.add('active'); }
function closeEditModal() { document.getElementById('editProfileModal').classList.remove('active'); }
function openAvatarModal() { document.getElementById('avatarModal').classList.add('active'); }
function closeAvatarModal() { document.getElementById('avatarModal').classList.remove('active'); }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
