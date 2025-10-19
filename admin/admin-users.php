<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

if (isset($_GET['delete_user'])) {
    $uid = intval($_GET['delete_user']);
    $conn->query("DELETE FROM users WHERE id = $uid");
    header("Location: admin-users.php?deleted=1");
    exit;
}

$users = $conn->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Users – Admin Panel</title>
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

    .user-card {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 15px;
      transition: all 0.2s ease-in-out;
    }

    .user-card:hover {
      transform: scale(1.01);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .user-avatar {
      width: 50px;
      height: 50px;
      background-color: #7b1fa2;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 18px;
      border-radius: 50%;
    }

    .user-info {
      margin-left: 15px;
    }

    .user-actions a {
      margin-right: 8px;
    }

    .badge-donor {
      background-color: #28a745;
    }

    .badge-receiver {
      background-color: #17a2b8;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    @media (max-width: 576px) {
      .user-card {
        flex-direction: column !important;
        text-align: center;
      }

      .user-info {
        margin-left: 0;
        margin-top: 10px;
      }

      .user-actions {
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="container-custom">
  <h3 class="page-title">👤 All Users</h3>

  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">✅ User deleted successfully.</div>
  <?php endif; ?>

  <?php while ($user = $users->fetch_assoc()): ?>
    <div class="d-flex align-items-center justify-content-between user-card flex-wrap">
      <div class="d-flex align-items-center">
        <div class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
        <div class="user-info">
          <h5 class="mb-1"><?= htmlspecialchars($user['name']) ?></h5>
          <p class="mb-1 small text-muted"><?= htmlspecialchars($user['email']) ?></p>
          <span class="badge <?= $user['role'] == 'donor' ? 'badge-donor' : 'badge-receiver' ?>"><?= ucfirst($user['role']) ?></span>
          <small class="text-muted d-block mt-1">Joined: <?= date("d M Y", strtotime($user['created_at'])) ?></small>
        </div>
      </div>
      <div class="user-actions mt-3 mt-md-0">
        <a href="admin-user-view.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
        <a href="?delete_user=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
