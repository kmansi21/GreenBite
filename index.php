<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Hero Section with Background Image -->
<section class="hero-section text-center text-white d-flex align-items-center" style="
  min-height: 90vh;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
              url('images/home.jpg') no-repeat center center;
  background-size: cover;
  background-attachment: local;
">
  <div class="container">
    <h1 class="display-3 fw-bold mb-3">Share Food. Share Hope.</h1>
    <p class="lead mb-4">Every surplus meal can become a lifeline for someone in need.</p>
    <div class="d-flex justify-content-center flex-wrap gap-3">
      <a href="donate.php" class="btn btn-success btn-lg px-4 shadow-sm">Donate Food</a>
      <a href="request.php" class="btn btn-outline-light btn-lg px-4 shadow-sm">Request Help</a>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<!-- How It Works Section -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">How It Works</h2>
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <i class="bi bi-pencil-square text-success mb-3" style="font-size: 2.5rem;"></i>
          <h5 class="fw-semibold">Step 1: Fill Donation Form</h5>
          <p class="text-muted">Describe your food and upload an image. Takes less than 2 minutes!</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <i class="bi bi-bell text-success mb-3" style="font-size: 2.5rem;"></i>
          <h5 class="fw-semibold">Step 2: We'll Notify Nearby Helpers</h5>
          <p class="text-muted">Our system alerts NGOs or individuals close to your location.</p>
        </div>
      </div>
      <div class="col-md-4">
  <div class="p-4 border rounded shadow-sm h-100">
    <i class="bi bi-people-fill text-success mb-3" style="font-size: 2.5rem;"></i>
    <h5 class="fw-semibold">Step 3: Food Reaches the Right Hands</h5>
    <p class="text-muted">A verified volunteer or recipient safely collects the food. Your simple act brings comfort, dignity, and nourishment to someone in need.</p>
  </div>
</div>

      </div>
    </div>
  </div>
</section>


<!-- Impact in Numbers Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Together, We've Made an Impact</h2>
    <div class="row text-center g-4">
      <div class="col-md-3">
        <div class="p-4 shadow-sm rounded bg-white">
          <h3 class="text-success fw-bold">15,000+</h3>
          <p class="mb-0 text-muted">Meals Donated</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-sm rounded bg-white">
          <h3 class="text-success fw-bold">2,500+</h3>
          <p class="mb-0 text-muted">Families Fed</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-sm rounded bg-white">
          <h3 class="text-success fw-bold">500+</h3>
          <p class="mb-0 text-muted">Volunteers Engaged</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-sm rounded bg-white">
          <h3 class="text-success fw-bold">40+</h3>
          <p class="mb-0 text-muted">Cities Covered</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- FAQ Section -->
<!-- FAQ Section -->
<section class="py-5 bg-white border-top">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Frequently Asked Questions</h2>
    <p class="text-center text-muted mb-5">Everything you need to know about donating or requesting food.</p>

    <div class="accordion" id="faqAccordion">

      <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-medium text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            🥗 Is there any cost to donate food?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            No, our food donation platform is completely free to use for everyone.
          </div>
        </div>
      </div>

      <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-medium text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            🍛 Can I donate leftover food from events?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Yes, you can! Just make sure the food is vegetarian, hygienic, and safe for consumption.
          </div>
        </div>
      </div>

      <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-medium text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            🚚 Who will collect the food after I donate?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            The nearest NGO or individual in need will be notified and will directly coordinate with you to collect the food.
          </div>
        </div>
      </div>

      <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-medium text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
            📍 Can I choose a pickup time for the food?
          </button>
        </h2>
        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Yes, during the donation process, you can mention your preferred pickup time for better coordination.
          </div>
        </div>
      </div>

      <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-medium text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
            ✅ How will I know if someone has accepted my food?
          </button>
        </h2>
        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            You will receive a confirmation on your donar history  once someone accepts your donation and schedules the pickup.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



<!-- Call to Action Section -->
<section class="py-5" style="background-color: #f1f8f4;">
  <div class="container text-center">
    <h2 class="fw-bold text-dark mb-3" style="font-size: 2rem;">
      Join the Movement Against Food Waste
    </h2>
    <p class="text-muted mb-4" style="max-width: 600px; margin: 0 auto; font-size: 1.05rem;">
      Whether you're an individual, restaurant, or NGO, your contribution matters. Together, we can make sure no meal is left behind.
    </p>
    <a href="auth.php" class="btn btn-success px-4 py-2 rounded-pill fw-semibold shadow-sm" style="font-size: 1rem;">
      Register & Make a Difference
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
