<?php
    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['patient_gender']))
    {
        include_once '../../classes/autoloader.php';
        $add=new DBOpController();
        $params=new PatientParams();
        $params->pFName=$_POST['firstname'];
        $params->pLName=$_POST['lastname'];
        $params->pSex=$_POST['patient_gender'];
        $params->birthdate=$_POST['birthdate'];

        $bday=$params->birthdate;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($bday), date_create($today));
        $age=$diff->format('%y');
        $params->pAge=$age;
        $params->address=$_POST['address'];
        $params->civilstat=$_POST['civil_status'];
        $params->occupation=$_POST['occupation'];
        $params->religion=$_POST['religion'];
        $params->notes=$_POST['notesarea'];
        $params->allergies=$_POST['allergies'];
        if($_POST['contactno']!=="")
            $params->pContact=$_POST['contactno'];
        else
            $params->pContact="None";
        if($_POST['email']!=="")
            $params->pEmail=$_POST['email'];
        else
            $params->pEmail="None";
        
        $add->patient_add($params,$_POST['id'],$_POST['method']);
    }
    else
        header('location: ../admin/login.php');
?>