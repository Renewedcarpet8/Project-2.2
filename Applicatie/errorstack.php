<?php
    function getError(){
        $errormessage = $_SESSION['errormsg'];
        print_r($errormessage);
    }
?>