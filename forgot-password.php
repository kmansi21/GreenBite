<?php
session_start();
include('includes/db.php');

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = 'error';
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) == 1) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = mysqli_query($conn, "UPDATE users SET password='$hashed_password' WHERE email='$email'");
            if ($update) {
                $message = "✅ Password reset successful. You can now login.";
                $message_type = 'success';
            } else {
                $message = "❌ Error updating password.";
                $message_type = 'error';
            }
        } else {
            $message = "❌ Email not found.";
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #a5d6a7, #66bb6a);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .forgot-box {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      text-align: center;
    }
    h2 {
      color: #388e3c;
      font-weight: 700;
      margin-bottom: 1rem;
    }
    input {
      margin: 10px 0;
    }
    .btn-custom {
      background-color: #388e3c;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #2e7d32;
    }
    .message.success { color: green; }
    .message.error { color: red; }
    .back-link {
      display: inline-block;
      margin-top: 15px;
      text-decoration: underline;
      color: #388e3c;
      font-weight: 500;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="forgot-box">
  <h2>Reset Your Password</h2>

  <?php if (!empty($message)) : ?>
    <div class="message <?= $message_type ?>"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="email" name="email" placeholder="Enter your email" class="form-control" required>
    <input type="password" name="new_password" placeholder="New password" class="form-control" required>
    <input type="password" name="confirm_password" placeholder="Confirm password" class="form-control" required>
    <button type="submit" class="btn btn-custom w-100 mt-3">Reset Password</button>
  </form>

  <div class="back-link" onclick="window.location.href='auth.php'">← Back to Login</div>
</div>

</body>
</html>
