<?php
    /**
    *   signout.php
    *   File to sign out. Users get sent here then immediately back to index.php
    *   Destroys session
    *   @author Thomas Boyle <tjb2597@rit.edu>   
    *   @version 1.0
    *   
    *
    */

    session_start();
    session_destroy();

    echo "<meta http-equiv='refresh' content='0;URL=index.php' />";
?>