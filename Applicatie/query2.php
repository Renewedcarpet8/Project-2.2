<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/sidenav.css" type="text/css"/>
    <link rel="stylesheet" href="./css/main.css" type="text/css"/>
    <link rel="stylesheet" href="./css/topnav.css" type="text/css"/>
    <link rel="stylesheet" href="./css/graphview.css" type="text/css"/>
    <script type="text/javascript" src="js/menumaker.js"></script>
    <title>Weather Pressure Application</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon"
          type="image/png"
          href="img/tab_icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.0.1/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <?php
    session_start();
    require 'StationData.php';
    require 'dataset1.php';
    require 'requirebars.php';
    if (isset($_SESSION['username'])){
    ?>
    <img class="schoollogographmode" src="img/schoollogo-small.png">

    <div class="container-graph"><div class="menu-icon"><span></span></div></div>


<div id="dashboard-graph" method="POST">
    <H1 class="">Table</H1>
    <table id="table">
        <?php getOverview(); ?>
    </table>
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
              <H1>Values</br> </H1>
              <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
              </p>
              <table class ='values' style="margin: auto">
                    The ID you selected is: <?php echo $_GET['id'] ?><br><br>
                  <th> Test </th>
                  <th> Value</th>
                  <tr>
                      <td>Min Temp</td>
                      <td><?php getMinValue($_GET['id'], $_GET['country'],3) ?> &#8451</td>
                  </tr>
                  <tr>
                      <td>Max Temp</td>
                      <td><?php getMaxValue($_GET['id'], $_GET['country'], 3) ?> &#8451</td>
                  </tr>
                  <tr>
                      <td>Min Airpressure</td>
                      <td><?php getMinValue($_GET['id'], $_GET['country'], 5) ?> Pa</td>
                  </tr>
                  <tr>
                      <td>Max Airpressure</td>
                      <td><?php getMaxValue($_GET['id'], $_GET['country'], 5) ?> Pa</td>
                  </tr>
                  <tr>
                      <td>Max Windspeed</td>
                      <td><?php getMaxValue($_GET['id'], $_GET['country'], 8)?> KM/h</td>
                  </tr>
                  <?php
                  //echo readData("data1.csv");
                  ?>
          </div>
      </div>
        <?php
        } else{
            header('location:index.php');
            exit;
        }
      ?>
      <div class="underlay-photo"></div>
      <div class="underlay-black"></div>
</body>
</html>
