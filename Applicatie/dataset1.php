<?php
    function getOverview() {
        $stationData = array();

        $stations = fopen("stations.csv", 'r');
        while (($line = fgetcsv($stations, 0, "%")) !== FALSE) {
            $stationData[$line[0]] = new StationData($line[0], $line[2], $line[1], 0);
        }

        $csv_data = fopen("http://localhost/weather/" . date("Y/m/d/") . "19/MOLDOVA.csv", 'r');

        while (($line = fgetcsv($csv_data)) !== FALSE) {
            if ($line[5] > $stationData[$line[2]]->getMaxhPa())
                $stationData[$line[2]]->setMaxhPa($line[5]);
        }

        echo "<tr class='values' style=''>";
        echo "<th style='text-align: center;'>Station </th>";
        echo "<th style='text-align: center;'>Country</th>";
        echo "<th style='text-align: center;'>Region</th>";
        echo "<th style='text-align: center;'>Max hPa</th>";
        echo "</tr>";

        foreach ($stationData as $station) {
            echo "<tr>";
            echo "<td><a href='query2.php?id=" . $station->getStationId() . "&country=" . $station->getCountry() .  "'>"  . $station->getStationId() . "</a></td>";
            echo "<td>" . $station->getCountry() . "</td>";
            echo "<td>" . $station->getRegion(). "</td>";
            echo "<td>" . $station->getMaxhPa(). "</td>";
            echo "</tr>";
        }
    }


    function getMinValue($id, $country, $type){
        $minValue = array();

        $csv_data = fopen("http://localhost/weather/" . date("Y/m/d/") . "19/$country.csv", 'r');
        $weekLength = 7*24*60*60;
        $currentDate = date('U');

        while (($line = fgetcsv($csv_data)) !== FALSE){
            $date = date('U', strtotime($line[1]));
            if ($date >= ($currentDate-$weekLength) &&$line[2] == $id){
                if (count($minValue) < 1){
                    array_push($minValue, $line[$type]);
                } else {
                    if ($line[$type] > $minValue){
                        array_pop($minValue);
                        array_push($minValue, $line[$type]);

                    }
                }
            }
        }
        echo $minValue[0];
    }

    function getMaxValue($id, $country, $type){
        $maxValue = array();

        $csv_data = fopen("http://localhost/weather/" . date("Y/m/d/") . "19/$country.csv", 'r');
        $weekLength = 7*24*60*60;
        $currentDate = date('U');

        while (($line = fgetcsv($csv_data)) !== FALSE){
            $date = date('U', strtotime($line[1]));
            if ($date >= ($currentDate-$weekLength) &&$line[2] == $id){
                if (count($maxValue) < 1){
                    array_push($maxValue, $line[$type]);
                } else {
                    if ($line[$type] < $maxValue){
                        array_pop($maxValue);
                        array_push($maxValue, $line[$type]);

                    }
                }
            }
        }
        echo $maxValue[0];
    }

