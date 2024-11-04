<?php
    session_start();

    if (session_destroy()) {
        header("Location: /laundry_system/homepage/homepage.php");
        exit();
    }
    
?>