<?php
    /**
    *   connect.php
    *   An include file for connecting to the proper database
    *   
    *   @author Thomas Boyle <tjb2597@rit.edu>   
    *   @version 1.0
    *   
    *
    */
    session_start(); 
    
    include_once('assets/includes/credentials.php');
    $con=mysqli_connect("127.0.0.1",$username,$password)
        or die("couldn't connect: ".mysql_error());
    mysqli_select_db($con, "tjb2597");
?>