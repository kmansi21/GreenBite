<?php
session_start();
include 'includes/db.php';

$logged_in = isset($_SESSION['user_id']);
$receiver_id = $logged_in ? $_SESSION['user_id'] : null;
$msg = "";

// Fetch user info if logged in
if ($logged_in) {
  $user_stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
  $user_stmt->bind_param("i", $receiver_id);
  $user_stmt->execute();
  $user_result = $user_stmt->get_result();
  $user = $user_result->fetch_assoc();
}

// Handle donation request if POST and logged in
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $logged_in && isset($_POST['donation_id'])) {
  $donation_id = intval($_POST['donation_id']);
  $receiver_address = trim($_POST['receiver_address']);
  $receiver_contact = trim($_POST['receiver_contact']);
  $reason = trim($_POST['reason']);

  $receiver_name = $user['name'];
  $receiver_email = $user['email'];

  $stmt = $conn->prepare("
    UPDATE donations
    SET status = 'accepted',
        receiver_id = ?, receiver_name = ?, receiver_contact = ?, receiver_email = ?, receiver_address = ?, receiver_reason = ?
    WHERE id = ? AND status = 'pending'
  ");
  $stmt->bind_param("isssssi", $receiver_id, $receiver_name, $receiver_contact, $receiver_email, $receiver_address, $reason, $donation_id);

  if ($stmt->execute()) {
    $msg = '<div class="alert alert-success mt-4">✅ You have successfully requested this donation.</div>';
  } else {
    $msg = '<div class="alert alert-danger mt-4">❌ Request failed. Please try again.</div>';
  }
}

// Fetch available donations
$result = $conn->query("SELECT * FROM donations WHERE status = 'pending' ORDER BY expires_at ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Donations | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f3f4f6;
      font-family: 'Segoe UI', sans-serif;
    }
    .donation-card {
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.08);
      overflow: hidden;
      background: white;
    }
    .donation-img {
      height: 220px;
      object-fit: cover;
    }
    .modal-content {
      border-radius: 15px;
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-success">🍛 Available Donations for You</h2>
  <?= $msg ?>

  <?php if ($result->num_rows === 0): ?>
    <div class="alert alert-warning">No donations available at the moment. Please check back later.</div>
  <?php else: ?>
    <div class="row g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="donation-card card">
            <img src="<?= htmlspecialchars($row['food_image']) ?>" class="card-img-top donation-img" alt="Food Image">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['food_description']) ?></h5>
              <p class="card-text">
                🍱 <strong>Type:</strong> <?= htmlspecialchars($row['food_type']) ?><br>
                👥 <strong>Serves:</strong> <?= htmlspecialchars($row['quantity']) ?><br>
                ⏰ <strong>Pickup Time:</strong> <?= date('d M Y, h:i A', strtotime($row['pickup_time'])) ?><br>
                🕒 <strong>Expires Time:</strong> <?= date('d M Y, h:i A', strtotime($row['expires_at'])) ?><br>
                📍 <strong>Address:</strong> <?= nl2br(htmlspecialchars($row['address'])) ?>
              </p>
              <?php if ($logged_in): ?>
                <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#requestModal<?= $row['id'] ?>">
                  Request This Donation
                </button>
              <?php else: ?>
                <a href="auth.php" class="btn btn-outline-primary w-100">🔐 Log in to Request</a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Modal: Only available if logged in -->
        <?php if ($logged_in): ?>
        <div class="modal fade" id="requestModal<?= $row['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <form method="POST" class="modal-content p-4">
              <input type="hidden" name="donation_id" value="<?= $row['id'] ?>">
              <div class="modal-header">
                <h4 class="modal-title text-success">📝 Request Donation - <?= htmlspecialchars($row['food_description']) ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body row g-3">
                <div class="col-md-6">
                  <label class="form-label">Your Name</label>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" disabled>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Contact Number</label>
                  <input type="tel" name="receiver_contact" class="form-control" pattern="[0-9]{10}" maxlength="10" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Pickup Address</label>
                  <input type="text" name="receiver_address" class="form-control" required>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Any Message?</label>
                  <textarea name="reason" class="form-control" rows="3" placeholder="Write your message to donor..." required></textarea>
                </div>
              </div>
              <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">✅ Submit Request</button>
              </div>
            </form>
          </div>
        </div>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
