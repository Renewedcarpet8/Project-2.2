      <?php
      /*
      echo "<pre>";
      echo "/mnt/weather-data/" . date("Y/m/d/G") . ".csv";
      */

      $stations = fopen("stations.csv", 'r');
      //$csv_data = fopen(date("G") . '.csv', 'r');
      $csv_data = fopen('16.csv', 'r'); //Dit gaat niet 15.csv worden maar stationID.csv (dus er gaan meerdere .csv open) de code van regel 63/64 kan je daar mogelijk voor gebruiken
      $nations = array("ROMANIA", "MOLDOVA", "UKRAINE", "BELARUS", "RUSSIA");
      $jopData = array();

      while (($line = fgetcsv($csv_data)) !== FALSE) {
          if (!array_key_exists($line[2], $jopData) || $line[5] > $jopData[$line[2]]){
              $jopData[$line[2]] = $line[5];
              }

      }

        echo "<table class='stations'>\n\n";
        echo "<tr><th>ID</th><th>Country</th><th>Region</th><th>Max hPa</th></tr>\n";

      while (($line = fgetcsv($stations)) !== FALSE) {
        for ($i=0; $i < count($nations)-1; $i++)
          if ($line[2] == $nations[$i]) {
                  echo "<tr>";
                  echo "<td>" . "<a href='station.php/?id=" . $line[0] . "'>" . $line[0] . "</td>";
                  echo "<td>" . $line[2] . "</td>";
                  echo "<td>" . $line[1] . "</td>";
                  if (array_key_exists($line[0], $jopData))
                      echo "<td>" . $jopData[$line[0]] . " " . "hPa" . "</td>";
                  else
                      echo "<td>No data yet</td>";
              echo "</tr>\n";
          }
      }

      fclose($stations);
      fclose($csv_data);
            echo "\n</table>";
        ?>


<?php/*
    //Dit kan je gebruiken om de station specifig page te openen
$directions = array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");

            echo "<table style=\"width:100%\">";
            echo "<tr>";
            $f = fopen($_GET["id"] . ".csv", "r"); //*** = chosen station ID .csv
            while (($line = fgetcsv($f)) !== false) {
                    echo "<tr>";
                    echo "<td>" . $line[0] . "</td>";
                    echo "<td>" . $line[1] . "</td>";
                    echo "<td>" . $line[2] . "</td>";
                    echo "<td>" . $line[3] . " " . "&#8451" . "</td>";
                    echo "<td>" . $line[4] . " " . "&#8451" . "</td>";
                    echo "<td>" . $line[5] . " " . "Pa" . "</td>";
                    echo "<td>" . $line[6] . " " . "Pa" . "</td>";
                    echo "<td>" . $line[7] . "</td>";
                    echo "<td>" . $line[8] . "</td>";
                    echo "<td>" . $line[9] . "</td>";
                    echo "<td>" . $line[10] . "</td>";
                    echo "<td>" . $line[11] . "</td>";
                    echo "<td>" . $line[12] . "</td>";
                    echo "<td>" . $directions[(int)(($line[13]/22.5)+.5)%16] . "</td>";
                    echo "</tr>";
                }

            fclose($f);
            echo "\n</table>";
       */ ?>
       */ ?>