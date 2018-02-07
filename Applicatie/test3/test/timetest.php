<?php

    function getAirPressure()
    {
        $stations = fopen("stations.csv", 'r');
        //$csv_data = fopen(date("G") . '.csv', 'r');
        $csv_data = fopen('16.csv', 'r'); //fopen("/mnt/weather-data/" . date("Y/m/d/G") . ".csv", 'r');
        $nations = array("ROMANIA", "MOLDOVA", "UKRAINE", "BELARUS", "RUSSIA", "BULGARIA", "HUNGARY", "POLAND", "ROMANIA", "SLOVAKIA", "CZECH REPUBLIC");
        $data = array();
        while (($line = fgetcsv($csv_data)) !== FALSE) {
            if (!array_key_exists($line[2], $data) || $line[5] > $data[$line[2]]) {
                $data[$line[2]] = $line[5];
            }

        }

        echo "<table class='stations'>\n\n";
        echo "<tr><th>ID</th><th>Country</th><th>Region</th><th>Max hPa</th></tr>\n";

        while (($line = fgetcsv($stations)) !== FALSE) {
            for ($i = 0; $i < count($nations) - 1; $i++)
                if ($line[2] == $nations[$i]) {
                    echo "<tr>";
                    echo "<td>" . "<a href='station.php/?id=" . $line[0] . "'>" . $line[0] . "</td>";
                    echo "<td>" . $line[2] . "</td>";
                    echo "<td>" . $line[1] . "</td>";
                    if (array_key_exists($line[0], $data))
                        echo "<td>" . $data[$line[0]] . " " . "hPa" . "</td>";
                    else
                        echo "<td>No data yet</td>";
                    echo "</tr>\n";
                }
        }

        fclose($stations);
        fclose($csv_data);
        echo "\n</table>";
    }
    ?>

<?php

    function getLangLong()
    {
        $stations = fopen("stations.csv", 'r');
        //$csv_data = fopen(date("G") . '.csv', 'r');
        $csv_data = fopen('16.csv', 'r'); //fopen("/mnt/weather-data/" . date("Y/m/d/G") . ".csv", 'r');
        $nations = array("ROMANIA", "MOLDOVA", "UKRAINE", "BULGARIA", "HUNGARY", "POLAND", "SLOVAKIA", "CZECH REPUBLIC", "ALBANIA", "BOSNIA AND HERZEGOVINA", "CROATIA", "ESTONIA", "LATVIA", "LITHUANIA", "MACEDONIA", "MONTENEGRO", "SERBIA", "SLOVENIA", "");
        $data = array();
        while (($line = fgetcsv($csv_data)) !== FALSE) {
            if (!array_key_exists($line[2], $data) || $line[5] > $data[$line[2]]) {
                $data[$line[2]] = $line[5];
            }

        }


        while (($line = fgetcsv($stations)) !== FALSE) {
            for ($i = 0; $i < count($nations) - 1; $i++)
                if ($line[2] == $nations[$i]) {
                    //echo $line[2] . " ";
                    //echo $line[3] . "," .$line[4]."<br>";
                    echo  'id="'. $line[0] . '"' . ' place="'. $line[1] . '"' . ' country="'. $line[2] . '"' . ' lat="'. $line[3] . '"' . ' lng="'. $line[4] . '"' . ' elevation="'. $line[5] . '"/>' . '<br>';


                }
        }

        fclose($stations);
        fclose($csv_data);
    }
    function getInfo($id){
        $stations = fopen("stations.csv", 'r');
        //$csv_data = fopen(date("G") . '.csv', 'r');
        $csv_data = fopen('16.csv', 'r'); //fopen("/mnt/weather-data/" . date("Y/m/d/G") . ".csv", 'r');
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
<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 60%;
            width: 60%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #test {
            height: 60%;
            width: 30%;
            margin-left: 65%;
            border: 1px solid black;
        }

    </style>
</head>

<body>

<div id="map"></div>
<div id="test">
    <?php
        getInfo($_GET['id']);
    ?>
</div>

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
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(51.391423, 27.175312),
            zoom: 5
        });
        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        downloadUrl('test2.xml', function(data) {
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
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                    window.location.href = "timetest.php?id=" + id;
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
</body>
</html>