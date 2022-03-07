
<div class="row">
  <div class="col-md-12">
    <h4 class="testing">Dashboard</h4>
  </div>
</div>
<div class="row">
  <div class="col-md-4 mb-4">
    <div class="card  h-100 main-card">
      <div class="card-body fs-1 text-center" id="patients_today">0</div>
      <div class="card-footer d-flex">
        Appointments Today
      </div>
    </div>
  </div>
  <div class="col-md-4 mb-4">
    <div class="card h-100 main-card">
      <div class="card-body fs-1 text-center" id="total_patients">0</div>
      <div class="card-footer d-flex">
        Total Patients
      </div>
    </div>
  </div>
  <div class="col-md-4 mb-4">
    <div class="card  h-100 main-card">
      <div class="card-body fs-1 text-center" id="ap_req">0</div>
      <div class="card-footer d-flex">
        Appointment Requests
      </div>
    </div>
  </div>
  
</div>



<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
          <div class="card-header">
              <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
              5 Frequent Operations
          </div>
          <div class="card-body">
              <canvas class="chart operations-datachart" width="400" height="200"></canvas>
          </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                Monthly Growth
            </div>
            <div class="card-body">
                <canvas class="chart monthlygrowth-datachart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <span class="me-2"><i class="bi bi-pie-chart-fill"></i></span>
                Gender Ratio
            </div>
            <div class="card-body">
                <canvas class="chart gender-datachart" id="pie-chart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-3">
        <div class="card h-100">
          <div class="card-header">
              <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
              Age Groups
          </div>
          <div class="card-body">
              <canvas class="chart age-datachart"  width="400" height="200"></canvas>
          </div>
        </div>
    </div>
    <!-- <div class="col-md-4 mb-4">
      <div class="card h-100 main-card">
        
      <button type="button" class="generate_report" id="generate_report">
      <i class="bi bi-file-earmark-text"></i>
        Generate Report
      </button>
      </div>
    </div> -->
    <!-- <div class="container-fluid">
      <div class="table-responsive">
        <table class="table table-borderless" id="patient-table"> 
          <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Full Name</th>
            <th scope="col">Contact No.</th>
            <th scope="col">Email</th>
            <th scope="col">Last Edited</th>
            </tr>
          </thead>
        </table>
      </div>
    </div> -->
</div>



<script>
  var app_timeout=5000;
  var prev_num=0;
    (function(){
        countAppointment();
        countToday();
        setTimeout(arguments.callee, app_timeout);
    })();
    countPatients();
    function countAppointment()
    {
      $.get('includes/dashboard/appointment-count.php',function(data){
          $('#ap_req').html(data);
          if(prev_num==data)
          {
            app_timeout=10000;
          }
          else
          {
            app_timeout=5000;
          }
          prev_num=data;
        });
    }
    function countToday()
    {
      $.get('includes/dashboard/patients-today.php',function(data){
          $('#patients_today').html(data);
      });
    }
    function countPatients()
    {
      $.get('includes/dashboard/total-patients.php',function(data){
          $('#total_patients').html(data);
      });
    }
    

    // $('#generate_report').on('click',function(){
    //   window.open('includes/report/generate-report.php','_blank');
    // });

</script>
