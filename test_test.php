<?php

require_once( dirname(__FILE__) . '/wp-load.php' );

$contest_id = 606;

$contest_data_sql = "
        SELECT T2.meta_value AS start_date, T3.meta_value AS end_date FROM " . $wpdb->prefix . "posts AS T1
            LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                LEFT JOIN " . $wpdb->prefix . "postmeta AS T3 ON T1.ID = T3.post_id
                    WHERE T1.ID = {$contest_id} 
                        AND T2.meta_key = 'start_date'
                            AND T3.meta_key = 'end_date'
                            LIMIT 1
        ";
$contest_data = $wpdb->get_results( $contest_data_sql );

$start_date = explode('-', $contest_data[0]->start_date);
$start_date_year = $start_date[0];
$start_date_month = $start_date[1];
$start_date_day = $start_date[2];

$end_date = explode('-', $contest_data[0]->end_date);
$end_date_year = $end_date[0];
$end_date_month = $end_date[1];
$end_date_day = $end_date[2];

//echo '<pre>'; print_r($start_date[0]); echo '</pre>';
//echo '<pre>'; print_r($start_date[1]); echo '</pre>';
//echo '<pre>'; print_r($start_date[2]); echo '</pre>';
    
$scorul_pe_o_perioada_sql = "
        SELECT id_wp_player, SUM(score) as all_score 
            FROM " . $wpdb->prefix . "players_score 
            WHERE (day >= {$start_date_day} && day <= {$end_date_day}) 
                AND (month >= {$start_date_month} && month <= $end_date_month) 
                AND (year >= {$start_date_year} && year <= {$end_date_year}) 
                GROUP BY id_wp_player
        ";
$scorul_pe_o_perioada = $wpdb->get_results( $scorul_pe_o_perioada_sql );
$players_score_array = array();
foreach($scorul_pe_o_perioada as $v) {
    $players_score_array[$v->id_wp_player] = round($v->all_score, 2);
}

echo '<pre>'; print_r($scorul_pe_o_perioada); echo '</pre>'; 


$toti_participantii_pentru_un_contest_sql = "
            SELECT * FROM " . $wpdb->prefix . "participants WHERE id_contest= {$contest_id};
        ";
$toti_participantii_pentru_un_contest = $wpdb->get_results( $toti_participantii_pentru_un_contest_sql );

//echo '<pre>'; print_r($toti_participantii_pentru_un_contest); echo '</pre>'; 

$participantii_array = array();

foreach($toti_participantii_pentru_un_contest as $v) {
    $ar = array();
    $ar['id_user'] = $v->id_user;
    $ar['id_player_qbf'] = $v->id_player_qbf;
    $ar['id_player_qbs'] = $v->id_player_qbs;
    $ar['id_player_rbf'] = $v->id_player_rbf;
    $ar['id_player_rbs'] = $v->id_player_rbs;
    $ar['id_player_wrf'] = $v->id_player_wrf;
    $ar['id_player_wrs'] = $v->id_player_wrs;
    $participantii_array[$v->id_participants] = $ar;
}

echo '<pre>'; print_r($participantii_array); echo '</pre>'; 

$participanti_score_array = array();

foreach($toti_participantii_pentru_un_contest as $v) {
    $score = 0;
    $score = $players_score_array[$v->id_player_qbf] + 
                $players_score_array[$v->id_player_qbs] +
                $players_score_array[$v->id_player_rbf] +
                $players_score_array[$v->id_player_rbs] +
                $players_score_array[$v->id_player_wrf] +
                $players_score_array[$v->id_player_wrs];
    
    $participanti_score_array[$v->id_participants] = $score;
}

echo '<pre>'; print_r($participanti_score_array); echo '</pre>'; 

$all_users_sql = "SELECT * FROM " . $wpdb->prefix . "users";
$all_users = $wpdb->get_results( $all_users_sql );
$array_users = array();
foreach($all_users as $au) {
    $array_users[$au->ID] = $au->user_nicename;
}

echo '<pre>'; print_r($array_users); echo '</pre>'; 

$all_players_sql = "
        SELECT T1.ID, T1.post_title AS player_name, T3.post_title AS position FROM " . $wpdb->prefix . "posts AS T1
            LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                LEFT JOIN  " . $wpdb->prefix . "posts AS T3 ON T2.meta_value = T3.ID
            WHERE T1.post_type = 'players'
                AND T2.meta_key = 'position' ";

$all_players = $wpdb->get_results( $all_players_sql );

//echo '<pre>'; print_r($all_players); echo '</pre>'; 

$array_players = array();
foreach($all_players as $ap) {
    $arr = array();
    $arr['player_name'] = $ap->player_name;
    $arr['position'] = $ap->position;
    $array_players[$ap->ID] = $arr;
}

echo '<pre>'; print_r($array_players); echo '</pre>'; 


?>