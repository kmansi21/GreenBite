<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: auth.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$msg = '';

// Fetch user info
$query = $conn->prepare("SELECT name, email, role, created_at FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($name, $email, $role, $joined);
$query->fetch();
$query->close();

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $new_name = trim($_POST['name']);
  $new_email = trim($_POST['email']);
  $new_password = trim($_POST['password']);

  if (!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $new_name, $new_email, $hashed, $user_id);
  } else {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
  }

  if ($stmt->execute()) {
    $msg = '<div class="alert alert-success mt-3">Profile updated successfully!</div>';
    $name = $new_name;
    $email = $new_email;
  } else {
    $msg = '<div class="alert alert-danger mt-3">Update failed. Email may already be used.</div>';
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f4f4; font-family: 'Segoe UI', sans-serif; }
    .profile-box {
      max-width: 650px;
      margin: 80px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    h3 { color: #28a745; font-weight: 600; }
    .label { font-weight: bold; color: #555; }
    .btn-group a {
      margin-right: 10px;
    }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
  <div class="profile-box">
    <h3 class="mb-4">👤 My Profile</h3>

    <?= $msg ?>

    <p><span class="label">Full Name:</span> <?= htmlspecialchars($name) ?></p>
    <p><span class="label">Email:</span> <?= htmlspecialchars($email) ?></p>
    <p><span class="label">Role:</span> <?= ucfirst(htmlspecialchars($role)) ?></p>
    <p><span class="label">Joined On:</span> <?= date("F j, Y", strtotime($joined)) ?></p>

   <div class="btn-group mt-4 mb-3">
  <button class="btn btn-outline-primary me-3" data-bs-toggle="collapse" data-bs-target="#updateForm">✏️ Update Profile</button>
  <?php if ($role === 'donor'): ?>
    <a href="donation-history.php" class="btn btn-outline-success">📦 Donation History</a>
  <?php elseif ($role === 'receiver'): ?>
    <a href="request-history.php" class="btn btn-outline-warning">📄 Request History</a>
  <?php endif; ?>
</div>


    <div class="collapse" id="updateForm">
      <form method="POST">
        <div class="mb-3">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
          <label>New Password (leave blank to keep current)</label>
          <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
