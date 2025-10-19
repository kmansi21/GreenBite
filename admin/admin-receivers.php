<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

$receivers = $conn->query("SELECT * FROM users WHERE role='receiver' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Receivers - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .main {
      margin-left: 220px;
      padding: 40px;
    }
    .card-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .title {
      font-weight: 600;
      color: rgb(70, 162, 31);
      margin-bottom: 25px;
    }
    .table thead {
      background-color: rgb(70, 162, 31);
      color: white;
    }
    .btn-sm {
      font-size: 0.75rem;
    }
    .badge-donor {
      background-color:#2196f3;
      font-size: 0.8rem;
    }
   
  </style>
</head>
<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="main">
  <div class="card-container">
    <h2 class="title">Registered Receivers</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Receiver Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Registered On</th>
                        <th>Role</th>

            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = $receivers->fetch_assoc()):
          ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                        <td><span class="badge badge-donor">Reciver</span></td>

            <td>
              <a href="view-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
              <a href="delete-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this receiver?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
