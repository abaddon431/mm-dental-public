<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="index, follow">
  <meta name="description" content="Affordable Dental Care that you deserve | Calamba City Laguna">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <!-- AOS Link -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Google Fonts Link -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;500;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- CSS Link -->
  <link rel="stylesheet" href="css/styles.css" />

  <title>Mary Mediatrix Dental Clinic</title>
  <link rel="shortcut icon" href="images/mediatrix-favicon.svg" type="image/x-icon" alt="favicon" />
</head>

<body>
  <!-- HEADER SECTION -->
  <header class="main-header">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
          <img src="images/mediatrix-main-logo.svg" alt="mary-mediatrix-dental-clinic" width="180" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about-us-section">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact-section">Contact Us</a>
            </li>
            <li class="nav-item">
              <a href="appointment.php" class="btn btn-primary cta-btn">Request Appointment</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <!-- HERO SECTION -->
    <div class="container-fluid">
      <div class="hero-section grid">
        <div class="hero-text">
          <h1 class="header">Affordable Dental Service</h1>
          <hr class="main-line light" />
          <h2 class="sub-header">Calamba City, Laguna, Philippines</h2>
          <a href="appointment.php" class="btn btn-primary cta-btn">SCHEDULE YOUR VISIT</a>
        </div>
      </div>
    </div>
  </header>

  <!-- ABOUT US SECTION -->
  <section id="about-us-section" class="white-bg">
    <div class="container-fluid" >
      <div class="about-us grid">
        <div class="about-us-text" data-aos="fade-up" data-aos-duration="5000">
          <h2>Hello! We are Mary Mediatrix Dental Clinic.</h2>
          <hr class="main-line" />
          <p>
            Since our inception on <em>September 08, 2012</em> spearheaded by <em>Dra. Karen Grageda</em>, our mission remained
            the same, that is to <em>provide affordable yet quality Dental Service</em>
          </p>
        </div>
        <div class="about-us-img" data-aos="fade-up" data-aos-duration="4000">
          <img src="images/mediatrix-staff-images/dra grageda.jpg" alt="mediatrix-staff"  />
        </div>
      </div>
    </div>
  </section>

  <!-- CLINIC SECTION -->
  <section id="our-clinic-section" class="main-colored-bg">
    <div class="container-fluid">
      <div class="our-clinic">
        <div class="clinic-text" data-aos="fade-up" data-aos-duration="5000"">
          <h2>State of the Art clinic.</h2>
          <hr class="main-line" />
          <p>
            We are a <em>COVID-19 ready</em> clinic.<br />
            Rest assured that your safety is our priority.
          </p>
        </div>

        <!-- CLINIC CAROUSEL -->
        <div class="clinic-carousel" data-aos="fade-up" data-aos-duration="4000">
          <div id="main-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="images/clinic-images/real-images/20220118_130021.jpg" class="d-block w-100 img-fluid" alt="carousel-image1" />
              </div>
              <div class="carousel-item">
                <img src="images/clinic-images/real-images/20220118_130121.jpg" class="d-block w-100 img-fluid" alt="carousel-image2" />
              </div>
              <div class="carousel-item">
                <img src="images/clinic-images/real-images/20220118_131703.jpg" class="d-block img-fluid w-100" alt="carousel-image3" />
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#main-carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#main-carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <div class="carousel-cta-container">
            <a href="appointment.php" class="btn btn-primary cta-btn">SCHEDULE YOUR VISIT</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- OUR OFFERS SECTION -->
  <section id="our-offers-section" class="white-bg">
    <div class="container-fluid">
      <div class="our-offers">
        <div class="offers-text">
          <h2>What we offer.</h2>
          <hr class="main-line" />
          <p>These factors sets us apart from other dental clinics.</p>
        </div>
        <div class="offers-cards grid">
          <div class="offers-card card1" data-aos="fade-up" data-aos-duration="5000">
            <img src="images/icons/target.svg" alt="precision-icon" class="card-img" />
            <h3>Precision</h3>
          </div>
          <div class="offers-card card2" data-aos="fade-up" data-aos-duration="5000">
            <img src="images/icons/money.svg" alt="affordability-icon" class="card-img" />
            <h3>Affordability</h3>
          </div>
          <div class="offers-card card3" data-aos="fade-up" data-aos-duration="5000">
            <img src="images/icons/medical_doctor.svg" alt="professionalism-icon" class="card-img" />
            <h3>Professionalism</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CUSTOMER FEEDBACK SECTION -->
  <section id="customer-feedback-section" class="white-bg">
    <div class="container-fluid">
      <div class="customer-feedback">
        <h2>Some of our customer feedback.</h2>
        <hr class="main-line" />
        <p>Providing the best smile for our patients is our mission.</p>
        <div class="feedback-cards grid">
          <div class="feedback-card f_card1" data-aos="fade-up" data-aos-duration="5000">
            <h3>"Outstanding dental service from start to finish"</h3>
            <h4>Mike</h4>
          </div>
          <div class="feedback-card f_card2" data-aos="fade-up" data-aos-duration="5000">
            <h3>
              "I felt safe and satisfied with my very first visit to the
              dentist, great patient experience"
            </h3>
            <h4>Cassian</h4>
          </div>
          <div class="feedback-card f_card3" data-aos="fade-up" data-aos-duration="5000">
            <h3>
              "Mary Mediatrix has been my dental clinic for years and it will
              remain to be for the years to come"
            </h3>
            <h4>Kenneth</h4>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT SECTION -->
  <section id="contact-section" class="main-colored-bg">
    <div class="container-fluid">
      <div class="contact-us">
        <h2>Let's get in touch</h2>
        <div class="map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15470.380304517761!2d121.141448!3d14.218472!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x335241cc39d7d436!2sMary%20Mediatrix!5e0!3m2!1sen!2sph!4v1642658481548!5m2!1sen!2sph" height="300" width="300" style="border: 0" allowfullscreen="" loading="lazy" alt="google-map"></iframe>
        </div>
        <p>
          Mary Mediatrix Dental Clinic is conviniently located at <br>
          <em>Checkpoint, Calamba City</em>
        </p>
        <div class="socials-container">
          <h3>
            Visit us on our Facebook page or reach to us at our official email
          </h3>
          <a href="https://www.facebook.com/mmediatrixdentalclinic/"><img src="images/icons/facebook.svg" alt="facebook-icon" /></a>
          <h4>mmdental@email</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA SECTION -->
  <section id="cta-section" class="main-colored-bg">
    <div class="container-fluid">
      <div class="call-to-action" data-aos="fade-up" data-aos-duration="4000">
        <h2>Don't miss out on affordable dental care that you deserve.</h2>
        <a href="appointment.php" class="btn btn-primary">SCHEDULE YOUR VISIT</a>
        <div class="cta-socials"></div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="colored-bg">
    <div class="container-fluid">
      <div class="main-footer">
        <h4>
          All rights reserved to <br /><em>Mary Mediatrix Dental Clinic</em>
        </h4>
        <div class="footer-icons"></div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- AOS -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>