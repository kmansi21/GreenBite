<?php
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/db.php';

$successMsg = '';
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $successMsg = "Thank you! Your message has been sent.";
        } else {
            $errorMsg = "Error saving your message. Please try again.";
        }

        $stmt->close();
    } else {
        $errorMsg = "All fields are required.";
    }

    $conn->close();
}
?>

<style>

  .glass-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    color: #222;
    transition: all 0.3s ease;
  }

  .glass-card input,
  .glass-card textarea {
    background: #f9f9f9 !important;
    border: 1px solid #ddd;
    border-radius: 8px;
  }

  .glass-card button {
    border-radius: 30px;
    padding: 10px 30px;
    transition: 0.3s ease;
  }

  .glass-card button:hover {
    background-color: #2e7d32;
  }

  .contact-icon {
    font-size: 1.2rem;
    margin-right: 10px;
    color: #43a047;
  }
</style>

<!-- Hero Section -->
<section class="text-center text-white d-flex align-items-center justify-content-center" style="
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
              url('images/contact.jpg') center center / cover no-repeat;
  min-height: 60vh;
  background-attachment: local;
  text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
">
  <div class="container">
    <h1 class="display-4 fw-bold">Let’s Connect</h1>
    <p class="lead mt-3">We’re always here to listen, collaborate, and support your mission.</p>
  </div>
</section>


<!-- Contact Form Section -->
<section class="py-5" style="background: #f0f4f8;">
  <div class="container">
    <div class="row justify-content-center g-4">

      <!-- Form -->
      <div class="col-lg-7">
        <div class="glass-card">
          <h3 class="text-center mb-4 text-success">Send Us a Message</h3>

          <?php if ($successMsg): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
          <?php elseif ($errorMsg): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-3">
              <label class="form-label">Your Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" rows="5" class="form-control" required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success px-4">Submit</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Info -->
      <div class="col-lg-5">
        <div class="glass-card">
          <h4 class="text-success fw-bold mb-4">Contact Info</h4>
          <p><i class="bi bi-geo-alt-fill contact-icon"></i> 123 Green Lane, Pune, India</p>
          <p><i class="bi bi-envelope-fill contact-icon"></i> contact@GreenBite.org</p>
          <p><i class="bi bi-telephone-fill contact-icon"></i> +91 9876543210</p>
          <p><i class="bi bi-clock-fill contact-icon"></i> Mon - Fri, 9 AM to 6 PM</p>
          <p class="mt-4 small fst-italic text-muted">We usually respond within 24 hours.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
