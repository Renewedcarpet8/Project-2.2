
<html>
    <head>
        <link rel="stylesheet" href="css/main.css" type="text/css"/>

        <title>Weather Pressure Application</title>
        <meta charset="UTF-8">
        <link rel="icon" 
        type="image/png" 
        href="img/tab_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <?php
        require 'errorstack.php';
        session_start();
    ?>
        <img class="schoollogo" src="img/schoollogo.png">
        <form class="login-form" method="POST" action="login-process.php">
            <center><img src="img/lockicon.png"></center>
          <p class="login-text">
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-lock fa-stack-1x"></i>
            </span>
          </p>
            <?php
                if (!empty($_SESSION['errormsg'])) {
                    print_r($_SESSION['errormsg']);
                }
            ?>
          <input type="UserID" class="login-username" autofocus="true" required="true" placeholder="User ID" name="username" />
          <input type="password" class="login-password" required="true" placeholder="Password" name="password" />
          <input type="submit" name="Login" value="Login" class="login-submit" />
          
          <a href="mailto:service@ictopia.com" class="login-forgot-pass">forgot password?</a>
        </form>
        <div class="underlay-photo"></div>
        <div class="underlay-black"></div> 
        <img class="hanzelogo" src="img/hanzelogo.png">
    </body>
      
    </body>
</html>