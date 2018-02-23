<?php
require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );

//$year = 2017;
//$week = 2;
//$season_type = 'REG';

$week = get_option('week_for_grab_user_data');
$year = get_option('year_for_grab_user_data');
$season_type = get_option('season_type_for_grab_user_data');

if( $week == false ) {$week = 0;}
if( $year == false ) {$year = 0;}
if( $season_type == false ) {$year = 0;}

if(!empty($week) && !empty($year) && !empty($season_type)) {

    $api_key = 'omBLjrHGAufvxJgEidThzY2P7c3KlwCN';

    $url = 'https://profootballapi.com/players';

    $query_string = 'api_key='.$api_key.'&stats_type=offense&week='.$week.'&year='.$year.'&season_type='.$season_type;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    curl_close($ch);

    $params = json_decode($result, true);
    //echo '<pre>'; print_r($params); echo '</pre>'; 

    $sql_db_players = "
        SELECT T1.ID, T1.meta_value AS id_nfl, T2.id_player_score, T2.score 
                FROM ( SELECT * FROM " . $wpdb->prefix . "posts AS T1
                            LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                                WHERE T2.meta_key = 'id_nfl') AS T1 
                            LEFT JOIN (SELECT * FROM " . $wpdb->prefix . "players_score 
                                    WHERE season_type = '{$season_type}'
                                    AND week = {$week}
                                    AND year = {$year}) AS T2 ON T1.ID = T2.id_wp_player

                    ";
    $db_players = $wpdb->get_results( $sql_db_players );

//    echo '<pre>'; print_r($db_players); echo '</pre>';
    //exit;

    foreach($params as $date_play=>$v) {
        $month = (int)substr($date_play, 4, 2);
        $day = (int)substr($date_play, 6, 2);
        foreach($v as $id_nfl=>$vv) {/*pentru fiecare player*/
            $score = 0;
            $pa = $pc = $py = $pt = $pi = $ptp = 0;
            $ra = $ry = $rt = $rtp = 0;
            $rer = $rey = $ret = $retp = 0;
            $ffl = 0;
            foreach($vv as $type=>$vvv) {
                if($type === "passing") {
                    foreach($vvv as $k=>$vvvv) {
                       if($k === 'name') {$nfl_name = $vvvv;} 
                       if($k === 'attempts') {$pa = $vvvv;}
                       if($k === 'completions') {$pc = $vvvv;}
                       if($k === 'yards') {$py = $vvvv; $score += $vvvv/25;} 
                       if($k === 'touchdowns') {$pt = $vvvv; $score += $vvvv*4;} 
                       if($k === 'interceptions') {$pi = $vvvv; $score -= $vvvv*2;}
                       if($k === 'two_point_makes') {$ptp = $vvvv; $score += $vvvv*2;} 
                    }
                }
                if($type === "rushing") {
                    foreach($vvv as $k=>$vvvv) {
                       if($k === 'name') {$nfl_name = $vvvv;} 
                       if($k === 'attempts') {$ra = $vvvv;}
                        if($k === 'yards') {$ry = $vvvv;$score += $vvvv/10;} 
                        if($k === 'touchdowns') {$rt = $vvvv; $score += $vvvv*6;} 
                        if($k === 'two_point_makes') {$rtp = $vvvv; $score += $vvvv*2;}
                     }
                 }
                 if($type === "receiving") {
                     foreach($vvv as $k=>$vvvv) {
                        if($k === 'name') {$nfl_name = $vvvv;} 
                        if($k === 'receptions') {$rer = $vvvv; $score += $vvvv;} 
                        if($k === 'yards') {$rey = $vvvv; $score += $vvvv/10;} 
                        if($k === 'touchdowns') {$ret = $vvvv; $score += $vvvv*6;} 
                        if($k === 'two_point_makes') {$retp = $vvvv; $score += $vvvv*2;}
                     }
                 }
                 if($type === "fumbles") {
                     foreach($vvv as $k=>$vvvv) {
                        if($k === 'name') {$nfl_name = $vvvv;} 
                        if($k === 'fumbles_lost') {$ffl = $vvvv; $score -= $vvvv*2;} 
                     }
                 }
             }
//             $score = round($score,2);
            /*Aici adaugam punctajul in baza de date

             * 1 verificam daca este in $db_players un player cu $id_nfl
             *      1.1 DA $score e mai mare ca scorul existent in $db_players?
             *          1.1.1 DA - actualizam scorul
             *          1.1.2 NU - nu facem nimic
             *      1.2 NU - dam un mail cu ID user
             *                 
             * 
             */
        
            foreach($db_players as $dbp) {
                if($dbp->id_nfl === $id_nfl) {
                    if($dbp->id_player_score) {/*update*/
                        if($score > $dbp->score ) {
                            $wpdb->update( 
                                    $wpdb->prefix . 'players_score', 
                                    array( 
                                            'season_type' => $season_type,
                                            'week' => $week,
                                            'day' => $day,
                                            'month' => $month,
                                            'year' => $year,
                                            'unixtime' => strtotime($year."-".$month."-".$day),
                                            'passing_attempts' => $pa,
                                            'passing_completions' => $pc,
                                            'passing_yards' => $py,
                                            'passing_touchdowns' => $pt,
                                            'passing_interceptions' => $pi,
                                            'passing_two_point_makes' => $ptp,
                                            'rushing_attempts' => $ra,
                                            'rushing_yards' => $ry,
                                            'rushing_touchdowns' => $rt,
                                            'rushing_two_point_makes' => $rtp,
                                            'receiving_receptions' => $rer,
                                            'receiving_yards' => $rey,
                                            'receiving_touchdowns' => $ret,
                                            'receiving_two_point_makes' => $retp,
                                            'fumbles_lost' => $ffl,
                                            'score' => $score
                                    ), 
                                    array( 'id_player_score' => $dbp->id_player_score ), 
                                    array( 
                                            '%s',
                                            '%d',
                                            '%d',
                                            '%d',
                                            '%d',
                                            '%d',
                                            '%d','%d','%d','%d','%d','%d',
                                            '%d','%d','%d','%d',
                                            '%d','%d','%d','%d',
                                            '%d',
                                            '%f'
                                    ), 
                                    array( '%d' ) 
                            );
                        }
                    }else {
                        $wpdb->query( $wpdb->prepare( 
                        "
                                INSERT INTO " . $wpdb->prefix . "players_score
                                ( 
                                    id_wp_player, 
                                    season_type,
                                    week,
                                    day,
                                    month,
                                    year,
                                    unixtime,
                                    passing_attempts,
                                    passing_completions,
                                    passing_yards,
                                    passing_touchdowns,
                                    passing_interceptions,
                                    passing_two_point_makes,
                                    rushing_attempts,
                                    rushing_yards,
                                    rushing_touchdowns,
                                    rushing_two_point_makes,
                                    receiving_receptions,
                                    receiving_yards,
                                    receiving_touchdowns,
                                    receiving_two_point_makes,
                                    fumbles_lost,
                                    score
                                )
                                VALUES ( 
                                    %d, 
                                    %s,
                                    %d,
                                    %d,
                                    %d,
                                    %d, 
                                    %d, 
                                    %d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,
                                    %d,%d,%d,%d,
                                    %d,
                                    %f
                                )
                            ", 
                            $dbp->ID, 
                            $season_type,
                            $week,
                            $day,
                            $month,
                            $year,
                            strtotime($year."-".$month."-".$day),
                            $pa, $pc, $py, $pt, $pi, $ptp,
                            $ra, $ry, $rt, $rtp,
                            $rer, $rey, $ret, $retp,
                            $ffl,
                            $score
                        ) ); 
                    }
                    break;
                }
            }
        }
    }
}

?>