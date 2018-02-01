<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
 require 'requirebars.php';
 require 'errorstack.php';
?>
<img class="schoollogographmode" src="img/schoollogo-small.png">

<div class="container-graph"><div class="menu-icon"><span></span></div></div>

<div class="dashboard-graph" method="POST">
    <H1>Graph Viewer</br> </br></H1>
    <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
    </p>
    <div class="cont">
        <?php  print_r($_SESSION['errormsg'])?>
        <canvas id="myChart"></canvas>
    </div>
</div>




<div class ="container-control">
    <div class="dashboard-control" method="POST">
        <H1>Graph Control</br> </br></H1>
        <span class='fa-stack fa-lg'>

              <img href='#' id="pdf" src="img/adobe-pdf-icon.png">
                <div id="pdfoverlay">
                    <div class="text">Download to PDF</div>
                </div>
                <i class='fa fa=circle fa-stack-2x'></i>
                <i class='fa fa-lock fa-stack-1x'</i>

             </span>
        </p>
    </div>
    <div class ="container-values">
        <div class="dashboard-values" method="POST">
            <H1>Values</br> </br></H1>
            <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
            </p>
            <table class ='values'>
                <th> Date </th>
                <th> Value</th>

        </div>
    </div>



    <div class="underlay-photo"></div>
    <div class="underlay-black"></div>
</div>
</body>
</html>