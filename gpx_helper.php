<?php

//pass the GPX file location to the function
function gpxParserTrack($gpxFile) {

  if (!isset($gpxFile)) {
    return false;
  } else {
    //load the file
    $gpx = simplexml_load_file($gpxFile);
    //set a counter
    $i = 0;
    //First, prepare an Array, where we can put all the needed Data.
    $tempArray = array();
    //Second, loop through all the track points adding them to temporary array and if the counter is greater than 1 set the 2nd lat/long pair with the 2nd lat/long pair
    foreach ($gpx->trk->trkseg->trkpt as $point) {
      $tempArray[$i]['lat'] = (string) $point['lat'];
      $tempArray[$i]['lon'] = (string) $point['lon'];
      if ($i > 0) {
        $tempArray[$i - 1]['lat2'] = (string) $point['lat'];
        $tempArray[$i - 1]['lon2'] = (string) $point['lon'];
      }
      $i++;
    }
    return $tempArray;
  }
}

//pass the GPX file location to the function
function gpxParserRoute($gpxFile) {

  if (!isset($gpxFile)) {
    return false;
  } else {
    //load the file
    $gpx = simplexml_load_file($gpxFile);
    //set a counter
    $i = 0;
    //First, prepare an Array, where we can put all the needed Data.
    $tempArray = array();
    //Second, loop through all the waypoints adding them to temporary array and if the counter is greater than 1 set the 2nd lat/long pair with the 2nd lat/long pair
    foreach ($gpx->rte->rtept as $point) {
      $tempArray[$i]['lat'] = (string) $point['lat'];
      $tempArray[$i]['lon'] = (string) $point['lon'];
      if ($i > 0) {
        $tempArray[$i - 1]['lat2'] = (string) $point['lat'];
        $tempArray[$i - 1]['lon2'] = (string) $point['lon'];
      }
      $i++;
    }
    return $tempArray;
  }
}

function get_center($coords)
{
  $count_coords = count($coords);
  $xcos=0.0;
  $ycos=0.0;
  $zsin=0.0;
    foreach ($coords as $lnglat)
    {
        $lat = $lnglat['lat'] * pi() / 180;
        $lon = $lnglat['lon'] * pi() / 180;
        $acos = cos($lat) * cos($lon);
        $bcos = cos($lat) * sin($lon);
        $csin = sin($lat);
        $xcos += $acos;
        $ycos += $bcos;
        $zsin += $csin;
    }
  $xcos /= $count_coords;
  $ycos /= $count_coords;
  $zsin /= $count_coords;
  $lon = atan2($ycos, $xcos);
  $sqrt = sqrt($xcos * $xcos + $ycos * $ycos);
  $lat = atan2($zsin, $sqrt);
  return array($lat * 180 / pi(), $lon * 180 / pi());
}
