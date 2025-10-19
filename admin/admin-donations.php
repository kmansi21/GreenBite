<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

$result = $conn->query("SELECT * FROM donations ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Donations - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 <head>
  <meta charset="UTF-8">
  <title>All Donations - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      padding: 30px;
    }
    .main-content {
  background-color: #f9f9fb;
  min-height: 100vh;
}

    .heading {
      color: rgb(70, 162, 31);
      font-weight: 600;
      font-size: 28px;
      margin-bottom: 25px;
    }
    .table thead {
      background: rgb(70, 162, 31);
      color: #fff;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .table tbody tr {
      background-color: #fff;
      transition: box-shadow 0.3s ease;
    }
    .table tbody tr:hover {
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
    }
    .food-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }
    .badge {
      padding: 6px 10px;
      font-size: 13px;
    }
    .badge-accepted {
      background-color: #4CAF50;
    }
    .badge-expired {
      background-color: #f44336;
    }
    .badge-pending {
      background-color: #ff9800;
    }
     h2.title {
      font-weight: 600;
      color: rgb(70, 162, 31);
      margin-bottom: 25px;
    }
  </style>
</head>

<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="main-content" style="margin-left: 230px; padding: 30px;">
  <div class="container-fluid">
    <h2 class="title">All Donations</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle shadow-sm bg-white">
        <thead class="table-dark text-center">
          <tr>
            <th>Description</th>
            <th>Qty</th>
            <th>Food Type</th>
            <th>Pickup Time</th>
            <th>Expires</th>
            <th>Status</th>
            <th>Receiver</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Image</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
          $sql = "SELECT * FROM donations ORDER BY created_at DESC";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()):
          ?>
          
          <tr>
            <td><?= htmlspecialchars($row['food_description']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['food_type'] ?></td>
            <td><?= date('d M Y h:i A', strtotime($row['pickup_time'])) ?></td>
            <td><?= date('d M Y h:i A', strtotime($row['expires_at'])) ?></td>
            <td>
  <?php
    $status = $row['status'];
    if ($status == 'accepted') {
      $badgeClass = 'success';
    } elseif ($status == 'expired') {
      $badgeClass = 'danger';
    } else {
      $badgeClass = 'warning';
    }
  ?>
  <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
</td>
            <td><?= htmlspecialchars($row['receiver_name']) ?></td>
            <td><?= htmlspecialchars($row['receiver_contact']) ?></td>
            <td><?= htmlspecialchars($row['receiver_address']) ?></td>
            <td>
              <img src="../<?= $row['food_image'] ?>" alt="Food" width="60" height="60" style="object-fit:cover;border-radius:4px;">
            </td>
            <td><?= date('d M Y h:i A', strtotime($row['created_at'])) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
