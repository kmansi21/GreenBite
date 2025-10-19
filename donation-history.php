<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: auth.php");
  exit;
}

$donor_id = $_SESSION['user_id'];
$msg = '';

// Auto-expire old pending donations
$conn->query("UPDATE donations SET status = 'expired' WHERE status = 'pending' AND expires_at < NOW()");

if (isset($_GET['delete_id'])) {
  $del_id = intval($_GET['delete_id']);
  $stmt = $conn->prepare("DELETE FROM donations WHERE id = ? AND donor_id = ?");
  $stmt->bind_param("ii", $del_id, $donor_id);
  if ($stmt->execute()) {
    $msg = '<div class="alert alert-success">✅ Donation deleted successfully.</div>';
  }
}

$stmt = $conn->prepare("SELECT * FROM donations WHERE donor_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donation History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body { background: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
    .history-box {
      max-width: 1000px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    }
    .donation-card {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 1px solid #ddd;
      padding: 20px 0;
    }
    .donation-card img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
    }
    .donation-info {
      flex: 1;
    }
    .status-badge {
      font-weight: 600;
    }
    .status-pending { color: #ffc107; }
    .status-accepted { color: #28a745; }
    .status-expired { color: #dc3545; }
    .btn-outline-primary:hover {
  background-color: #0d6efd;
  color: #fff;
  box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.4);
  transition: 0.2s ease-in-out;
}

.btn-outline-danger:hover {
  background-color: #dc3545;
  color: #fff;
  box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.4);
  transition: 0.2s ease-in-out;
}

  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
  <div class="history-box">
    <h3 class="mb-4 text-success">📦 My Donation History</h3>
    <?= $msg ?>

    <?php if ($result->num_rows === 0): ?>
      <p class="text-muted">No donations found.</p>
    <?php else: ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php
          $current_time = time();
          $expires_at = strtotime($row['expires_at']);
          $status = $row['status'];
          $display_status = ($status === 'pending' && $expires_at < $current_time) ? 'expired' : $status;
        ?>
        <div class="donation-card">
          <img src="<?= htmlspecialchars($row['food_image']) ?>" alt="Food" />
          <div class="donation-info">
            <h5><?= htmlspecialchars($row['food_description']) ?> (<?= $row['food_type'] ?>)</h5>
            <p class="mb-1">⏰ Pickup: <?= date('d M Y, h:i A', strtotime($row['pickup_time'])) ?></p>
            <p class="mb-1">🕒 Expires: <?= date('d M Y, h:i A', strtotime($row['expires_at'])) ?></p>
            <span class="status-badge status-<?= $display_status ?>"><?= ucfirst($display_status) ?></span>
          </div>

          <div class="d-flex flex-column gap-1">
            <?php if ($display_status === 'accepted'): ?>
<button class="btn btn-outline-primary btn-sm shadow-sm fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['id'] ?>">
  👁 View Details
</button>            <?php endif; ?>

            <?php if (in_array($display_status, ['pending', 'expired'])): ?>
<button class="btn btn-outline-danger btn-sm shadow-sm fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
  🗑 Delete
</button>            <?php endif; ?>
          </div>
        </div>

        <!-- View Modal for Accepted Donations -->
        <?php if ($display_status === 'accepted'): ?>
        <div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Donation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <img src="<?= htmlspecialchars($row['food_image']) ?>" class="img-fluid rounded mb-3" alt="Food Image" />
                <p><strong>Description:</strong> <?= htmlspecialchars($row['food_description']) ?></p>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($row['quantity']) ?></p>
                <p><strong>Pickup Time:</strong> <?= date('d M Y, h:i A', strtotime($row['pickup_time'])) ?></p>
                <p><strong>Expires At:</strong> <?= date('d M Y, h:i A', strtotime($row['expires_at'])) ?></p>
                <p><strong>Food Type:</strong> <?= htmlspecialchars($row['food_type']) ?></p>
                <p><strong>Status:</strong> <span class="status-accepted"><?= ucfirst($display_status) ?></span></p>

                <hr>
                <h6 class="text-success">Receiver Information</h6>
                <p><strong>Name:</strong> <?= htmlspecialchars($row['receiver_name']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($row['receiver_contact']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($row['receiver_email']) ?></p>
                <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($row['receiver_address'])) ?></p>
                <p><strong>Reason:</strong> <?= nl2br(htmlspecialchars($row['receiver_reason'])) ?></p>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete this <?= $display_status ?> donation?
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger">Yes, Delete</a>
              </div>
            </div>
          </div>
        </div>

      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
