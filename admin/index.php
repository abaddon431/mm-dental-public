<?php 
include 'includes/admin-check.php';
?>
<!DOCTYPE html>

<html>
<head>
    <title>Admin Panel | Mary Mediatrix Dental Clinic</title>
    <link rel="shortcut icon" href="images/mediatrix-favicon.svg">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/datatables/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="includes/fullcalendar/lib/main.css" />
    <script src='includes/fullcalendar/lib/moment.js'></script>
    <script src="includes/fullcalendar/lib/main.js"></script>
    <script src='includes/fullcalendar/lib/main.global.min.js'></script>
    <link rel="stylesheet" href="css/tooth-chart/dental_chart.css" />
    <link id="app-theme" rel="stylesheet" href="css/admin-style.css" />
</head>
<body>
  <div class="main-loader">
    <div>
    </div>
  </div>
  <!-- navbar -->
  <div class="main-content">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top custom-nav" id="main-nav">
    <div class="container-fluid">
      <!-- offcanvas toggle-->
      <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
      </button>
      <!-- offcanvas toggle end-->
      
      <a class="navbar-brand me-auto fw-bold text-uppercase small" href="#"><img src="images/mediatrix-main-logo.svg" alt="mediatrix-logo" width="160"></a>
     
      <li class="nav-item dropdown custom-nav-dd">
        
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-fill"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-light custom-dropdown" aria-labelledby="navbarDropdown">
          <!-- <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-1"></i>Settings</a></li> -->
          <!-- <li><hr class="dropdown-divider"></li> -->
          <li><a class="dropdown-item arrow-icon" href="includes/logout.php" onclick="return confirm('Are you sure to logout?');"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
        </ul>
      </li>
    </div>
  </nav>
  
  <!-- navbar end -->

  <!-- main section  -->
  

  <main class="mt-5 pt-3 px-3" id="main-div">
  </main>
  <!-- main section end  -->
  
  <!-- side-nav -->
  <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">  
    <div class="offcanvas-body p-0">
        <nav class="navbar-light">
          
          <ul class="navbar-nav">
            <li>
              <div class="text-muted fw-bold small text-uppercase text-center px-3 mt-3"><?= $_SESSION['username']?></div>
            </li>
            <li>
              <div class="text-muted fw-bold small text-uppercase px-3 mt-3">Main</div>
            </li>
            <li class="mx-2">
                <hr class="dropdown-divider">
              </li>
            <li>
              <a href="#" class="nav-link px-3 nav-items sidebar-link" id="dashboard">
                <span><i class="bi bi-speedometer"></i></span>
                <span class="text-uppercase small ms-1">Dashboard</span>
              </a>
            </li>


            <?php
                if($_SESSION['patient_rec_view']!=0)
                {
                  echo '<li>
                  <a class="nav-link px-3 nav-items sidebar-link" data-bs-toggle="collapse" href="#patients" role="button" aria-expanded="false" aria-controls="patients">
                    <span><i class="bi bi-people-fill"></i></span>
                    <span class="text-uppercase small ms-2">Patients</span>
                    <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                  </a>
                  <div class="collapse" id="patients">
                    <div>
                      <ul class="navbar-nav ps-3">
                        <li>
                          <a href="#" class="nav-link px-3 nav-items" id="patient-records">
                            <span><i class="bi bi-file-earmark-person-fill"></i></span>
                            <span class="text-uppercase small ms-1" id="records">Patient Records</span>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="nav-link px-3 nav-items" id="generate_monthly_report">
                            <span><i class="bi bi-file-earmark-text"></i></span>
                            <span class="text-uppercase small ms-1">Patients Report</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>' ;
                }
              ?>
            
            <?php
              if($_SESSION['sched_cal_view']!=0)
              {
                echo '<li>
                <a class="nav-link px-3 sidebar-link nav-items" data-bs-toggle="collapse" href="#schedule" role="button" aria-expanded="false" aria-controls="schedule">
                  <span><i class="bi bi-calendar3"></i></span>
                  <span class="text-uppercase small ms-2">Schedule</span>
                  <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                </a>
                <div class="collapse" id="schedule">
                  <div>
                    <ul class="navbar-nav ps-3">
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="sched_calendar">
                          <span><i class="bi bi-clock"></i></span>
                          <span class="text-uppercase small ms-1">Schedule Calendar</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="app-requests">
                          <span><i class="bi bi-question-circle-fill"></i></span>
                          <span class="text-uppercase small ms-1">Appointment Requests</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="generate_appointment_report">
                          <span><i class="bi bi-file-earmark-text"></i></span>
                          <span class="text-uppercase small ms-1">Appointments Report</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>';
              }
            ?>
            
            <?php
              if($_SESSION['clinic_proc_view']!=0)
              {
                echo '<li>
                <a class="nav-link px-3 nav-items sidebar-link" data-bs-toggle="collapse" href="#clinic" role="button" aria-expanded="false" aria-controls="clinic">
                  <span><i class="bi bi-building"></i></span>
                  <span class="text-uppercase small ms-2">Clinic</span>
                  <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                </a>
                <div class="collapse" id="clinic">
                  <div>
                    <ul class="navbar-nav ps-3">
                      <!-- <li>
                        <a href="#" class="nav-link px-3 nav-items" id="clinic-profile">
                          <span><i class="bi bi-person-circle"></i></span>
                          <span class="text-uppercase small ms-1" id="records">Clinic Profile</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="clinic-medicines">
                          <span><i class="bi bi-clipboard-plus"></i></span>
                          <span class="text-uppercase small ms-1" id="records">Medicines</span>
                        </a>
                      </li> -->
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="clinic-procedures">
                          <span><i class="bi bi-card-list"></i></span>
                          <span class="text-uppercase small ms-1">Procedures</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>';
              }
            ?>  
            <?php
              if($_SESSION['user_manage_view']!=0)
              {
                echo '<li>
                <a class="nav-link px-3 sidebar-link nav-items" data-bs-toggle="collapse" href="#manage-users" role="button" aria-expanded="false" aria-controls="manage-users">
                  <span><i class="bi bi-person-lines-fill"></i></span>
                  <span class="text-uppercase small ms-2">Manage Users</span>
                  <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                </a>
                <div class="collapse" id="manage-users">
                  <div>
                    <ul class="navbar-nav ps-3">
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="manage-list">
                          <span><i class="bi bi-list-ul"></i></span>
                          <span class="text-uppercase small ms-1">User List</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="nav-link px-3 nav-items" id="manage-role">
                          <span><i class="bi bi-bezier"></i></span>
                          <span class="text-uppercase small ms-1">Role Management</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>';
              }
            ?>
            
            <!-- <li>
              <a href="#" class="nav-link px-3 nav-items sidebar-link" id="sms-status">
                <span><i class="bi bi-envelope-fill"></i></span>
                <span class="text-uppercase small ms-1">SMS Status</span>
              </a>
            </li> -->
            <!-- divide -->
            
            
            <div class="last-btn-grp">
              <li class="mx-2">
                <hr class="dropdown-divider">
              </li>
              <li>
                <a href="#" class="nav-link px-3 nav-items" id="settings">
                  <span><i class="bi bi-gear-fill"></i></span>
                  <span class="text-uppercase small ms-1">Settings</span>
                </a>
              </li>
              <li>
                <a class='nav-link px-3 nav-items' href="includes/logout.php" onclick="return confirm('Are you sure to logout?');">
                  <span><i class="bi bi-box-arrow-right"></i></span>
                  <span class="text-uppercase small ms-1">Logout</span>
                </a>
              </li>
            </div>
          </ul>
        </nav>
    </div>
  </div>
  <!-- side nav end -->

 
  <!-- event modal -->
  <div id="add_event_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
              <div class="modal-header">
                  <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Add Appointment</h5>
              </div>
              <div class="row">
                  <nav class="navbar navbar-expand custom-nav-existing">
                      <ul class="navbar-nav">
                          <li class="nav-item">
                              <a class="nav-link existing-nav active" id="existing-patient">Existing</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link existing-nav" id="new-patient">New</a>
                          </li>
                      </ul>
                  </nav>
              </div>
              <div class="modal-body addevent_modalbody" id="insert-form"> 
                  
              </div>
            </div>
        </div> 
  </div>
  <!--add request modal-->
  <div id="add_request_modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Add Appointment</h5>
            </div>
            <div class="row">
                  <nav class="navbar navbar-expand custom-nav-existing">
                      <ul class="navbar-nav">
                          <li class="nav-item">
                              <a class="nav-link req-existing-nav active" id="req-existing-patient">Existing</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link req-existing-nav" id="req-new-patient">New</a>
                          </li>
                      </ul>
                  </nav>
              </div>
              <div class="modal-body addrequest_modalbody" id="rinsert-form"> 
                  
              </div>   
           </div>  
      </div> 
 </div>


  <!-- message modal -->
  <div class="modal" tabindex="-1" id="message_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold small text-uppercase ModalLabel" id="message_modal_title">Alert</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="message_modal_msg">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn custom-modal-btn" id="ok-btn" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
   <!-- alert modal -->
   <div id="alert_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
              <div class="modal-header">
                  <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Add Appointment</h5>
              </div>
                  <div class="modal-body" id="insert-form"> 
                      <div class="modal-body" id="alert_msg">
                      </div>
                      <button type="button" class="btn custom-modal-btn" id="yes-btn" data-bs-dismiss="modal">Yes</button>   
                      <button type="button" class="btn custom-modal-btn" id="close-btn" data-bs-dismiss="modal">No</button> 

                      </form>
                  </div>
            </div>
        </div> 
  </div>
</div>
  <!-- scripts -->
<script src="js/jquery/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.bootstrap5.min.js"></script>
<script src="js/chart/chart.min.js"></script>
<!-- <script src="js/chart/chartjs-plugin-labels.min.js"></script> -->
<script src="js/jquery/jquery.validate.min.js"></script>
<script src="js/jquery/jquery.validate.extend.js"></script>
<script src="js/script.js"></script>
<script src="js/tooth-chart/dental_chart.js"></script>
</body>
</html>