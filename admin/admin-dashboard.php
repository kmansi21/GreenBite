<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

// Count data for dashboard cards
$donors = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='donor'")->fetch_assoc()['total'];
$receivers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='receiver'")->fetch_assoc()['total'];
$donations = $conn->query("SELECT COUNT(*) as total FROM donations")->fetch_assoc()['total'];
$messages = $conn->query("SELECT COUNT(*) as total FROM messages")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - GreenBite</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      width: 220px;
    }
    .dashboard-content {
      margin-left: 220px;
      padding: 30px;
    }
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .card-icon {
      font-size: 2.5rem;
      color: #7b1fa2;
    }
    .footer {
      background: #343a40;
      color: #ccc;
      text-align: center;
      padding: 15px 0;
      position: fixed;
      bottom: 0;
      left: 220px;
      width: calc(100% - 220px);
    }
    .recent-section {
      margin-top: 50px;
    }
  </style>
</head>
<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="dashboard-content">
  <h2 class="mb-4 text-dark">👋 Welcome, Admin</h2>

  <div class="row g-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <i class="bi bi-person-heart card-icon mb-2"></i>
          <h6 class="card-title text-secondary">Total Donors</h6>
          <p class="fs-4 fw-bold text-dark"><?php echo $donors; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <i class="bi bi-person-lines-fill card-icon mb-2"></i>
          <h6 class="card-title text-secondary">Total Receivers</h6>
          <p class="fs-4 fw-bold text-dark"><?php echo $receivers; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <i class="bi bi-box-seam card-icon mb-2"></i>
          <h6 class="card-title text-secondary">Donations</h6>
          <p class="fs-4 fw-bold text-dark"><?php echo $donations; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <i class="bi bi-envelope card-icon mb-2"></i>
          <h6 class="card-title text-secondary">Messages</h6>
          <p class="fs-4 fw-bold text-dark"><?php echo $messages; ?></p>
        </div>
      </div>
    </div>
  </div>

<!-- Pending Approvals / Messages Section -->
<div class="mt-5">
  <h4 class="mb-3 text-dark">🔔 Pending Approvals </h4>
  <div class="row g-4">
    
    <!-- Pending Donations -->
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-secondary">Pending Donations</h5>
          <ul class="list-group list-group-flush">
            <?php
            $pendingDonations = $conn->query("SELECT food_description, address, pickup_time FROM donations WHERE status='pending' ORDER BY created_at DESC LIMIT 5");
            if ($pendingDonations->num_rows > 0) {
              while ($row = $pendingDonations->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                        <div>
                          <strong>" . htmlspecialchars($row['food_description']) . "</strong><br>
                          <small class='text-muted'>" . htmlspecialchars($row['address']) . " | Pickup: " . date('d M Y, h:i A', strtotime($row['pickup_time'])) . "</small>
                        </div>
                        <span class='badge bg-warning text-dark'>Pending</span>
                      </li>";
              }
            } else {
              echo "<li class='list-group-item text-muted'>No pending donations</li>";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>

   
    
  </div>
</div>


<!-- Footer -->
<footer class="footer">
  &copy; <?= date("Y") ?> GreenBite | Admin Panel | Designed with ❤️ by Mansi
</footer>

</body>
</html>
