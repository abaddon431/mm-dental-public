<?php

    class SchedView extends SchedModel
    {
        //calendar
        public function load_events()
        {
            echo json_encode($this->loadEvents());
        }

        //requests
        public function request_fetch($id)
        {
            echo json_encode($this->requestFetch($id));
        }
        public function request_table_fetch()
        {
            $data=$this->requestTableFetch();
            $append;
            if($data==0)
            {
                $append='
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-center fw-bold my-5 text-uppercase"  id="message">There are no appointment requests
                </div> <div class="text-center"><img src="images/empty-search.png" width="50" height="25"></div>';
            }
            else
            {
                
                $length=sizeof($data);
                $counter=0;
                $append='
                <div class=" table-responsive-lg appointment-request-table">
                    <table class="table table-borderless" id="appointment-request-table">
                        <caption></caption>
                        <thead class="thead theader">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Contact No.</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>';
                while($counter<$length)
                {
                    $date=date_create($data[$counter]['start']);
                    $final_date = date_format($date,"M /d /Y");
                    $append.='<tr>
                                <td>'.$data[$counter]["id"].'</td>
                                <td>'.$data[$counter]['name'].'</td>
                                <td>'.$final_date.'</td>
                                <td>'.$data[$counter]['email'].'</td>
                                <td>
                                    <a id="'.$data[$counter]["id"].'" name="accept" class="accept-btn"><i class="bi bi-check-lg"></i></a>
                                    <a id="'.$data[$counter]["id"].'" name="reject" class="reject-btn"><i class="bi bi-x-lg"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
            }
            return $append;
        }

        public function request_table_search($text)
        {
            $data=$this->requestTableSearch($text);
            $append;
            if($data==0)
            {
                $append='
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-center fw-bold my-5 text-uppercase"  id="message">There are no appointment requests
                </div> <div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                if($length!=0)
                {
                    $counter=0;
                    $append='
                    <div class=" table-responsive-lg appointment-request-table">
                        <table class="table table-borderless" id="appointment-request-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>';
                    while($counter<$length)
                    {
                        $date=date_create($data[$counter]['start']);
                        $final_date = date_format($date,"M /d /Y");
                        $append.='<tr>
                                    <td>'.$data[$counter]["id"].'</td>
                                    <td>'.$data[$counter]['name'].'</td>
                                    <td>'.$final_date.'</td>
                                    <td>'.$data[$counter]['email'].'</td>
                                    <td>
                                        <a id="'.$data[$counter]["id"].'" name="accept" class="accept-btn"><i class="bi bi-check-lg"></i></a>
                                        <a id="'.$data[$counter]["id"].'" name="reject" class="reject-btn"><i class="bi bi-x-lg"></i></a>
                                    </td>
                                </tr>';
                        $counter++;
                    }
                    $append.='</table></div>';
                }
                else
                {
                    $append='
                    <div class="container d-flex justify-content-center align-items center" >
                        <p class="text-center fw-bold my-5 text-uppercase"  id="message">Cannot find any matches
                    </div>';
                }
            }
            return $append;
        }
    }

?>