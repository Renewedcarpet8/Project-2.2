<html>
    <head>
        <link rel="stylesheet" href="style.css" type="text/css"/>

        <title>Weather Pressure Application</title>
        <meta charset="UTF-8">
        <link rel="icon" 
        type="image/png" 
        href="img/tab_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <img class="schoollogo" src="img/schoollogo.png">
        <form class="login-form" method="POST" action="login-process.php">
            <center><img src="img/forgetpw.png"></center>
          <p class="login-text">
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-lock fa-stack-1x"></i>
            </span>
          </p>
          <input type="password" class="login-username" autofocus="true" required="true" placeholder="Email" name="username" />
          <input type="password" class="login-username" autofocus="true" required="true" placeholder="Email" name="username" />
          <input type="password" class="login-password" required="true" placeholder="Password" name = "password" />
          <input type="submit" name="Login" value="Login" class="login-submit" />

          <a href="forgotPassword.php" class="login-forgot-pass">forgot password?</a>
        </form>
        <div class="underlay-photo"></div>
        <div class="underlay-black"></div> 
        <img class="hanzelogo" src="img/hanzelogo.png">
      
    </body>
</html>
