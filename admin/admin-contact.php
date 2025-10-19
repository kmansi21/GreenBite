<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

// Delete message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM messages WHERE id = $id");
    header("Location: admin-contact.php");
    exit;
}

// Fetch messages
$messages = $conn->query("SELECT * FROM messages ORDER BY submitted_at DESC") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Messages - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .dashboard-content {
      margin-left: 220px;
      padding: 30px;
    }
    .table thead {
      background-color: #7b1fa2;
      color: white;
    }
    .sidebar {
      width: 220px;
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

<div class="dashboard-content">
  <h2 class="title">Contact Messages</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Submitted At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($messages->num_rows > 0): $i = 1; ?>
          <?php while($row = $messages->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= htmlspecialchars($row['message']) ?></td>
              <td><?= date("d M Y h:i A", strtotime($row['submitted_at'])) ?></td>
              <td>
                
                                <a href="delete-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this message?')"><i class="bi bi-trash"></i></a>

                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">No messages found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
