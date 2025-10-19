<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<section class="text-center text-white py-5" style="
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
              url('images/about.jpeg') no-repeat center center; min-height: 50vh;
  background-size: cover;
  background-attachment: local;
">
  <div class="container">
    <h1 class="display-4 fw-bold">About Us</h1>
    <p class="lead mt-3">Creating a future where no food goes to waste and no one sleeps hungry.</p>
  </div>
</section>

<!-- Mission Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="images/about2.jpg" alt="Our Mission" class="img-fluid rounded-3 shadow">
      </div>
      <div class="col-md-6">
  <div class="p-3">
    <h2 class="fw-bold mb-3" style="font-size: 1.8rem;">Our Mission</h2>
    <p class="text-muted mb-3" style="font-size: 1.05rem; line-height: 1.7;">
      Every day, tons of edible food go to waste while millions go hungry. We’re here to change that. Our mission is to connect surplus food sources with those who need it most — NGOs, shelters, and underserved communities.
    </p>
    <p class="text-muted" style="font-size: 1.05rem; line-height: 1.7;">
      By blending technology, empathy, and grassroots action, we strive to create a world where no plate is left empty, and no meal is wasted.
    </p>
  </div>
</div>

    </div>
  </div>
</section>

<!-- Our Story -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Our Journey</h2>
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <p class="text-muted fs-5 text-center">Founded in 2024, our journey began with a vision to make food donation seamless and impactful. From humble beginnings as a social initiative, we've evolved into a movement embraced by donors, NGOs, and changemakers nationwide.</p>
        <p class="text-muted fs-5 text-center">Today, we are proud to have enabled over <strong>15,000+ meals</strong>, collaborated with <strong>120+ NGO partners</strong>, and inspired thousands to take action against food waste.</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Team -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Meet Our Team</h2>
    <div class="row g-4 text-center">
      
      <div class="col-md-4">
        <div class="card border-0 shadow-lg h-100">
          <img src="images/team1.jpg" class="card-img-top" alt="Team Member 1">
          <div class="card-body">
            <h5 class="card-title fw-semibold">Alex Roy</h5>
            <p class="text-muted mb-1">Full Stack Developer</p>
            <p class="small text-muted">Leads development and product innovation to power food-sharing solutions across regions.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card border-0 shadow-lg h-100">
          <img src="images/team2.jpg" class="card-img-top" alt="Team Member 2">
          <div class="card-body">
            <h5 class="card-title fw-semibold">Neha Joshi</h5>
            <p class="text-muted mb-1">NGO Partnership Lead</p>
            <p class="small text-muted">Forges relationships with nonprofit partners, ensuring donated food reaches trusted hands.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-lg h-100">
          <img src="images/team3.jpg" class="card-img-top" alt="Team Member 3">
          <div class="card-body">
            <h5 class="card-title fw-semibold">Ravi Kapoor</h5>
            <p class="text-muted mb-1">Operations & Logistics Head</p>
            <p class="small text-muted">Coordinates volunteer efforts and delivery operations to streamline food distribution.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background-color: #e8f5e9;">
  <div class="container text-center">
    <h2 class="fw-bold  mb-3" style="font-size: 2rem;">Be the Reason Someone Eats Today</h2>
    <p class="text-muted mb-4" style="max-width: 700px; margin: 0 auto; font-size: 1.05rem;">
      Every meal saved is a life touched. Join our mission to combat hunger and food waste in your city.
      Sign up as a donor, NGO, or volunteer — and start making an impact.
    </p>
    <a href="auth.php" class="btn btn-success btn-lg px-5 py-2 fw-semibold rounded-pill shadow">
      Get Involved
    </a>
  </div>
</section>


<?php include 'includes/footer.php'; ?>
