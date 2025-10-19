<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<head>
  <style>
    /* Smooth underline hover/active effect */
    .nav-link {
      position: relative;
      transition: color 0.3s ease;
    }

    .nav-link::after {
      content: "";
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0%;
      height: 2px;
      background-color: #28a745;
      transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    .nav-link.active {
      color: #28a745 !important;
      font-weight: bold;
    }

    /* Responsive spacing */
    @media (max-width: 991px) {
      .navbar-nav {
        text-align: center;
        padding-top: 0.5rem;
      }

      .navbar-nav .nav-item {
        margin-bottom: 0.5rem;
      }

      .navbar .btn {
        width: 80%;
        margin: 0.4rem auto;
      }

      .navbar-brand {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container-fluid px-lg-5">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-success fs-3 d-flex align-items-center" href="index.php">
      <i class="bi bi-bag-heart-fill me-2"></i> GreenBite
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-lg-center">
        <!-- Common Links -->
        <li class="nav-item">
          <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'index.php') ? 'active text-success' : 'text-dark'; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'about.php') ? 'active text-success' : 'text-dark'; ?>" href="about.php">About</a>
        </li>

        <!-- Role-based Navigation -->
        <?php if (!isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'donate.php') ? 'active text-success' : 'text-dark'; ?>" href="donate.php">Donate</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'requests.php') ? 'active text-success' : 'text-dark'; ?>" href="requests.php">Request</a>
          </li>
        <?php elseif ($_SESSION['role'] === 'donor'): ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'donate.php') ? 'active text-success' : 'text-dark'; ?>" href="donate.php">Donate</a>
          </li>
        <?php elseif ($_SESSION['role'] === 'receiver'): ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'requests.php') ? 'active text-success' : 'text-dark'; ?>" href="requests.php">Request</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'contact.php') ? 'active text-success' : 'text-dark'; ?>" href="contact.php">Contact</a>
        </li>

        <!-- Auth Buttons -->
        <?php if (!isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link text-warning" href="admin/admin-auth.php">Admin</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success fw-semibold rounded-pill px-4 ms-lg-2" href="auth.php">Login / Register</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold mx-2 <?= ($current_page == 'profile.php') ? 'active text-success' : 'text-dark'; ?>" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-success fw-semibold rounded-pill px-4 ms-lg-2" href="logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
