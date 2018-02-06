<!DOCTYPE html>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.0.1/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
          <img class="schoollogographmode" src="img/schoollogo-small.png">


          <?php
          require 'requirebars.php'
          ?>
  <div class="container-graph"><div class="menu-icon"><span></span></div></div>


  <div id="dashboard-graph" method="POST">
      <H1 class="stayFront">Graph Viewer</br> </br></H1>
<div id="googleMap"> </div>

<script>
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
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
                  echo readData("data1.csv");
                  ?>
          </div>
      </div>



      <div class="underlay-photo"></div>
      <div class="underlay-black"></div>
</body>
</html>