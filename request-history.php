<?php
session_start();
include 'includes/db.php';



// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: auth.php");
  exit;
}

$receiver_id = $_SESSION['user_id'];
$msg = '';

// Fetch accepted donations for this receiver_id
$stmt = $conn->prepare("SELECT * FROM donations WHERE status = 'accepted' AND receiver_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $receiver_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Accepted Donations | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .history-box {
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .donation-card {
      display: flex;
      gap: 20px;
      border-bottom: 1px solid #ccc;
      padding: 20px 0;
      align-items: center;
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
    .badge-status {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.9rem;
    }
    .accepted {
      background-color: #28a745;
      color: #fff;
    }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
  <div class="history-box">
    <h3 class="mb-4 text-primary">📄 My Accepted Donations</h3>

    <?php if ($result->num_rows === 0): ?>
      <p class="text-muted">You haven't accepted any donations yet.</p>
    <?php else: ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="donation-card">
          <img src="<?= htmlspecialchars($row['food_image']) ?>" alt="Food Image">
          <div class="donation-info">
            <h5><?= htmlspecialchars($row['food_description']) ?> (<?= htmlspecialchars($row['food_type']) ?>)</h5>
            <p>📦 Quantity: <?= htmlspecialchars($row['quantity']) ?></p>
            <p>📍 Pickup Location: <?= htmlspecialchars($row['address']) ?></p>
            <p>⏰ Pickup Time: <?= date('d M Y, h:i A', strtotime($row['pickup_time'])) ?></p>
            <p>☎ Donor Contact: <?= htmlspecialchars($row['contact_number']) ?></p>
            <span class="badge-status accepted">Accepted</span>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
