<?php
//get the variables from the form
$latitude1 = $_POST['latitude1'];
$longitude1 = $_POST['longitude1'];
$latitude2 = $_POST['latitude2'];
$longitude2 = $_POST['longitude2'];

//variables
$quadrant1 = "";
$quadrant2 ="";
$bearing = "";
$geodesic= "";
$null = FALSE;
$outRange = FALSE;
$show = FALSE;

//check if any field was left blank or if there was non numeric values
if ((empty($latitude1) && $latitude1 != 0) || (empty($latitude2)&& $latitude2 != 0) || (empty($longitude1) && $longitude1 != 0) || (empty($longitude2) && $longitude2!=0) || !is_numeric($latitude1) || !is_numeric($latitude2) || !is_numeric($longitude1) || !is_numeric($longitude2)){
  $null = TRUE;
}

//convert the points from string to float
$latitude1 = (float)$latitude1;
$longitude1 = (float)$longitude1;
$latitude2 = (float)$latitude2;
$longitude2 = (float)$longitude2;

//check if any field was out of longitude or latitude range
if (($latitude1>90 || $latitude1<-90) || ($latitude2>90 || $latitude2<-90) || ($longitude1>180 || $longitude1<-180) || ($longitude2>180 || $longitude2<-180)){
  $outRange = TRUE;
}


if (!$outRange && !$null){
  //quadrant of point 1
  if ($latitude1 > 0 && $longitude1 > 0){
    $quadrant1 = 1;
  }
  else if ($latitude1 < 0 && $longitude1 > 0){
    $quadrant1 = 4;
  }
  else if ($latitude1 < 0 && $longitude1 < 0){
    $quadrant1 = 3;
  }
  else if ($latitude1 > 0 && $longitude1 < 0){
    $quadrant1 = 2;
  }
  else{
    $quadrant1 = "NA - point is on an axis";
  }

  //quadrant of point 2
  if ($latitude2 > 0 && $longitude2 > 0){
    $quadrant2 = 1;
  }
  else if ($latitude2 < 0 && $longitude2 > 0){
    $quadrant2 = 4;
  }
  else if ($latitude2 < 0 && $longitude2 < 0){
    $quadrant2 = 3;
  }
  else if ($latitude2 > 0 && $longitude2 < 0){
    $quadrant2 = 2;
  }
  else{
    $quadrant2 = "NA - point is on an axis";
  }

  //convert the degree values to radians
  $latitude1 = deg2rad($latitude1);
  $longitude1 = deg2rad($longitude1);
  $latitude2 = deg2rad($latitude2);
  $longitude2 = deg2rad($longitude2);

  //bearing
  $x = cos($latitude2)*sin(($longitude2-$longitude1));
  $y = cos($latitude1)*sin($latitude2) - sin($latitude1)*cos($latitude2)*cos(($longitude2-$longitude1));
  $bearing = atan2($x, $y);

  //geodesic distance
  $dlong = $longitude2 - $longitude1;
  $dlat = $latitude2 - $latitude1;
  $a = (sin($dlat/2)*sin($dlat/2)) + (cos($latitude1)*cos($latitude2)*(sin($dlong/2)*sin($dlong/2)));
  $c = 2*asin(min(1, sqrt($a)));
  $d = 6373*$c;     //6373 is the spherical earth radius
  $geodesic = $d;

  $show = TRUE;

}

if ($null){
  $null = FALSE;
  $outRange = FALSE;
  echo "<script type='text/javascript'>alert('A field was left blank or had invalid characters, please try again!!')
  window.location = 'Task4.html';</script>";
}
else if($outRange)
{
  $null = FALSE;
  $outRange = FALSE;
  echo "<script type='text/javascript'>alert('Parameters not in range, please try again! Latitudes should be between -90 and +90 and longitudes between -180 and +180')
  window.location = 'Task4.html';</script>";
}
else if ($show){
  $show = FALSE;
  echo "<hr>RESULTS:<hr>";
  echo "<br>Quadrant of point 1: " .$quadrant1;
  echo "<br>Quadrant of point 2: " .$quadrant2;
  echo "<br>Bearing between points: " .round(rad2deg($bearing), 2 ,PHP_ROUND_HALF_UP). " degrees";
  echo "<br>Geodesic distance between points: " .round($geodesic, 2 ,PHP_ROUND_HALF_UP). " km";
}

?>

<html>
<body style = "background-color:#94B5EF">

</body>
</html>
