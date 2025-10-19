<?php if (!isset($_SESSION)) session_start(); ?>
<!-- Sidebar -->
<nav class="sidebar bg-dark text-light position-fixed vh-100 p-3" style="width: 220px;">
  <div class="sidebar-header mb-4 text-center">
    <h4 class="text-white">GreenBite Admin</h4>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item mb-2">
      <a href="admin-dashboard.php" class="nav-link text-light">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="admin-users.php" class="nav-link text-light">
        <i class="bi bi-people"></i> All Users
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="admin-donors.php" class="nav-link text-light">
        <i class="bi bi-person-heart"></i> Donors
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="admin-receivers.php" class="nav-link text-light">
        <i class="bi bi-person-lines-fill"></i> Receivers
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="admin-donations.php" class="nav-link text-light">
        <i class="bi bi-box-seam"></i> All Donations
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="admin-contact.php" class="nav-link text-light">
        <i class="bi bi-envelope"></i> Contact Messages
      </a>
    </li>
    <li class="nav-item mt-auto">
      <a href="admin-logout.php" class="nav-link text-light">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </li>
  </ul>
</nav>
