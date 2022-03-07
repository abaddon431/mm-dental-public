<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap Link -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- Google Fonts Link -->

    <!-- CSS Link -->
    <link rel="stylesheet" href="css/appointment.css" />

    <title>Mary Mediatrix Dental Clinic</title>
    <link
      rel="shortcut icon"
      href="images/mediatrix-favicon.svg"
      type="image/x-icon"
      alt="favicon"
    />
  </head>
  <body>
    <div class="container-fluid suggestPage">
      <div class="title-container">
        <h1>Request for Appointment</h1>
      </div>
      <div class="row"></div>
      <form method="post" id="appointment-form">
        <div class="mb-3">
          <label for="first-name" class="form-label">First name</label>
          <input type="text" class="form-control" id="firstname" placeholder="Juan" required/>
        </div>
        <div class="mb-3">
          <label for="last-name" class="form-label">Last name</label>
          <input type="text" class="form-control" id="lastname" placeholder="Dela Cruz" required/>
        </div>
        <div class="mb-3">
          <label for="mobile-number" class="form-label">Mobile Number</label>
          <input type="text" class="form-control" id="contactno" placeholder="09XXXXXXXXX" minlength="11" maxlength="11" required/>
        </div>
        <div class="mb-3">
            <label for="appointment-date" class="form-label">Date of Appointment</label>
            <input type="date" class="form-control" id="date" required />
          </div>
        <a href="index.php" class="btn btn-outline-primary">Back</a>
        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Submit">
      </form>
    </div>

    <!-- Bootstrap JS with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script src="js/jquery/jquery-3.6.0.min.js"></script>
    <script src="js/appointment.js"></script>
  </body>
</html>
