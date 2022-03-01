<?php
require_once "../res/strings.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Network Complaint Portal</title>
    <link rel="icon" href="../res/logo.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="../css/form-validation.css" rel="stylesheet">

      <script type="text/javascript" defer>
          function checkProblem(val) {
              var element = document.getElementById('problemInput');
              if (val === 'other')
                  element.style.display = 'block';
              else
                  element.style.display = 'none';
          }
      </script>

  </head>
  <body class="bg-light">
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="../res/mnnit.png" alt="" width="250" height="90">
      <h2>Complaint Submit</h2>
      <p class="lead">Submit your complaint here.</p>
    </div>

    <div class="row g-lg-3">
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Complaint Details</h4>
        <form class="needs-validation"  method="POST" action="#"  novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid Name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="" required>
              <div class="invalid-feedback">
                Please enter a valid email address to receive OTP.
              </div>
            </div>

            <div class="col-12">
              <label for="mobile" class="form-label">Mobile No.</label>
              <input type="number" class="form-control" name="mobile" id="mobile" placeholder="" required>
              <div class="invalid-feedback">
                Please enter a valid mobile number.
              </div>
            </div>

            <div class="col-12">
              <label for="location" class="form-label">Location</label>
              <input type="text" class="form-control" id="location" placeholder="" name="location" required>
              <div class="invalid-feedback">
                Please enter your Address.
              </div>
            </div>

              <div class="col-sm-6">
                  <label for="time" class="form-label">Availability time</label>
                  <input type="time" class="form-control" id="time" name="fromt" required/>
                  <div class="invalid-feedback">
                      Valid Time required.
                  </div>
              </div>

              <div class="col-sm-6">
                  <label for="time" class="form-label">.</label>
                  <input type="time" class="form-control" id="time" name="till" required/>
                  <div class="invalid-feedback">
                      Valid Time required.
                  </div>
              </div>


            <div class="col-md-5">
              <label for="country" class="form-label">Problem</label>
              <select class="form-select" id="country"  name="problemName" onchange="checkProblem(this.value);" required>
                  <option value="lanp">LAN problem</option>
                  <option value="wifip">WI-FI problem</option>
                  <option value="ipaddr">IP address issue</option>
                  <option value="proxy">Proxy issue</option>
                  <option value="lanBr">LAN port broken</option>
                  <option value="wifiSignal">Wifi Signal issue</option>
                  <option value="newRouter">New Wifi Router installation</option>
                  <option value="boot">System not booting</option>
                  <option value="noDisplay">No Display</option>
                  <option value="os">OS reinstallation</option>
                  <option value="noPower">System not powering on</option>
                  <option value="other">other</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid problem.
              </div>
            </div>

              <div class="col-12"  id="problemInput" style="display: none">
                  <label for="problemDes" class="form-label">Describe your problem</label>
<!--                  <input type="text" class="form-control" id="problemDes" placeholder="" name="problemDes">-->
                  <textarea class="form-control" id="problemDes" name="problemDes" rows="4" cols="50"></textarea>
                  <div class="invalid-feedback">
                      Please enter your Address.
                  </div>
              </div>

            <div class="col-sm-6">
              <label for="otp" class="form-label">Enter OTP (sent to email)</label>
              <input type="number" class="form-control" name="otp" id="otp" placeholder="">
              <div class="invalid-feedback">
                OTP sent to email Id is required.
              </div>
            </div>
          </div>

            <br>

          <button class="w-auto btn btn-primary btn-lg" type="submit" formaction="../verify/sendEmailOtp.php" formtarget="_blank">Send OTP</button>
            <button class="w-25 btn btn-primary btn-lg" type="submit" formaction="../verify/complainSubmit.php">Submit</button>
        </form>
      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2022 Computer Centre MNNIT</p>
  </footer>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="../assets/form-validation.js"></script>
  </body>
</html>
