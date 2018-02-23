<?php

echo date("Y-m-d",time());

$api_key = 'omBLjrHGAufvxJgEidThzY2P7c3KlwCN';

$url = 'https://profootballapi.com/players';

$query_string = 'api_key='.$api_key.'&stats_type=passing&stats_type=offense&week=1&year=2017&season_type=REG';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

curl_close($ch);

//echo $result;
$params = json_decode($result, true);
echo '<pre>'; print_r($params); echo '</pre>'; 
 
?>
