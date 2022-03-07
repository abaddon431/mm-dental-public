<?php
    session_start();
    if($_SESSION['sched_cal_view']==1)
    {
        echo'<div class="row"><div class="col-md-12"><h4>Schedule Calendar</h4></div>';
        echo'<div id="calendar"></div>';
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