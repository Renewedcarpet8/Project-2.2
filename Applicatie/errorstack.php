<?php
    function getError(){
        $errormessage = $_SESSION['errormsg'];
        echo $errormessage;
    }
?>