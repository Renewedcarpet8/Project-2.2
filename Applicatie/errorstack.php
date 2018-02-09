<!DOCTYPE html>
<html lang="en" manifest="offlineAvailable.appcache">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
</body>
</html>
<?php
    function getError(){
        $errormessage = $_SESSION['errormsg'];
        echo $errormessage;
    }
?>