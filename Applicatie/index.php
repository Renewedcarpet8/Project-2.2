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
       /* if (!isset($_POST['Login'])) {
          echo "Please login first<br>";
          echo "<a href='login.php'>Click here to log in<a>";
        } else {*/
        function checkUser(){
            if (isset($_POST['Login'])) {
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
        }
        ?>
         <div class="sidenav">
           <?php if(checkUser() == true) {
            echo "<a href='#'>OPTIE 1</a>";
            echo "<a href='#'>OPTIE 2</a>";
            echo "<a href='#'>OPTIE 3</a>";
            echo "<a href='#'>BLA BLA BLA  </a>";} ?>
            <img class="SettingsIcon" src="img/settings.png"></a>

          </div>

          <div class="topnav">
              <?php if (checkUser() == true) {
                echo "<li><a href='#' class='t' >WEERGAVE 1</a></li>";
                echo "<li><a href='#' class='t' >WEERGAVE 1</a></li>";
                echo "<li><a href='#' class='t' >WEERGAVE 1</a></li>";
                echo "<li><a href='#' class='t' >WEERGAVE 1</a></li>";}?>
          </div>

          <!-- Page content -->
          <div id="main">
            ...
          </div>

          <div class="container"><div class="menu-icon"><span></span></div></div>
                  
                  <div class="dashboard" method="POST" action="login-process.php">
                      <?php
                      if (checkUser() == true) {
                        echo "<H1>Bla bla bla</br> </br></H1>";
                        echo "<span class='fa-stack fa-lg'>";
                            echo "<i class='fa fa=circle fa-stack-2x'></i>";
                            echo "<i class='fa fa-lock fa-stack-1x\'></i>";
                        echo "</span>";
                        echo "</p>";
                        echo "<img class='graphplaceholder' src='img/placeholdergraph.png'";
                      } else {
                          if (!isset($_POST['Login'])){
                              echo "<h1>Please login first";
                              echo "<a class='login-warning' href='login.php'>Click here to log in</a></h1>";
                          } else {
                              echo "<h1> login failed</h1>";
                          }
                      }

                      ?>


                  </div>
                  <div class="underlay-photo"></div>
                  <div class="underlay-black"></div>
                  <img class="hanzelogo" src="img/schoollogo-small.png">
              </body>
                <script type="text/javascript">
            $("#cssmenu").menumaker();
          </script>
          </html><?php


      ?>
