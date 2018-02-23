<?php
require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
//echo dirname(__FILE__);
//exit;
//echo date("F j, Y, g:i:s", time()) . '<br />';
//echo date("F j, Y, G:i:s", 1504830600-4*60*60) . '<br />';
$unixTime = time()-4*60*60;/*ora de pe coasta de west este cu 4 in urma dar am luat ca sa fie cuprinzator*/

$year_to_check = date("Y",$unixTime);
$month_to_check = date("n",$unixTime);
$day_to_check = date("d",$unixTime);

//echo $day;
//exit;

$api_key = 'omBLjrHGAufvxJgEidThzY2P7c3KlwCN';

$url = 'https://profootballapi.com/schedule';

$query_string = 'api_key='.$api_key.'&year='.$year_to_check.'&month='.$month_to_check.'&day='.$day_to_check;

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
//exit;

$week = 0;
$year = 0;
$season_type = 0;

if($params[0]['week']) {
    $week = $params[0]['week'];
    $year = $params[0]['year'];
    $season_type = $params[0]['season_type'];
}else {
    $day_to_check -= 1;/*incercam si ptr ieri*/
    
    $query_string = 'api_key='.$api_key.'&year='.$year_to_check.'&month='.$month_to_check.'&day='.$day_to_check;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    curl_close($ch);

    //echo $result;
    $params = json_decode($result, true);
    
    if($params[0]['week']) {
        $week = $params[0]['week'];
        $year = $params[0]['year'];
        $season_type = $params[0]['season_type'];
    }
    
}

//echo '<pre>'; print_r($season_type); echo '</pre>'; 
//exit;

$option_name = array('week_for_grab_user_data', 'year_for_grab_user_data', 'season_type_for_grab_user_data') ;
$new_value = array($week, $year, $season_type) ;

//echo '<pre>'; print_r($option_name); echo '</pre>'; 
//echo '<pre>'; print_r($new_value); echo '</pre>';
//
//exit;

foreach($option_name as $k=>$v) {
    if ( get_option( $v ) !== false ) {
//        echo 'update '.$option_name[$k] .' '.$v.' '.$new_value[$k].'<br />';
        // The option already exists, so we just update it.
        update_option( $v, $new_value[$k] );

    } else {
//echo 'insert '.$option_name[$k] .' '.$v.' '.$new_value[$k].'<br />';
        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option( $v, $new_value[$k], $deprecated, $autoload );
    }
}

?>