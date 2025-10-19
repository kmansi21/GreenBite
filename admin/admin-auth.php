<?php
session_start();
include '../includes/db.php'; // DB connection

$msg = "";

if (isset($_POST['action'])) {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if ($_POST['action'] === 'register') {
    $name = trim($_POST['name']);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $msg = '<div class="alert alert-warning">⚠️ Email already registered.</div>';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hash);
      if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Registration successful! Please log in.</div>';
      } else {
        $msg = '<div class="alert alert-danger">❌ Error during registration.</div>';
      }
    }
  }

  if ($_POST['action'] === 'login') {
    $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
      $admin = $result->fetch_assoc();
      if (password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: admin-dashboard.php"); // Redirect to admin dashboard
        exit;
      } else {
        $msg = '<div class="alert alert-danger">❌ Incorrect password.</div>';
      }
    } else {
      $msg = '<div class="alert alert-danger">❌ Admin not found.</div>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login/Register | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f0f2f5;
    }
    .form-box {
      max-width: 450px;
      margin: 80px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .toggle-link {
      cursor: pointer;
      color: #0d6efd;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h3 class="text-center mb-4" id="formTitle">Admin Login</h3>
    <?= $msg ?>

    <form method="POST" id="authForm">
      <input type="hidden" name="action" value="login" id="formAction">

      <div class="mb-3" id="nameField" style="display: none;">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Admin Name">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>

      <button type="submit" class="btn btn-success w-100" id="submitBtn">Login</button>
    </form>

    <div class="text-center mt-3">
      <span id="toggleText">Don't have an account?</span>
      <span class="toggle-link" onclick="toggleForm()">Register here</span>
    </div>
  </div>

<script>
  let isLogin = true;

  function toggleForm() {
    isLogin = !isLogin;

    document.getElementById("formTitle").innerText = isLogin ? "Admin Login" : "Admin Register";
    document.getElementById("submitBtn").innerText = isLogin ? "Login" : "Register";
    document.getElementById("toggleText").innerText = isLogin ? "Don't have an account?" : "Already registered?";
    document.querySelector(".toggle-link").innerText = isLogin ? "Register here" : "Login here";
    document.getElementById("formAction").value = isLogin ? "login" : "register";
    document.getElementById("nameField").style.display = isLogin ? "none" : "block";
  }
</script>

</body>
</html>
