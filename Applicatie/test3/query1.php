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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.0.1/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <?php
    session_start();
    require 'requirebars.php';
    if (isset($_SESSION['username'])){

    function getInfo($id){
        $stations = fopen("./test/stations.csv", 'r');
        //$csv_data = fopen(date("G") . '.csv', 'r');
        $csv_data = fopen('./test/16.csv', 'r'); //fopen("/mnt/weather-data/" . date("Y/m/d/G") . ".csv", 'r');
        $nations = array("ROMANIA", "MOLDOVA", "UKRAINE", "BULGARIA", "HUNGARY", "POLAND", "SLOVAKIA", "CZECH REPUBLIC", "ALBANIA", "BOSNIA AND HERZEGOVINA", "CROATIA", "ESTONIA", "LATVIA", "LITHUANIA", "MACEDONIA", "MONTENEGRO", "SERBIA", "SLOVENIA", "");
        $directions = array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
        $data = array();
        $line2 = fgetcsv($stations);
        while (($line = fgetcsv($csv_data)) !== FALSE) {
            if ($line[2] == $id) {
                echo "Date: " . $line[0] . "<br>";
                echo "Time: " . $line[1] . "<br>";
                echo "Station: " . $line[2] . "<br>";
                echo "Temp: " . $line[3] . "<br>";
                echo "Dewpoint: " . $line[4] . "<br>";
                echo "Pressure station: " . $line[5] . "<br>";
                echo "Pressure sea: " . $line[6] . "<br>";
                echo "Visibility: " . $line[7] . "<br>";
                echo "Wind: " . $line[8] . "<br>";
                echo "Rainfall: " . $line[9] . "<br>";
                echo "Snowfall: " . $line[10] . "<br>";
                echo "Flags: " . $line[11] . "<br>";
                echo "Cloud cover: " . $line[12] . "<br>";
                echo "Wind Direction: " . $directions[(int)(($line[13]/22.5)+.5)%16] . "<br>";
            }
            /*while (($line = fgetcsv($stations)) !== FALSE) {
                for ($i = 0; $i < count($nations) - 1; $i++)
                    if ($line[0] == $nations[$i]) {
                        echo $line[2];
                    //echo $line[2] . " ";
                        //echo $line[3] . "," .$line[4]."<br>";
                       // echo  'id="'. $line[0] . '"' . ' place="'. $line[1] . '"' . ' country="'. $line[2] . '"' . ' lat="'. $line[3] . '"' . ' lng="'. $line[4] . '"' . ' elevation="'. $line[5] . '"/>' . '<br>';


                    } else {
                    var_dump($line);
                    }*/
        }
        fclose($stations);
        fclose($csv_data);

    }
    ?>
    <img class="schoollogographmode" src="img/schoollogo-small.png">

    <div class="container-graph"><div class="menu-icon"><span></span></div></div>


    <div id="dashboard-graph" method="POST">
      <H1 class="">Graph Viewer</br> </br></H1>
    <div id="googleMap"> </div>

        <script>
            var customLabel = {
                restaurant: {
                    label: 'R'
                },
                bar: {
                    label: 'B'
                }
            };

            function initMap() {
                var map = new google.maps.Map(document.getElementById('googleMap'), {
                    center: new google.maps.LatLng(51.391423, 27.175312),
                    zoom: 5
                });
                var infoWindow = new google.maps.InfoWindow;

                // Change this depending on the name of your PHP or XML file
                downloadUrl('test.xml', function(data) {
                    var xml = data.responseXML;
                    var markers = xml.documentElement.getElementsByTagName('marker');
                    Array.prototype.forEach.call(markers, function(markerElem) {
                        var id = markerElem.getAttribute('id');
                        var place = markerElem.getAttribute('place');
                        var country = markerElem.getAttribute('country');
                        var type = markerElem.getAttribute('type');
                        var point = new google.maps.LatLng(
                            parseFloat(markerElem.getAttribute('lat')),
                            parseFloat(markerElem.getAttribute('lng')));

                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = id
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');
                        text.textContent = place
                        infowincontent.appendChild(text);
                        var icon = customLabel[type] || {};
                        var marker = new google.maps.Marker({
                            map: googleMap,
                            position: point,
                            label: icon.label
                        });
                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                            window.location.href = "query1.php?id=" + id;
                        });

                    });

                });
            }



            function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;

                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = doNothing;
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            }

            function doNothing() {}
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6S_YXL2ge22s_tfI1o43iIEQur5bEoCo&callback=initMap">

        </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6S_YXL2ge22s_tfI1o43iIEQur5bEoCo&callback=myMap"></script>
      <span class='fa-stack fa-lg'>


                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
      </p>
      <div class="cont">
          <canvas id="myChart" style="height: 1%;"></canvas>

      </div>

  </div>
    


  <script>
      // GLobal Options
      Chart.defaults.global.defaultFontFamily = 'Lato';
      Chart.defaults.global.defaultFontSize = 18;
      Chart.defaults.global.defaultFontColor = '#FFF';
      var config = {
          type: 'line',
          data: {
              labels: [<?php readValue("data1.csv", 1)?>],
              datasets: [{
                  label: "Numbers per date",
                  data: [ <?php readValue("data1.csv", 2) ?>],
                  fill: true,
                  borderColor: "purple",
                  backgroundColor:[
                      'rgba(255, 99, 132, 0.6)',
                      'rgba(54, 162, 235, 0.6)',
                      'rgba(255, 206, 86, 0.6)',
                      'rgba(75, 192, 192, 0.6)',
                      'rgba(153, 102, 255, 0.6)',
                      'rgba(255, 159, 64, 0.6)',
                      'rgba(255, 99, 132, 0.6)'
                  ],
                  borderwidth:1,
                  borderColor:'#FFF',
                  hoverBorderWidth:3,
                  hoverBorderColor:"#FFF",
              }]
          },
          options: {
              //responsive: true
              title:{
                  display:true,
                  text:'Random numbers',
                  fontsize:25
              },
              legend:{
                  display:true,
                  position:'right',
                  labels:{
                      fontColor:'#000'
                  }
              },
              layout:{
                  responsive: true,
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
      };

      var myChart;

      $("#line").click(function() {
      $("#googleMap").removeClass("fullscreen");
          change('line');
      });

      $("#bar").click(function() {
          $("#googleMap").removeClass("fullscreen");
          change('bar');
      });
      $("#pie").click(function() { 
          $("#googleMap").removeClass("fullscreen");
        google.maps.event.trigger(map, 'resize');
          change('pie');
      });
      
      $("#map").click(function() {
        $("#googleMap").toggleClass("fullscreen");
        google.maps.event.trigger(map, 'resize');
        change('');
        }
      );

      function change(newType) {
          var ctx = document.getElementById("myChart").getContext("2d");

          // Remove the old chart and all its event handles
          if (myChart) {
              myChart.destroy();
          }

          // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
          var temp = jQuery.extend(true, {}, config);
          temp.type = newType;
          myChart = new Chart(ctx, temp);
      };

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
              <H1>Values</br> </H1>
              <span class='fa-stack fa-lg'>
                            <i class='fa fa=circle fa-stack-2x'></i>
                            <i class='fa fa-lock fa-stack-1x'</i>
                        </span>
              </p>
              <table class ='values'>

                  <th> Date </th>
                  <th> Value</th>
                  <?php
                    if (isset($_GET['id'])) {
                        getInfo($_GET['id']);
                    }
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
