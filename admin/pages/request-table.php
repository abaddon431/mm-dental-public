<?php
    include_once '../classes/autoload.php';
    session_start();
    if($_SESSION['app_req_view']==1)
    {
        
        echo '
        
        <br>
        <h2 class="lead text-center">Appointment Requests</h2>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form class="ms-auto" id="app-search-field">
                    <div class="input-group">
                        <i class="btn bi bi-search"></i>
                        <input type="text" class="form-control" id="search-appointment-field" placeholder="Search">
                    </div>
                </form>
            <br>
            </div>
        </div>
        <div class="appointment-main"></div>';

        // echo $request_table;
    }
    else
    {
        echo '
            <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="text-uppercase fw-bold">
                        You do not have access to this feature 
                    </div>
                </div>
            </div>';
    }
?>
