<?php
session_start();
include 'includes/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // REGISTER
  if (isset($_POST['register'])) {
  $name = trim($_POST['name']);
  $contact = trim($_POST['contact']);
  $address = trim($_POST['address']);
  $role = $_POST['role'];
  $hashed = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, contact, address, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $name, $contact, $address, $email, $hashed, $role);
  if ($stmt->execute()) {
    $msg = '<div class="alert alert-success">Registered successfully! Please login.</div>';
  } else {
    $msg = '<div class="alert alert-danger">Email already exists or error occurred.</div>';
  }
}


  // LOGIN
  if (isset($_POST['login'])) {
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $stmt->bind_result($user_id, $hashed, $role);
      $stmt->fetch();
      if (password_verify($password, $hashed)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        header("Location: index.php");
        exit;
      } else {
        $msg = '<div class="alert alert-danger">Invalid password.</div>';
      }
    } else {
      $msg = '<div class="alert alert-danger">Email not found.</div>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Register | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #81c784, #66bb6a);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .auth-box {
      background: #fff;
      border-radius: 16px;
      padding: 2rem;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    h3 {
      font-weight: 700;
    }
    .toggle-link {
      color: #388e3c;
      cursor: pointer;
      font-weight: 600;
    }
    .form-section {
      display: none;
    }
    .form-section.active {
      display: block;
    }
  </style>
</head>
<body>

<div class="auth-box">
  <h3 class="text-center text-success mb-3" id="form-title">Login to GreenBite</h3>
  <?= $msg ?>

  <!-- Login Form -->
  <form method="POST" id="login-form" class="form-section active">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required />
    </div>
    <button type="submit" name="login" class="btn btn-success w-100">Login</button>
    <p class="text-center mt-3">Don’t have an account? <span class="toggle-link" onclick="showForm('register')">Register</span></p>
    <p class="text-center"><a href="forgot-password.php" class="text-warning fw-semibold">Forgot Password?</a></p>
<p class="text-center"><a href="index.php" class="text-success">← Back to Home</a></p>

  </form>

  <!-- Register Form -->
 <!-- Register Form -->
<form method="POST" id="register-form" class="form-section">
  <div class="mb-3">
    <label>Full Name</label>
    <input type="text" name="name" class="form-control" required />
  </div>
  <div class="mb-3">
    <label>Contact Number</label>
    <input type="text" name="contact" class="form-control" required pattern="[0-9]{10}" title="Enter a 10-digit phone number"/>
  </div>
  <div class="mb-3">
    <label>Address</label>
    <textarea name="address" class="form-control" required></textarea>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required />
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required />
  </div>
  <div class="mb-3">
    <label for="role" class="form-label fw-semibold">Register as</label>
    <select name="role" id="role" class="form-select" required>
      <option value="" disabled selected>Select your role</option>
      <option value="donor">Donor</option>
      <option value="receiver">Receiver</option>
    </select>
  </div>
  <button type="submit" name="register" class="btn btn-success w-100">Register</button>
  <p class="text-center mt-3">Already have an account? <span class="toggle-link" onclick="showForm('login')">Login</span></p>
</form>

</div>

<script>
  function showForm(type) {
    document.querySelectorAll('.form-section').forEach(form => form.classList.remove('active'));
    document.getElementById(`${type}-form`).classList.add('active');
    document.getElementById('form-title').innerText =
      type === 'login' ? "Login to GreenBite" : "Register for GreenBite";
  }
</script>

</body>
</html>
