<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

$donors = $conn->query("SELECT * FROM users WHERE role = 'donor'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Donors - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f0f2f5;
      font-family: 'Segoe UI', sans-serif;
    }

    .main {
      margin-left: 220px;
      padding: 40px;
    }

    .card-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    h2.title {
      font-weight: 600;
      color: rgb(70, 162, 31);
      margin-bottom: 25px;
    }

    .table thead {
      background-color: rgb(70, 162, 31);
      color: #fff;
    }

    .badge-donor {
      background-color:rgb(37, 159, 41);
      font-size: 0.8rem;
    }

    .btn {
      border-radius: 8px !important;
    }

    .btn-outline-primary {
      color: rgb(70, 162, 31);
      border-color: rgb(70, 162, 31);
    }

    .btn-outline-primary:hover {
      background-color: rgb(70, 162, 31);
      color: white;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
    }
  </style>
</head>
<body>

<?php include '../includes/admin-sidebar.php'; ?>

<div class="main">
  <div class="card-container">
    <h2 class="title">All Donors</h2>

    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Joined</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $donors->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>

            <td><span class="badge badge-donor">Donor</span></td>
            <td>
              <a href="admin-user-view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
              <a href="delete-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure to delete this donor?')"><i class="bi bi-trash"></i></a>
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
