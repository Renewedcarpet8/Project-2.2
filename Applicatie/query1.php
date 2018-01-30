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
    function readData(){
        $readData = [];

        if ($handle = fopen("data.csv", "r")) {
            while (($data = fgetcsv($handle, 1000, ",")) !==FALSE) {
                $readData[] = $data;
            }
        }
        $i = 0;
        while($i < count($readData)){
            echo "<tr>";
            echo "<td style='text-align: center'>" . $readData[$i][1] . "</td>";
            echo "<td style='text-align: center'>" . $readData[$i][2] . "</td>";
            echo "</tr>";
            $i++;
        }
        fclose($handle);
    }
    ?>
<div class="sidenav">
    <a href='query1.php'>OPTIE 1</a>";
    <a href='#'>OPTIE 2</a>";
    <a href='#'>OPTIE 3</a>";
    <a href='#'>BLA BLA BLA  </a>
    <img class="SettingsIcon" src="img/settings.png"></a>

</div>

<div class="topnav">
    <li><a href='#' class='t' >WEERGAVE 1</a></li>
    <li><a href='#' class='t' >WEERGAVE 1</a></li>
    <li><a href='#' class='t' >WEERGAVE 1</a></li>
    <li><a href='#' class='t' >WEERGAVE 1</a></li>
</div>

<!-- Page content -->
<div id="main">
    ...
</div>

<div class="container-graph"><div class="menu-icon"><span></span></div></div>

<div class="dashboard-graph" method="POST">
    <H1>GRAFIEK HIER</br> </br></H1>
    <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
    </p>
    <img class='graphplaceholder' src='img/placeholdergraph.png'>


</div>
<div class ="container-control">
    <div class="dashboard-control" method="POST">
        <H1>EXTRA BEDIENING <br> HIER</br> </br></H1>
        <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
        </p>
    </div>
    <div class ="container-values">
        <div class="dashboard-values" method="POST">
            <H1>DATA VALUES HIER</br> </br></H1>
            <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
            </p>
            <table>
                <th> Date </th>
                <th> Value</th>
                <?php
                echo readData();
                ?>
        </div>
    </div>

        <div class="underlay-photo"></div>
        <div class="underlay-black"></div>
        <img class="schoollogographmode" src="img/schoollogo-small.png">
</body>
<script type="text/javascript">
    $("#cssmenu").menumaker();
</script>
</html>

