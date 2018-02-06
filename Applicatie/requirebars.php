<!doctype html>
<html lang="en" manifest="offlineAvailable.appcache">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/sidenav.css" type="text/css"/>
    <link rel="stylesheet" href="css/main.css" type="text/css"/>
    <link rel="stylesheet" href="css/topnav.css" type="text/css"/>
    <link rel="stylesheet" href="css/graphview.css" type="text/css"/>
    <script type="text/javascript" src="js/menumaker.js"></script>
    <title>Weather Pressure Application</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon"
          type="image/png"
          href="img/tab_icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();

 function getUsername(){
         $userNumber = $_SESSION['usernr'];
         $getUser = [];

         if ($handle = fopen("users.csv", "r")) {
             while (($data = fgetcsv($handle, 1000, ",")) !==FALSE) {
                 $getUser[] = $data;
             }
         }
         print_r($userNumber[3]);
     }

function readValue($filename, $sort){
    $readValue = [];
    if ($handle = fopen($filename, "r")){
        while (($data = fgetcsv($handle, 1000,",")) !==FALSE){
            $readValue[] = $data;
        }
    }
    $j = 0;
    while ($j < count($readValue)) {
        echo $readValue[$j][$sort];
        echo ",";
        $j++;
    }
    fclose($handle);
}

function readData($filename){
    $readData = [];

    if ($handle = fopen($filename, "r")) {
        while (($data = fgetcsv($handle, 1000, ",")) !==FALSE) {
            $readData[] = $data;
        }
    }
    $i = 0;
    while($i < count($readData)){
        echo "<tr class='values' style=''>";
        echo "<td style='text-align: center'>" . $readData[$i][1] . "</td>";
        echo "<td style='text-align: center'>" . $readData[$i][2] . "</td>";
        echo "</tr>";
        $i++;
    }
    fclose($handle);
}
?>
    <div class="sidenav">
        <a href='query1.php'>Query 1</a>
        <a href='query2.php'>Query 2</a>
        <p class="welcomeName">Welcome <?php
                getUsername();
            ?>
            <br>Click here to log out
        </p>
        <a href="index.php"><img id="SettingsIcon" src="img/logout.png"></a>
    </div>
    <div id="Tooltips">
        <p id="Tooltip-text">Bar Chart</p>
    </div>
    <div class="topnav">
        <li><button id="bar"><img id="iconVisual" src="img/graph.png"></button></li>
        <li><button id="line"><img id="iconVisual" src="img/lineChartIcon.png"></button></li>
        <li><button id="pie"><img id="iconVisual" src="img/pieChartIcon.png"></button></li>
        <li><button id="map"><img id="iconVisual" src="img/map.png"></button></li>
    </div>
    <!-- Page content -->
    <div id="main">
        ...
    </div>
</body>
<script type="text/javascript">
    $("#cssmenu").menumaker();
</script>
</html>