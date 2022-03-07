<?php
    // include_once '../classes/autoload.php';
    // $pTableObj=new DBOpView();
    // $patient_table=$pTableObj->patient_table();
    // echo $patient_table;

    session_start();
    if(isset($_SESSION['username']))
    {
        if($_SESSION['patient_rec_view']==0){
            // echo "<script>alert('You have no access to this feature :(');</script>";
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
        else
        {
            $table='
            <br>
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 col-md-9 col-sm-8">
                        <form class="ms-auto" id="search-field">
                            <div class="input-group">
                                <i class="btn bi bi-search"></i>
                                <input type="text" class="form-control" id="search-patient-field" placeholder="Search">
                            </div>
                        </form>
                    <br>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <button class="btn" id="add-patient-btn">
                            <span><i class="bi bi-person-plus-fill"></i></span>
                            <span class="text-uppercase small ms-1">new patient</span>
                        </button>
                    </div>
                </div>
                <hr class="dropdown-divider">
                
                <div class="table-responsive patient-table">
                
                </div>
            </div>';
            echo $table;
        }  
    }
    else
    {
        header('location:../includes/login.php');
    }
?>

