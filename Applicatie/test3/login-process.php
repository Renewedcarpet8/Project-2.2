<!DOCTYPE html>
<html lang="en" manifest="offlineAvailable.appcache">
    <head>
        <link rel="stylesheet" href="css/sidenav.css" type="text/css"/>
        <link rel="stylesheet" href="css/main.css" type="text/css"/>
        <link rel="stylesheet" href="css/topnav.css" type="text/css"/>
        <link rel="stylesheet" href="css/graphview.css" type="text/css"/>
        <script type="text/javascript" src="js/menumaker.js"></script>
        <title>Weather Pressure Application</title>
        <meta charset="UTF-8">
        <link rel="icon" 
        type="image/png" 
        href="img/tab_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>
	<img class="schoollogo" src="img/schoollogo.png">
	<?php
    session_start();
		$username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $csv = array();

		if ($handle = fopen("users.csv", "r")) {
			while (($data = fgetcsv($handle, 1000, ",")) !==FALSE) {
				$csv[] = $data;
			}
		}
		$succes = false;
	   	$usersucces = false;

		$j = 0;
		while ($j < count($csv)) {
			if ($username == $csv[$j][1] && $password == $csv[$j][2]) {
				$succes = true;
				$userNumber = $csv[$j];
				$_SESSION['usernr'] = $userNumber;
			} elseif ($username == $csv[$j][1] && $password !== $csv[$j][2]) {
				$usersucces = true;
			}
			$j++;
		}

		fclose($handle);
      ?>
      <form class="login-check-form" method="POST" action="login-process.php">
            <center><img src="img/gear.gif"></center>
          <p class="login-check-text">
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-lock fa-stack-1x"></i>
            </span>
          </p>
			<?php
            $errormessage = [];
		      if ($succes) {
		        echo "<h1>Welcome" . $userNumber[3] . "</h1><br>";
		        echo "<h3>Loading data..</h3>";
		        $_SESSION['errormsg'] = "";
		        header( "refresh:2;url=query1.php" );
		      } elseif ($usersucces) {
		        $errormessage = "Wrong password";
		        $_SESSION['errormsg'] = $errormessage;
		      	echo "Login unsuccesfull, you have entered a wrong password, you are begin redirected"; 
			    header( "refresh:0;url=index.php" );
		      } else {
		        echo "Login unsuccesfull, username unknown, you are being redirected";
		        //$errormessage = "Username unknown";
                $_SESSION['errormsg'] = $errormessage;
		        header( "refresh:0;url=index.php" );
		      }
		      ?>
	     </p>
        </form>
      <div class="underlay-photo"></div>
      <div class="underlay-black"></div> 
      <img class="hanzelogo" src="img/hanzelogo.png">
</body>
</html>