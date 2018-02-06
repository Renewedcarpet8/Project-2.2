<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="./css/main.css" type="text/css"/>
        <link rel="stylesheet" href="./css/graphview.css" type="text/css"/>
        <link rel="stylesheet" href="./css/sidenav.css" type="text/css"/>
        <link rel="stylesheet" href="./css/topnav.css" type="text/css"/>
        <title>Weather Pressure Application</title>
        <meta charset="UTF-8">
        <link rel="icon"
              type="image/png"
              href="img/tab_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        session_start();
        //require 'errorstack.php';
        $csv = array();
        $succes = false;
        $usersucces = false;

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($handle = fopen("users.csv", "r")) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $csv[] = $data;
                }
            }

            $j = 0;
            while ($j < count($csv)) {
                if ($username == $csv[$j][1] && $password == $csv[$j][2]) {
                    $succes = true;
                    $userNumber = $csv[$j];
                    $_SESSION['usernr'] = $userNumber;
                    $_SESSION['username'] = $username;
                } elseif ($username == $csv[$j][1] && $password !== $csv[$j][2]) {
                    $usersucces = true;
                }
                $j++;
            }

            if ($succes) {
                $_SESSION['errormsg'] = "";
            } elseif ($usersucces) {
                $_SESSION['errormsg'] = "Wrong password";
            } else {
                $_SESSION['errormsg'] = "Unknown user";
            }

            fclose($handle);
        }
        if ($succes) {
            header("refresh:0;url=query1.php");
        } else {
            if (isset($_SESSION['username'])) {
                echo "Welkom";
                session_destroy();
                header("refresh:0;url=query1.php");
            } else {
                ?>
                <img class="schoollogo" src="img/schoollogo.png">
                <form class="login-form" method="POST" action="index.php">
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
                    <input type="UserID" class="login-username" autofocus="true" required="true"
                           placeholder="User ID" name="username"/>
                    <input type="password" class="login-password" required="true" placeholder="Password"
                           name="password"/>
                    <input type="submit" name="Login" value="Login" class="login-submit"/>

                    <a href="mailto:service@ictopia.com" class="login-forgot-pass">forgot password?</a>
                </form>
    <?php
    }
}
?>
        <div class="underlay-photo"></div>
        <div class="underlay-black"></div>
        <img class="hanzelogo" src="img/hanzelogo.png">
    </body>

</html>