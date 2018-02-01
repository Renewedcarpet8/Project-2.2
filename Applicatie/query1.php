<!DOCTYPE html>
<html lang="en">
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
          <img class="schoollogographmode" src="img/schoollogo-small.png">
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
            echo "<tr class='values' style=''>";
            echo "<td style='text-align: center'>" . $readData[$i][1] . "</td>";
            echo "<td style='text-align: center'>" . $readData[$i][2] . "</td>";
            echo "</tr>";
            $i++;
        }
        fclose($handle);
    }
    ?>

          <?php
          require 'requirebars.php'
          ?>
  <div class="container-graph"><div class="menu-icon"><span></span></div></div>

  <div class="dashboard-graph" method="POST">
      <H1>Graph Viewer</br> </br></H1>
      <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
      </p>
      <div class="cont">
          <canvas id="myChart"></canvas>
      </div>
  </div>
    


  <script>
    let myChart = document.getElementById('myChart').getContext('2d');

    // Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#FFF';

    let massPopChart = new Chart(myChart, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:['01-01-2018', '02-01-2018', '03-01-2018', '04-01-2018', '05-01-2018', '06-01-2018'],
        datasets:[{
          label:'Numbers per date',
          data:[
            24,
            25,
            27,
            35,
            23,
            26

          ],
          //backgroundColor:'green',
          backgroundColor:[
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)'
          ],
          borderWidth:1,
          borderColor:'#FFF',
          hoverBorderWidth:3,
          hoverBorderColor:'#FFF'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Random numbers',
          fontSize:25
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000'
          }
        },
        layout:{
          padding:{
            left:50,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
  </script>
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
                  <?php
                  echo readData();
                  ?>
          </div>
      </div>



      <div class="underlay-photo"></div>
      <div class="underlay-black"></div>
  </div>
</body>
</html>