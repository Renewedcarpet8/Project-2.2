<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <title>Prosessing login...</title>
        <meta charset="UTF-8">
        <link rel="icon" 
        type="image/png" 
        href="img/tab_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<img class="schoollogo" src="img/schoollogo.png">
	<?php
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
		      if ($succes) {
		        echo "Succesfull logon"; 
		        header( "refresh:5;url=index.php" );
		      } elseif ($usersucces) {
		      	echo "Login unsuccesfull, you have entered a wrong password, you are begin redirected"; 
			    header( "refresh:5;url=login.php" );
		      } else {
		        echo "Login unsuccesfull, username unknown, you are being redirected"; 
		        header( "refresh:5;url=login.php" );
		      }
		      ?>
	     </p>
        </form>
      <div class="underlay-photo"></div>
      <div class="underlay-black"></div> 
      <img class="hanzelogo" src="img/hanzelogo.png">
</body>
</html>