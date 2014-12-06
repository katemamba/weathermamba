<?php

$data1 = file_get_contents('ftp://w1.weather.gov/obhistory/KIKV.html');
$data2 = file_get_contents('ftp://www1.ncdc.noaa.gov/pub/data/swdi/stormevents/csvfiles/legacy/');
$data3 = file_get_contents('ftp://isgs.illinois.edu/maps/gis');

$regex = '/<td>(.+?) <\/td>/';

preg_match($regex,$data,$match);
$kate = preg_match($regex,$data1,$match)+preg_match($regex,$data2,$match)+preg_match($regex,$data3,$match);


var_dump($match);
var_dump($kate);
echo $match[1];
$citymeri1 = reg_exp_call($kate,"%%city%%"||"%%cities%%"||"%%location%%");
$timemera1 = reg_exp_call($kate,"%%time%%"||"%%timezone%%"||"%%duration%%");
$eventmera1 =reg_exp_call($kate,$eventuska);
///echo "PAVAN KATE ----------->12;";

?>