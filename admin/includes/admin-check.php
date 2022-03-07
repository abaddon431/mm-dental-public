<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header('location:includes/login.php');
  }
?>