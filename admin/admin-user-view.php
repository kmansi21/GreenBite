<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin-users.php");
    exit;
}

$user_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View User - Admin Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f4f6f8;
    }

    .container-custom {
      margin-left: 220px;
      padding: 30px;
    }

    .profile-card {
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .avatar-lg {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background-color: #7b1fa2;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      font-weight: bold;
    }

    .badge-donor {
      background-color: #28a745;
    }

    .badge-receiver {
      background-color: #17a2b8;
    }

    .info-label {
      font-weight: 600;
      color: #555;
    }

    .back-btn {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="container-custom">
  <div class="profile-card">
    <div class="d-flex align-items-center mb-4">
      <div class="avatar-lg"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
      <div class="ms-3">
        <h4 class="mb-0"><?= htmlspecialchars($user['name']) ?></h4>
        <span class="badge <?= $user['role'] == 'donor' ? 'badge-donor' : 'badge-receiver' ?>">
          <?= ucfirst($user['role']) ?>
        </span>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-md-3 info-label">Email:</div>
      <div class="col-md-9"><?= htmlspecialchars($user['email']) ?></div>
    </div>

    <div class="row mb-2">
      <div class="col-md-3 info-label">Role:</div>
      <div class="col-md-9"><?= ucfirst($user['role']) ?></div>
    </div>

    <div class="row mb-2">
      <div class="col-md-3 info-label">Joined Date:</div>
      <div class="col-md-9"><?= date("d M Y", strtotime($user['created_at'])) ?></div>
    </div>

    <a href="admin-dashboard.php" class="btn btn-secondary back-btn">
      <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
    </a>
  </div>
</div>

</body>
</html>
