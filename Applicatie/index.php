<html>
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
    <?php
        if (!isset($_POST['Login'])) {
          echo "Please login first<br>";
          echo "<a href='login.pgp'></a>";
        } elseif (isset($_POST['login'])) {
          echo "Hallo";
        } else {
        function checkUser(){
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
              return true;
            } elseif ($username == $csv[$j][1] && $password !== $csv[$j][2]) {
              $usersucces = true;
            }
            $j++;
          }
          
          fclose($handle);
        }
       if (checkUser() == true) {
        ?>
         <div class="sidenav">
            <a href="#">OPTIE 1</a>
            <a href="#">OPTIE 2</a>
            <a href="#">OPTIE 3</a>
            <a href="#">BLA BLA BLA  </a>
            <img class="SettingsIcon" src="img/settings.png"></a>
          </div>

          <div class="topnav">
            <li><a href="#" class="t" >WEERGAVE 1</a></li>
            <li><a href="#" class="t" >WEERGAVE 2</a></li>
            <li><a href="#" class="t" >WEERGAVE 3</a></li>
            <li><a href="#" class="t" >WEERGAVE 4</a></li>
          </div>

          <!-- Page content -->
          <div id="main">
            ...
          </div>

          <div class="container"><div class="menu-icon"><span></span></div></div>
                  
                  <div class="dashboard" method="POST" action="login-process.php">
                      <H1>Bla bla bla</br> </br></H1>
                      <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-lock fa-stack-1x"></i>
                      </span>
                    </p>
                    <img class="graphplaceholder" src="img/placeholdergraph.png">
                  </div>
                  <div class="underlay-photo"></div>
                  <div class="underlay-black"></div> 
                  <img class="hanzelogo" src="img/hanzelogo.png">
              </body>
                <script type="text/javascript">
            $("#cssmenu").menumaker();
          </script>
          </html><?php
       } else {
        die("login unsuccesfull");
        echo "Login unsuccesfull";
       }
     }
      ?>
