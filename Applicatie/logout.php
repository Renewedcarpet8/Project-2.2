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
    if (isset($_GET['logout']))
    {
        session_destroy();
        header('location:index.php?logout=true');
        exit;
    }
?>