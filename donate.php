<?php
session_start();
include 'includes/db.php';

$msg = '';
$logged_in = isset($_SESSION['user_id']);
$donor_id = $logged_in ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!$logged_in) {
    $msg = '<div class="alert alert-danger">⚠️ You must <a href="auth.php">log in</a> before submitting a donation.</div>';
  } else {
    $desc = trim($_POST['food_description']);
    $qty = trim($_POST['quantity']);
    $pickup_time_input = $_POST['pickup_time'];
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact_number']);
    $food_type = $_POST['food_type'];

    // Handle image upload
    $image_name = '';
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] == 0) {
      $allowed = ['jpg', 'jpeg', 'png'];
      $ext = strtolower(pathinfo($_FILES['food_image']['name'], PATHINFO_EXTENSION));
      if (in_array($ext, $allowed)) {
        $image_name = 'uploads/' . time() . '_' . basename($_FILES['food_image']['name']);
        move_uploaded_file($_FILES['food_image']['tmp_name'], $image_name);
      } else {
        $msg = '<div class="alert alert-danger">Only JPG, JPEG, and PNG files are allowed.</div>';
      }
    }

    $pickup_timestamp = strtotime($pickup_time_input);
    $expires_timestamp = $pickup_timestamp + (5 * 3600); // 5 hours

    if ($pickup_timestamp < time()) {
      $msg = '<div class="alert alert-danger">Pickup time must be in the future.</div>';
    } elseif ($expires_timestamp < time()) {
      $msg = '<div class="alert alert-danger">Pickup time must be at least 5 hours from now.</div>';
    } else {
      $pickup_time = date('Y-m-d H:i:s', $pickup_timestamp);
      $expires_at = date('Y-m-d H:i:s', $expires_timestamp);

      $stmt = $conn->prepare("INSERT INTO donations (donor_id, food_description, quantity, pickup_time, address, contact_number, expires_at, food_image, food_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

      if (!$stmt) {
        die("SQL Error: " . $conn->error);
      }

      $stmt->bind_param("issssssss", $donor_id, $desc, $qty, $pickup_time, $address, $contact, $expires_at, $image_name, $food_type);

      if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Donation submitted successfully. You will be notified if accepted within 5 hours.</div>';
      } else {
        $msg = '<div class="alert alert-danger">Error submitting donation. Please try again.</div>';
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donate Food | GreenBite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .donation-box {
      max-width: 750px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    h3 {
      color: #28a745;
      font-weight: 600;
    }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container">
  <div class="donation-box">
    <h3 class="mb-4">🥗 Donate Veg Food</h3>
    <?= $msg ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Food Description (Veg only)</label>
        <textarea name="food_description" class="form-control" rows="3" placeholder="E.g., Paneer Biryani, Dal, Roti..." required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Food Type</label>
        <select name="food_type" class="form-control" required>
          <option value="Cooked">Cooked</option>
          <option value="Packed">Packed</option>
          <option value="Raw">Raw</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantity (e.g., serves 10 people)</label>
        <input type="text" name="quantity" class="form-control" required>
      </div>

 
<div class="mb-3">
  <label class="form-label">Pickup Date & Time</label>
  <input type="text" id="pickup_datetime" name="pickup_time" class="form-control" placeholder="Select date & time" required>
</div>


      <div class="mb-3">
        <label class="form-label">Pickup Address</label>
        <textarea name="address" class="form-control" rows="2" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Contact Number</label>
        <input type="tel" name="contact_number" class="form-control" pattern="[0-9]{10}" maxlength="10" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Upload Food Image</label>
        <input type="file" name="food_image" class="form-control" accept="image/*" required>
      </div>

      <button type="submit" class="btn btn-success w-100" <?= !$logged_in ? 'disabled' : '' ?>>✅ Submit Donation</button>
    </form>

    <?php if (!$logged_in): ?>
      <p class="text-danger mt-3">🔐 Please <a href="auth.php">log in</a> to submit a donation.</p>
    <?php endif; ?>
  </div>
</div>
<script>
  flatpickr("#pickup_datetime", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K", // 12-hour format with AM/PM
    minDate: "today",           // no past dates
    time_24hr: false             // 12-hour
  });
</script>
</body>
</html>
