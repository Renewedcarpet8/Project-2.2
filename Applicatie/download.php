<!DOCTYPE html>
<html lang="en" manifest="offlineAvailable.appcache">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
$data = ["2018-02-07,01:02:29,30680,-0.2,-2.4,1007.9,1009.5,19.5,18.8,0.01,0.0,110000,50.4,115",
    "2018-02-07,01:02:29,723400,8.8,5.5,1008.0,1017.5,11.9,21.4,0.0,0.0,000000,88.3,341",
    "2018-02-07,01:02:29,574260,3.4,0.2,1025.8,1024.5,10.4,5.6,0.0,0.0,000000,44.8,318",
    "2018-02-07,01:02:29,729350,2.5,-2.2,978.9,998.9,23.9,9.8,0.0,1.9,001000,60.3,183",
    "2018-02-07,01:02:29,83970,4.6,0.2,1012.3,1021.9,8.1,12.5,0.0,0.0,000000,83.6,155",
    "2018-02-07,01:02:29,421310,8.2,0.4,1015.6,1014.8,4.4,4.2,0.0,0.0,000000,62.1,18",
    "2018-02-07,01:02:29,467480,3.0,-0.4,1013.4,1017.3,3.5,11.5,0.0,0.0,000000,28.2,267",
    "2018-02-07,01:02:29,423390,15.6,11.1,1008.5,1013.4,2.9,2.9,0.01,0.0,010000,50.2,358",
    "2018-02-07,01:02:29,23310,-5.8,-6.3,981.7,995.5,9.5,2.7,0.01,0.0,110000,50.3,317",
    "2018-02-07,01:02:29,723965,16.3,11.7,1016.8,1018.8,19.7,9.1,0.01,0.0,010000,66.8,317",
    "2018-02-07,01:02:29,543420,-14.1,-20.7,1023.3,1025.9,5.5,7.8,0.0,0.0,100000,97.2,174"];

$f = fopen("php://output", "w");

foreach ($data as $line) {
    fputcsv($f, explode(",", $line));
}

fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="data.csv";');
fpassthru($f);
?>