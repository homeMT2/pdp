<?php

$api_key = 'omBLjrHGAufvxJgEidThzY2P7c3KlwCN';

$url = 'https://profootballapi.com/players';

$query_string = 'api_key='.$api_key.'&stats_type=offense&week=2&year=2017&season_type=REG';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

curl_close($ch);

//echo $result;
$params = json_decode($result, true);
//echo '<pre>'; print_r($params); echo '</pre>'; 

foreach($params as $day=>$v) {
//    echo $day . '<br /><br />';//aici am putea verfica daca se joaca ceva azi -> daca nu ne oprim
    foreach($v as $player_id=>$vv) {/*pentru fiecare player*/
        echo $player_id . '<br />';
        $points = 0;
        foreach($vv as $type=>$vvv) {
            echo $type . '<br />';
            if($type === "passing") {
                foreach($vvv as $k=>$vvvv) {
                   if($k === 'name') {$name = $vvvv;} 
                   if($k === 'yards') {$points += round($vvvv/25, 2); echo 'yards = '. round($vvvv/25, 2) . '<br />';} 
                   if($k === 'touchdowns') {$points += $vvvv*4; echo 'touchdowns = '. $vvvv*4 . '<br />';} 
                   if($k === 'interceptions') {$points -= $vvvv*2; echo 'interceptions = -'. $vvvv*2 . '<br />';}
                   if($k === 'two_point_makes') {$points += $vvvv*2; echo 'two_point_makes = '. $vvvv*2 . '<br />';} 
                }
            }
            if($type === "rushing") {
                foreach($vvv as $k=>$vvvv) {
                   if($k === 'name') {$name = $vvvv;} 
                   if($k === 'yards') {$points += round($vvvv/10, 2); echo 'yards = '. round($vvvv/10, 2) . '<br />';} 
                   if($k === 'touchdowns') {$points += $vvvv*6; echo 'touchdowns = '. $vvvv*6 . '<br />';} 
                   if($k === 'two_point_makes') {$points += $vvvv*2; echo 'two_point_makes = '. $vvvv*2 . '<br />';}
                }
            }
            if($type === "receiving") {
                foreach($vvv as $k=>$vvvv) {
                   if($k === 'name') {$name = $vvvv;} 
                   if($k === 'receptions') {$points += $vvvv; echo 'receptions = '. $vvvv . '<br />';} 
                   if($k === 'yards') {$points += round($vvvv/10, 2); echo 'yards = '. round($vvvv/10, 2) . '<br />';} 
                   if($k === 'touchdowns') {$points += $vvvv*6; echo 'touchdowns = '. $vvvv*6 . '<br />';} 
                   if($k === 'two_point_makes') {$points += $vvvv*2; echo 'two_point_makes = '. $vvvv*2 . '<br />';}
                }
            }
            if($type === "fumbles") {
                foreach($vvv as $k=>$vvvv) {
                   if($k === 'name') {$name = $vvvv;} 
                   if($k === 'fumbles_lost') {$points -= $vvvv*2; echo 'fumbles_lost = -'. $vvvv*2 . '<br />';} 
                }
            }
            echo '<br />';
        }
        echo $name . ' - points - ' . $points . '<br />';
        echo '<br />';
    }
}

?>
